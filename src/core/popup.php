<?php

namespace core\popup;

use core\view;
use core\response;
use core\session;

function render_popup(string $title = '', array $content_data = [], string $view_name = 'partials/popup/contents/default', string $template = POPUP_SETTINGS['template']): void
{
    $response = response\get_body();
    $popup_data['popup_title'] = $title;
    $popup_data['popup_content'] = view\template($view_name, array_merge($content_data, $response));

    if (isset($response['message']) && !empty($response['message'])) {
        $popup_data['popup_message_banner'] = view\get_message_html($response['message'], $response['status'] ?? '');
    }

    session\set_temp_content([
        'popup' => view\template($template, $popup_data)
    ]);
    response\redirect();
}