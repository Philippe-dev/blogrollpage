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

class FrontendTemplateCode
{
    /**
     * PHP code for tpl:BlogrollPage block
     */
    public static function BlogrollPage(
        string $_content_HTML,
    ): void {
        foreach (App::frontend()->context()->brp_blogroll as $category => $links) : ?>
            $_content_HTML
            <?php endforeach;
    }

    /**
     * PHP code for tpl:BlogrollPageIfTitle block
     */
    public static function BlogrollPageIfTitle(
        string $_content_HTML,
    ): void {
        $brp_title = App::frontend()->context()->brp_title;

        if ($brp_title !== '') : ?>
            $_content_HTML
            <?php endif;
    }

    /**
     * PHP code for tpl:BlogrollPageTitle value
     *
     * @param      array<int|string, mixed>     $_params_  The parameters
     */
    public static function BlogrollPageTitle(
        string $_id_HTML,
        array $_params_,
        string $_tag_
    ): void {
        echo App::frontend()->context()::global_filters(
            App::blog()->settings()->$_id_HTML->page_title,
            $_params_,
            $_tag_
        );
    }

    /**
     * PHP code for tpl:BlogrollPageHeader value
     *
     * @param      array<int|string, mixed>     $_params_  The parameters
     */
    public static function BlogrollPageHeader(
        string $_id_HTML,
        array $_params_,
        string $_tag_
    ): void {
        echo App::frontend()->context()::global_filters(
            App::blog()->settings()->$_id_HTML->page_header,
            $_params_,
            $_tag_
        );
    }

    /**
     * PHP code for tpl:BlogrollPageIfCategoryTitle block
     */
    public static function BlogrollPageIfCategoryTitle(
        string $_content_HTML,
    ): void {
        if ($category !== '') : ?>
            $_content_HTML
            <?php endif;
    }

    /**
     * PHP code for tpl:BlogrollPageCategoryTitle value
     *
     * @param      array<int|string, mixed>     $_params_  The parameters
     */
    public static function BlogrollPageCategoryTitle(
        string $_id_HTML,
        array $_params_,
        string $_tag_
    ): void {
        echo App::frontend()->context()::global_filters(
            $category,
            $_params_,
            $_tag_
        );
    }

    /**
     * PHP code for tpl:BlogrollPageLinks block
     */
    public static function BlogrollPageLinks(
        string $_content_HTML,
    ): void {
        foreach ($links as $link) : ?>
            $_content_HTML
            <?php endforeach;
    }

    /**
     * PHP code for tpl:BlogrollPageLink value
     *
     * @param      array<int|string, mixed>     $_params_  The parameters
     */
    public static function BlogrollPageLink(
        string $_id_HTML,
        array $_params_,
        string $_tag_
    ): void {
        $new_window = (bool) App::blog()->settings()->blogrollpage->blogrollpage_new_window;
        $title      = $link['link_title'];
        $href       = $link['link_href'];
        $desc       = $link['link_desc'];
        $lang       = $link['link_lang'];
        $xfn        = $link['link_xfn'];

        $link = '<a href="' . Html::escapeHTML($href) . '"' .
        ((!$lang) ? '' : ' hreflang="' . Html::escapeHTML($lang) . '"') .
        ((!$desc) ? '' : ' title="' . Html::escapeHTML($desc) . '"') .
        ((!$xfn) ? '' : ' rel="' . Html::escapeHTML($xfn) . '"') .
        ((!$new_window) ? '' : ' onclick="window.open(this.href); return false;"') .
        '>' .
        Html::escapeHTML($title) .
        '</a>';

        echo App::frontend()->context()::global_filters(
            $link,
            $_params_,
            $_tag_
        );
    }

    /**
     * PHP code for tpl:BlogrollPageIfLinkDesc block
     */
    public static function BlogrollPageIfLinkDesc(
        string $_content_HTML,
    ): void {
        // (!$desc) ? '' : '';

        if ($desc !== '') : ?>
            $_content_HTML
            <?php endif;
    }

    /**
     * PHP code for tpl:BlogrollPageLinkDesc value
     *
     * @param      array<int|string, mixed>     $_params_  The parameters
     */
    public static function BlogrollPageLinkDesc(
        string $_id_HTML,
        array $_params_,
        string $_tag_
    ): void {
        echo App::frontend()->context()::global_filters(
            $desc,
            $_params_,
            $_tag_
        );
    }
}
