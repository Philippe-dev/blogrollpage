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
use Dotclear\Core\Process;
use Dotclear\Helper\Html\Html;

class Frontend extends Process
{
    public static function init(): bool
    {
        return self::status(My::checkContext(My::FRONTEND));
    }

    public static function process(): bool
    {
        if (!self::status()) {
            return false;
        }

        App::behavior()->addBehavior('publicBreadcrumb', [self::class,'publicBreadcrumb']);

        App::frontend()->template()->addBlock('BlogrollPage', [self::class,'BlogrollPage']);
        App::frontend()->template()->addValue('BlogrollPageTitle', [self::class,'Title']);
        App::frontend()->template()->addBlock('BlogrollPageIfTitle', [self::class,'IfTitle']);
        App::frontend()->template()->addBlock('BlogrollPageIfCategoryTitle', [self::class,'IfCategoryTitle']);
        App::frontend()->template()->addValue('BlogrollPageCategoryTitle', [self::class,'CategoryTitle']);
        App::frontend()->template()->addBlock('BlogrollPageLinks', [self::class,'Links']);
        App::frontend()->template()->addValue('BlogrollPageLink', [self::class,'Link']);
        App::frontend()->template()->addValue('BlogrollPageLinkTitle', [self::class,'LinkTitle']);
        App::frontend()->template()->addValue('BlogrollPageLinkHref', [self::class,'LinkHref']);
        App::frontend()->template()->addBlock('BlogrollPageIfLinkDesc', [self::class,'IfLinkDesc']);
        App::frontend()->template()->addValue('BlogrollPageLinkDesc', [self::class,'LinkDesc']);
        App::frontend()->template()->addBlock('BlogrollPageIfLinkLang', [self::class,'IfLinkLang']);
        App::frontend()->template()->addValue('BlogrollPageLinkLang', [self::class,'LinkLang']);
        App::frontend()->template()->addBlock('BlogrollPageIfLinkXFN', [self::class,'IfLinkXFN']);
        App::frontend()->template()->addValue('BlogrollPageLinkXFN', [self::class,'LinkXFN']);

        return true;
    }

    public static function publicBreadcrumb($context, $separator)
    {
        if ($context == 'blogrollpage') {
            if (App::frontend()->context()->blogrollpage_cat) {
                $u = App::blog()->url() . App::url()->getURLFor('blogroll');

                return '<a href="' . $u . '">' . __('Links') . '</a>' . $separator . App::frontend()->context()->blogrollpage_cat;
            }

            return __('Links');
        }
    }

    public static function BlogrollPage($attr, $content)
    {
        $res = '<?php foreach (App::frontend()->context()->blogrollpage_blogroll as $category => $links) { ?>';
        $res .= $content;
        $res .= '<?php } ?>';

        return $res;
    }

    public static function IfTitle($attr, $content)
    {
        $res = '<?php $brp_cat = App::frontend()->context()->blogrollpage_cat; if (!empty($brp_cat)) { ?>';
        $res .= $content;
        $res .= '<?php } ?>';

        return $res;
    }

    public static function Title($attr)
    {
        $f = App::frontend()->template()->getFilters($attr);

        return '<?php echo ' . sprintf($f, '$brp_cat') . '; ?>';
    }

    public static function IfCategoryTitle($attr, $content)
    {
        $res = '<?php if (!empty($category)) { ?>';
        $res .= $content;
        $res .= '<?php } ?>';

        return $res;
    }

    public static function CategoryTitle($attr)
    {
        $f = App::frontend()->template()->getFilters($attr);

        return '<?php echo ' . sprintf($f, '$category') . '; ?>';
    }

    public static function Links($attr, $content)
    {
        $res = '<?php foreach ($links as $link) { ?>';
        $res .= $content;
        $res .= '<?php } ?>';

        return $res;
    }

    public static function Link($attr)
    {
        return '<?php echo ' . self::class . '::makeLink($link,App::blog()->settings()->blogrollpage->blogrollpage_new_window); ?>';
    }

    public static function makeLink($link, $new_window = null)
    {
        $title = $link['link_title'];
        $href  = $link['link_href'];
        $desc  = $link['link_desc'];
        $lang  = $link['link_lang'];
        $xfn   = $link['link_xfn'];

        $link = '<a href="' . Html::escapeHTML($href) . '"' .
        ((!$lang) ? '' : ' hreflang="' . Html::escapeHTML($lang) . '"') .
        ((!$desc) ? '' : ' title="' . Html::escapeHTML($desc) . '"') .
        ((!$xfn) ? '' : ' rel="' . Html::escapeHTML($xfn) . '"') .
        ((!$new_window) ? '' : ' onclick="window.open(this.href); return false;"') .
        '>' .
        Html::escapeHTML($title) .
        '</a>';

        return $link;
    }

    public static function LinkTitle($attr)
    {
        $f = App::frontend()->template()->getFilters($attr);

        return '<?php echo ' . sprintf($f, '$link[\'link_title\']') . '; ?>';
    }

    public static function LinkHref($attr)
    {
        $f = App::frontend()->template()->getFilters($attr);

        return '<?php echo ' . sprintf($f, '$link[\'link_href\']') . '; ?>';
    }

    public static function IfLinkDesc($attr, $content)
    {
        $res = '<?php if (!empty($link[\'link_desc\'])) { ?>';
        $res .= $content;
        $res .= '<?php } ?>';

        return $res;
    }

    public static function LinkDesc($attr)
    {
        $f = App::frontend()->template()->getFilters($attr);

        return '<?php echo ' . sprintf($f, '$link[\'link_desc\']') . '; ?>';
    }

    public static function IfLinkLang($attr, $content)
    {
        $res = '<?php if (!empty($link[\'link_lang\'])) { ?>';
        $res .= $content;
        $res .= '<?php } ?>';

        return $res;
    }

    public static function LinkLang($attr)
    {
        $f = App::frontend()->template()->getFilters($attr);

        return '<?php echo ' . sprintf($f, '$link[\'link_lang\']') . '; ?>';
    }

    public static function IfLinkXFN($attr, $content)
    {
        $res = '<?php if (!empty($link[\'link_xfn\'])) { ?>';
        $res .= $content;
        $res .= '<?php } ?>';

        return $res;
    }

    public static function LinkXFN($attr)
    {
        $f = App::frontend()->template()->getFilters($attr);

        return '<?php echo ' . sprintf($f, '$link[\'link_xfn\']') . '; ?>';
    }
}
