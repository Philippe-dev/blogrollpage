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
use Dotclear\Core\Frontend\Tpl;
use Dotclear\Plugin\TemplateHelper\Code;

class FrontendTemplate
{
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

    
}
