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
    '3.7',
    [
        'date'        => '2025-09-09T00:00:08+0100',
        'requires'    => [['core', '2.36']],
        'permissions' => 'My',
        'type'        => 'plugin',
        'support'     => 'https://github.com/Philippe-dev/blogrollpage',
    ]
);
