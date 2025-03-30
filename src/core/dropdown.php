<?php

namespace core\dropdown;

use core\view;

function get_dropdown_html(array $content_data = [], string $template = DROPDOWN_SETTINGS['template']): string
{
    return view\template($template, $content_data);
}