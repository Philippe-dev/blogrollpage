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
use Dotclear\Helper\Process\TraitProcess;

class Install
{
    use TraitProcess;

    public static function init(): bool
    {
        return self::status(My::checkContext(My::INSTALL));
    }

    public static function process(): bool
    {
        if (!self::status()) {
            return false;
        }

        // reset for new versions
        if (App::blog()->settings()->exists('blogrollpage')) {
            App::blog()->settings()->delWorkspace(My::id());
        }
        

        My::settings()->put('active', true, 'boolean', 'Enable blogrollpage plugin', false, true);
        My::settings()->put('blogrollpage_new_window', false, 'boolean', 'Enable opening links in new window', false, true);
        
        return true;
    }
}
