<?php

namespace core\view;

use core\response;
use core\session;
use core\helpers;

function template(string $view_name, array $data = []): ?string
{
    $view = VIEWS . "/{$view_name}.view.php";
    if (file_exists($view)) {
        ob_start();
        extract($data);
        require $view;
        return ob_get_clean();
    } else {
        helpers\write_to_log("View $view not found", __FILE__);
        response\redirect('/500');
    }
}

function get_message_html(string $message, ?string $status = null, bool $close_btn = true): string
{
    $message_data = [
        'status' => $status ?? '',
        'text' => $message,
        'close_btn' => $close_btn
    ];
    return template('partials/message', $message_data);
}

function render_page(string $view_name, array $content_data = [], string $layout_name = 'main'): void
{
    $response = response\get_body();
    $temp_content_data = session\get_temp_content();

    if (isset($response['message']) && !empty($response['message'])) {
        $content_data['message_banner'] = get_message_html($response['message'], $response['status'] ?? '');
    }

    $page_data['content'] = template($view_name, array_merge($content_data, $temp_content_data, $response));
    echo template("layouts/$layout_name", array_merge($page_data));
}

function render_error_page(int $code, string $message, string $status = 'failure', bool $close_btn = false, string $layout_name = 'main'): void
{
    $content_data['message_banner'] = get_message_html("$code - $message", $status, $close_btn);
    $page_data['content'] = template('error', $content_data);
    http_response_code($code);
    echo template("layouts/$layout_name", $page_data);
}
