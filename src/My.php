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
use Dotclear\Module\MyPlugin;
use Dotclear\Plugin\blogroll\Blogroll;
use Dotclear\Core\Frontend\Utility;

class My extends MyPlugin
{
    protected static function checkCustomContext(int $context): ?bool
    {
        return match ($context) {
            // Limit backend to (content) admin and blogroll user
            self::MODULE => !App::task()->checkContext('BACKEND')
                || (
                    App::blog()->isDefined()
                    && App::auth()->check(App::auth()->makePermissions([
                        Blogroll::PERMISSION_BLOGROLL,
                        App::auth()::PERMISSION_ADMIN,
                        App::auth()::PERMISSION_CONTENT_ADMIN,
                    ]), App::blog()->id())
                ),

            // Allow MANAGE and MENU to also content admin and blogroll user
            self::MANAGE, self::MENU => App::task()->checkContext('BACKEND')
                && App::blog()->isDefined()
                && App::auth()->check(App::auth()->makePermissions([
                    Blogroll::PERMISSION_BLOGROLL,
                    App::auth()::PERMISSION_ADMIN,
                    App::auth()::PERMISSION_CONTENT_ADMIN,
                ]), App::blog()->id()),

            default => null,
        };
    }

    /**
     * Return template path to use
     *
     * @return     string
     */
    public static function tplPath(): string
    {
        $tplset = App::themes()->moduleInfo(App::blog()->settings()->system->theme, 'tplset');
        if (!empty($tplset) && is_dir(implode(DIRECTORY_SEPARATOR, [My::path(), Utility::TPL_ROOT, $tplset]))) {
            // a sub-dir exists for my plugin with this tplset
            return implode(DIRECTORY_SEPARATOR, [My::path(), Utility::TPL_ROOT, $tplset]);
        }

        $tplset = App::config()->defaultTplset();
        if (!empty($tplset) && is_dir(implode(DIRECTORY_SEPARATOR, [My::path(), Utility::TPL_ROOT, $tplset]))) {
            // a sub-dir exists for my plugin with the default tplset
            return implode(DIRECTORY_SEPARATOR, [My::path(), Utility::TPL_ROOT, $tplset]);
        }

        // return base tpl dir
        return implode(DIRECTORY_SEPARATOR, [My::path(), Utility::TPL_ROOT]);
    }
}
