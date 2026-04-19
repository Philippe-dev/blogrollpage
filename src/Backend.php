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
use Dotclear\Core\Backend\Favorites;
use Dotclear\Helper\Process\TraitProcess;

class Backend
{
    use TraitProcess;

    public static function init(): bool
    {
        return self::status(My::checkContext(My::BACKEND));
    }

    public static function process(): bool
    {
        if (!self::status()) {
            return false;
        }

        My::addBackendMenuItem(App::backend()->menus()::MENU_BLOG);

        App::behavior()->addBehaviors([
            'adminDashboardFavoritesV2' => function (Favorites $favs) {
                $favs->register(My::id(), [
                    'title'       => My::name(),
                    'url'         => My::manageUrl(),
                    'small-icon'  => My::icons(),
                    'large-icon'  => My::icons(),
                    'permissions' => App::auth()->makePermissions([
                        App::auth()::PERMISSION_ADMIN,
                    ]),
                ]);
            },
        ]);

        App::behavior()->addBehaviors([
            'adminBlogPreferencesFormV2'    => BackendBehaviors::adminBlogPreferencesForm(...),
            'adminBeforeBlogSettingsUpdate' => BackendBehaviors::adminBeforeBlogSettingsUpdate(...),
            'adminRteFlagsV2'               => BackendBehaviors::adminRteFlags(...),
            'adminSimpleMenuAddType'        => SimpleMenuBehaviors::adminSimpleMenuAddType(...),
            'adminSimpleMenuBeforeEdit'     => SimpleMenuBehaviors::adminSimpleMenuBeforeEdit(...),
        ]);

        if (My::checkContext(My::WIDGETS)) {
            App::behavior()->addBehaviors([
                'initWidgets' => Widgets::initWidgets(...),
            ]);
        }

        return true;
    }
}
