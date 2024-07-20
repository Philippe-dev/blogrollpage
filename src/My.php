<?php
/**
 * @brief blogroll, a plugin for Dotclear 2
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
}
