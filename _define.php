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
declare(strict_types=1);

if (isset($this) && is_object($this) && method_exists($this, 'registerModule') && isset($this->id) && is_string($this->id)) {
    $this->registerModule(
        'Blogroll page',
        'Show your blogroll on a dedicated page',
        'Simon Richard and contributors',
        '6.9',
        [
            'date'     => '2026-08-29T00:00:12+0100',
            'requires' => [
                ['core', '2.39'],
                ['TemplateHelper'],
            ],
            'permissions' => 'My',
            'type'        => 'plugin',
            'settings'    => [],
            'support'     => 'https://github.com/Philippe-dev/blogrollpage',
        ]
    );
}
