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
use Dotclear\Plugin\simpleMenu\MenuItemEdit;

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
     * @param      MenuItemEdit  $menuItemEdit  The menu item edit
     *
     * @return     string
     */
    public static function adminSimpleMenuBeforeEdit(MenuItemEdit $menuItemEdit): string
    {
        if ($menuItemEdit->getType() === 'blogrollpage') {
            $menuItemEdit->setLabel(__('Blogroll page'));
            $menuItemEdit->setDescription(__('Show your blogroll on a dedicated page'));
            $menuItemEdit->setUrl(Html::stripHostURL(App::blog()->url() . App::url()->getURLFor('blogrollpage')));

            return '';
        }
    }
}
