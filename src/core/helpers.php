<?php

namespace core\helpers;

use core\view;
use core\cookie;
use core\session;
use core\request;
use core\response;
use app\models\auth_token;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function abort(string $code = '404'): void
{
    response\redirect("/$code");
}

function is_id(int|string $id): bool
{
    return preg_match('/^[1-9]+\d*/', $id);
}

function is_email(string $email): bool
{
    return preg_match('/^[^ ]+@[^ ]+\.[a-z]{2,3}$/', $email);
}

function is_code(string $code): bool
{
    return preg_match('/^(?=.*[a-z])(?=.*\d).{32}$/', $code);
}

function is_file(array $file): bool
{
    return isset($file['size']) && $file['size'] > 0;
}

function is_authorized(): bool
{
    if (session\has_user()) {
        $token_hash = hash('sha256', session\get_user('token'));
        return auth_token\is_active($token_hash);
    }
    return false;
}

function is_remembered(): bool
{
    return cookie\has('token') && is_code(cookie\get('token'));
}

function check_allowed_paths(array $allowed_paths, ?string $current_path = null): bool
{
    $current_path = $current_path ?? request\get_path();
    foreach ($allowed_paths as $path) {

        if (is_string($path) && $path == $current_path) {
            return true;
        }

    }
    return false;
}

function check_referer(?array $allowed_paths = null): bool
{
    $result = false;
    if (isset($_SERVER['HTTP_REFERER']) && str_starts_with($_SERVER['HTTP_REFERER'], BASE_URL)) {
        $result = true;
        if (isset($allowed_paths)) {
            $referer_path = request\get_path($_SERVER['HTTP_REFERER']);
            $result = check_allowed_paths($allowed_paths, $referer_path);
        }
    }
    return $result;
}

function get_formatted_date(int $time, string $format = 'Y-m-d H:i:s'): string
{
    return date($format, $time);
}

function check_expiration_date(string $expiration_date): bool
{
    return strtotime($expiration_date) >= time();
}

function extend_token_expiration_date($term = ONE_MONTH): void
{
    $token = session\get_user('token');
    $token_hash = hash('sha256', $token);
    $token_db = auth_token\get_by_hash($token_hash);
    $extended_date = time() + $term;

    if (isset($token_db['id'], $token_db['dt_exp']) && strtotime($token_db['dt_exp']) !== $extended_date) {
        $token_id = $token_db['id'];

        if (auth_token\extend_by_id($token_id, get_formatted_date($extended_date))) {
            if (cookie\has('token') && cookie\get('token') === $token) {
                cookie\set('token', $token, $extended_date);
            }
        } else {
            write_to_log("Failed to extend auth token by id: {$token_id}", __FILE__);
        }
    }
}

function has_array_keys(array $array, array $keys): bool
{
    foreach ($keys as $key) {
        if (!array_key_exists($key, $array)) {
            return false;
        }
    }
    return true;
}

function remove_extra_spaces(string $string): string
{
    return trim(preg_replace('/\s+/', ' ', $string));
}

function get_clean_string(string $string): mixed
{
    return htmlspecialchars(remove_extra_spaces($string));
}

function generate_code(int $bytes = 16): string
{
    return bin2hex(random_bytes($bytes));
}

function write_to_log(string $message, ?string $path = null): void
{
    $year = date('Y');
    $month = date('M');
    $day = date('d');
    $dir_path = LOGS_DIR . "/$year/$month/$day";

    if (!is_dir($dir_path)) {
        mkdir($dir_path, 0777, true);
    }

    $timestamp = date('Y-m-d H:i:s');
    $path = isset($path) ? ". Path: {$path}" : '';
    file_put_contents("$dir_path/log.txt", "[$timestamp] " . rtrim($message, '.') . "{$path}\n", FILE_APPEND);
}

function upload_file(array $file, string $postfix_path = ''): string|false
{
    $relative_dir_path = rtrim("/uploads/$postfix_path", '/');
    $uploads_path = PUBLIC_DIR . "/$relative_dir_path";

    if (!is_dir($uploads_path)) {

        if (!mkdir($uploads_path, 0777, true)) {
            write_to_log("Failed to create directory: $uploads_path", __FILE__);
        }

    }

    $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $file_name = date('Y-m-d_H-i-s') . '_' . generate_code(5) . ".$file_extension";
    $relative_file_path = "$relative_dir_path/$file_name";
    $absolute_file_path = "$uploads_path/$file_name";

    if (move_uploaded_file($file['tmp_name'], $absolute_file_path)) {
        return $relative_file_path;
    } else {
        write_to_log("Failed to upload file: $absolute_file_path", __FILE__);
        return false;
    }
}

function send_mail(array|string $to, string $subject, string $body, array $body_data = [], array $attachments = []): bool
{
    // Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->SMTPDebug = MAIL_SETTINGS['debug']; // Enable verbose debug output
        $mail->isSMTP();
        $mail->Host = MAIL_SETTINGS['host'];
        $mail->SMTPAuth = MAIL_SETTINGS['auth']; // Enable SMTP authentication
        $mail->Username = MAIL_SETTINGS['username'];
        $mail->Password = MAIL_SETTINGS['password'];
        $mail->SMTPSecure = MAIL_SETTINGS['secure'] ?? PHPMailer::ENCRYPTION_SMTPS; // Enable implicit TLS encryption
        $mail->Port = MAIL_SETTINGS['port']; // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $mail->CharSet = MAIL_SETTINGS['charset'];

        // Recipients
        $mail->setFrom(MAIL_SETTINGS['from_email'], MAIL_SETTINGS['from_name']);

        if (is_array($to)) {
            foreach ($to as $email) {
                $mail->addAddress($email);
            }
        } elseif (is_string($to)) {
            $mail->addAddress($to);
        }

        if ($attachments) {
            foreach ($attachments as $attachment) {
                $mail->addAttachment($attachment);
            }
        }

        // Content
        $mail->isHTML(MAIL_SETTINGS['is_html']); // Set email format to HTML
        $mail->Subject = $subject;

        if (file_exists(VIEWS . "/templates/$body.view.php")) {
            $mail->Body = view\template($body, $body_data); // sent message as html code
        } else {
            $mail->Body = $body; // sent message as text
        }

        return $mail->send();
    } catch (Exception $e) {
        write_to_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}", __FILE__);
        return false;
    }
}