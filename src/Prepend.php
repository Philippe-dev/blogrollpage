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
use Dotclear\Core\Process;

class Prepend extends Process
{
    public static function init(): bool
    {
        return self::status(My::checkContext(My::PREPEND));
    }

    public static function process(): bool
    {
        if (!self::status()) {
            return false;
        }

        App::url()->register('blogrollpage', 'blogroll', '^blogroll(?:/(.+))?$', FrontendUrl::blogroll(...));

        if (App::blog()->isDefined()) {
            $settings = My::settings();
            if (!$settings->settingExists('active')) {
                // Set active flag to true only if recipient(s) is/are set
                $settings->put('active', (bool) $settings->recipients, App::blogWorkspace()::NS_BOOL);
            }
        }

        return true;
    }
}
