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
use Dotclear\Core\Backend\Favorites;

class BackendBehaviors
{
    /**
     * @param      Favorites  $favs   The favs
     */
    public static function adminDashboardFavorites(Favorites $favs): string
    {
        $favs->register('blogrollpage', [
            'title'       => __('Blogroll page'),
            'url'         => My::manageUrl(),
            'small-icon'  => My::icons(),
            'large-icon'  => My::icons(),
            'permissions' => My::checkContext(My::MENU),
        ]);

        return '';
    }

    /**
     * @param      ArrayObject<string, mixed>  $rte
     */
    public static function adminRteFlags(ArrayObject $rte): string
    {
        $rte['blogrollpage'] = [true, __('Blogroll description')];

        return '';
    }
}
