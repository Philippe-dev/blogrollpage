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

class SimpleMenuBehaviors
{
    /**
     * @param      ArrayObject<string, ArrayObject<int, mixed>>  $items  The items
     *
     * @return     string
     */
    public static function adminSimpleMenuAddType($items): string
    {
        $items['blogrollpage'] = new ArrayObject([__('Blogroll page'), false]);

        return '';
    }

    /**
     * @param      string               $item_type    The item type
     * @param      string               $item_select  The item select
     * @param      array<int, string>   $args         The arguments
     *
     * @return     string
     */
    public static function adminSimpleMenuBeforeEdit($item_type, $item_select, $args): string
    {
        if ($item_type == 'blogrollpage') {
            $args[0] = __('Blogroll page');
            $args[1] = __('Show your blogroll on a dedicated page');
            $args[2] .= App::url()->getURLFor('blogrollpage');
        }

        return '';
    }
}
