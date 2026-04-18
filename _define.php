<?php
/**
 * @brief blogrollpage, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Simon Richard and contributors
 *
 * @copyright DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE http://www.wtfpl.net/
 */
$this->registerModule(
    'Blogroll page',
    'Show your blogroll on a dedicated page',
    'Simon Richard and contributors',
    '6.0',
    [
        'date'        => '2026-04-11T00:00:08+0100',
        'requires' => [
            ['core', '2.36'],
            ['TemplateHelper'],
        ],
        'permissions' => 'My',
        'type'        => 'plugin',
        'settings'    => [
        ],
        'support'     => 'https://github.com/Philippe-dev/blogrollpage',
    ]
);
