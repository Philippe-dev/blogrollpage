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

use Dotclear\App;
use Dotclear\Plugin\blogroll\Blogroll;
use Dotclear\Plugin\blogroll\Status\Link;

class FrontendUrl
{
    public static function blogroll(?string $args): void
    {
        $settings = My::settings();
        if (!$settings->blogrollpage_enabled) {
            self::p404();
        }

        if ($args != '') {
            $blogroll = self::getBlogroll(urldecode($args));
            if (!$blogroll) {
                App::url()->p404();
            } else {
                App::frontend()->context()->blogrollpage_cat = $args;
            }
        } else {
            $blogroll = self::getBlogroll();
        }

        App::frontend()->context()->blogrollpage_blogroll = $blogroll;

        App::frontend()->template()->appendPath(My::tplPath());
        App::url()::serveDocument('blogroll.html');
        exit;
    }

    public static function getBlogroll($category = null, $rand = null)
    {
        $blogroll = new Blogroll(App::blog());

        try {
            $links = $blogroll->getLinks([
                'link_status' => Link::ONLINE,
            ]);
        } catch (Exception) {
            self::p404();
        }

        $links = $blogroll->getLinksHierarchy($blogroll->getLinks([
            'link_status' => Link::ONLINE,
        ]));

        return $links;
    }
}
