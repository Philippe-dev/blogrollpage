<?php
/**
 * @brief blogroll, a plugin for Dotclear 2
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
    '3.0',
    [
        'requires'    => [['core', '2.30']],
        'permissions' => 'My',
        'type'        => 'plugin',
        'support'     => 'https://github.com/Philippe-dev/blogrollpage',
    ]
);
