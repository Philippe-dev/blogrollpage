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
use Dotclear\Core\Frontend\Url;
use Dotclear\Plugin\blogroll\Blogroll;

class FrontendUrl extends Url
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
                Url::p404();
            } else {
                App::frontend()->context()->blogrollpage_cat = $args;
            }
        } else {
            $blogroll = self::getBlogroll();
        }

        App::frontend()->context()->blogrollpage_blogroll = $blogroll;

        App::frontend()->template()->appendPath(My::tplPath());
        self::serveDocument('blogroll.html');
        exit;
    }

    public static function getBlogroll($category = null, $rand = null)
    {
        $blogroll = new Blogroll(App::blog());

        try {
            $links = $blogroll->getLinks();
        } catch (Exception) {
            self::p404();
        }

        $links = $blogroll->getLinksHierarchy($blogroll->getLinks());

        return $links;
    }
}
