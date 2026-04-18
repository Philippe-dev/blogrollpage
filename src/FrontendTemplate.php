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

use ArrayObject;
use Dotclear\App;
use Dotclear\Helper\Html\Html;
use Dotclear\Plugin\TemplateHelper\Code;

class FrontendTemplate
{
    /**
     * @param      array<string, mixed>|\ArrayObject<string, mixed>  $attr      The attribute
     * @param      string                                            $content   The content
     */
    public static function BlogrollPage(array|ArrayObject $attr, string $content): string
    {
        $attr = $attr instanceof ArrayObject ? $attr : new ArrayObject($attr);

        return Code::getPHPTemplateBlockCode(
            FrontendTemplateCode::BlogrollPage(...),
            [],
            $content,
            $attr,
        );
    }

    /**
     * @param      array<string, mixed>|\ArrayObject<string, mixed>  $attr      The attribute
     */
    public static function BlogrollPageTitle(array|ArrayObject $attr): string
    {
        $attr = $attr instanceof ArrayObject ? $attr : new ArrayObject($attr);

        return Code::getPHPTemplateValueCode(
            FrontendTemplateCode::BlogrollPageTitle(...),
            [
                My::id(),
            ],
            attr: $attr,
        );
    }
    /**
     * @param      array<string, mixed>|\ArrayObject<string, mixed>  $attr      The attribute
     */
    public static function BlogrollPageHeader(array|ArrayObject $attr): string
    {
        $attr = $attr instanceof ArrayObject ? $attr : new ArrayObject($attr);

        return Code::getPHPTemplateValueCode(
            FrontendTemplateCode::BlogrollPageHeader(...),
            [
                My::id(),
            ],
            attr: $attr,
        );
    }

    /**
     * @param      array<string, mixed>|\ArrayObject<string, mixed>  $attr      The attribute
     * @param      string                                            $content   The content
     */
    public static function BlogrollPageIfTitle(array|ArrayObject $attr, string $content): string
    {
        $attr = $attr instanceof ArrayObject ? $attr : new ArrayObject($attr);

        return Code::getPHPTemplateBlockCode(
            FrontendTemplateCode::BlogrollPageIfTitle(...),
            [],
            $content,
            $attr,
        );

        return $content;
    }

     public static function IfCategoryTitle($attr, $content)
    {
        $res = '<?php if (!empty($category)) { ?>';
        $res .= $content;
        $res .= '<?php } ?>';

        return $res;
    }

    /**
     * @param      array<string, mixed>|\ArrayObject<string, mixed>  $attr      The attribute
     */
    public static function BlogrollPageCategoryTitle(array|ArrayObject $attr): string
    {
        $attr = $attr instanceof ArrayObject ? $attr : new ArrayObject($attr);

        return Code::getPHPTemplateValueCode(
            FrontendTemplateCode::BlogrollPageCategoryTitle(...),
            [
                My::id(),
            ],
            attr: $attr,
        );
    }

    public static function Links($attr, $content): string
    {
        $res = '<?php foreach ($links as $link) { ?>';
        $res .= $content;
        $res .= '<?php } ?>';

        return $res;
    }

    public static function Link($attr): string
    {
        return '<?php echo ' . self::class . '::makeLink($link,App::blog()->settings()->blogrollpage->blogrollpage_new_window); ?>';
    }

    public static function makeLink($link, $new_window = null): string
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

    public static function LinkTitle($attr): string
    {
        $f = App::frontend()->template()->getFilters($attr);

        return '<?php echo ' . sprintf($f, '$link[\'link_title\']') . '; ?>';
    }

    public static function LinkHref($attr): string
    {
        $f = App::frontend()->template()->getFilters($attr);

        return '<?php echo ' . sprintf($f, '$link[\'link_href\']') . '; ?>';
    }

    public static function IfLinkDesc($attr, $content): string
    {
        $res = '<?php if (!empty($link[\'link_desc\'])) { ?>';
        $res .= $content;
        $res .= '<?php } ?>';

        return $res;
    }

    public static function LinkDesc($attr): string
    {
        $f = App::frontend()->template()->getFilters($attr);

        return '<?php echo ' . sprintf($f, '$link[\'link_desc\']') . '; ?>';
    }

    public static function IfLinkLang($attr, $content): string
    {
        $res = '<?php if (!empty($link[\'link_lang\'])) { ?>';
        $res .= $content;
        $res .= '<?php } ?>';

        return $res;
    }

    public static function LinkLang($attr): string
    {
        $f = App::frontend()->template()->getFilters($attr);

        return '<?php echo ' . sprintf($f, '$link[\'link_lang\']') . '; ?>';
    }

    public static function IfLinkXFN($attr, $content): string
    {
        $res = '<?php if (!empty($link[\'link_xfn\'])) { ?>';
        $res .= $content;
        $res .= '<?php } ?>';

        return $res;
    }

    public static function LinkXFN($attr): string
    {
        $f = App::frontend()->template()->getFilters($attr);

        return '<?php echo ' . sprintf($f, '$link[\'link_xfn\']') . '; ?>';
    }
}
