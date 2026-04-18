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
        foreach (App::frontend()->context()->blogrollpage_blogroll as $category => $links) : ?>
            $_content_HTML
            <?php endforeach;
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
     * PHP code for tpl:BlogrollPageIfTitle block
     */
    public static function BlogrollPageIfTitle(
        string $_content_HTML,
    ): void {
        $brp_cat = App::frontend()->context()->blogrollpage_cat;
        
        if ($brp_cat !== '') : ?>
            $_content_HTML
            <?php endif;
    }

    /**
     * PHP code for tpl:CategoryTitle value
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
}
