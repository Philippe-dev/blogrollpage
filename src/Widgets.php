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

namespace Dotclear\Plugin\blogrollpage;

use Dotclear\Plugin\widgets\WidgetsStack;

class Widgets
{
    public static function initWidgets(WidgetsStack $w): string
    {
        $w
            ->create('blogrollpage', __('Blogroll page'), FrontendWidgets::renderWidget(...), null, __('Blogroll page'), My::id())
            ->addTitle(__('Links'))
            ->setting('link_title', __('Link title:'), __('Blogroll page'))
            ->addHomeOnly()
            ->addContentOnly()
            ->addClass()
            ->addOffline();

        return '';
    }
}
