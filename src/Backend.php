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
use Dotclear\Core\Process;
use Dotclear\Interface\Core\BlogSettingsInterface;
use form;

class Backend extends Process
{
    public static function init(): bool
    {
        return self::status(My::checkContext(My::BACKEND));
    }

    public static function process(): bool
    {
        if (!self::status()) {
            return false;
        }

        App::behavior()->addBehavior('adminBlogPreferencesFormV2', [self::class,'adminBlogPreferencesForm']);
        App::behavior()->addBehavior('adminBeforeBlogSettingsUpdate', [self::class,'adminBeforeBlogSettingsUpdate']);
        App::behavior()->addBehaviors([
            // SimpleMenu behaviors
            'adminSimpleMenuAddType'    => SimpleMenuBehaviors::adminSimpleMenuAddType(...),
            'adminSimpleMenuBeforeEdit' => SimpleMenuBehaviors::adminSimpleMenuBeforeEdit(...),
        ]);

        return true;
    }

    public static function adminBlogPreferencesForm(BlogSettingsInterface $settings): void
    {
        echo '<div class="fieldset"><h4>' . __('Blogroll page') . '</h4>' .
        '<p><label class="classic">' . form::checkbox('blogrollpage_enabled', '1', $settings->blogrollpage->blogrollpage_enabled) . __('Enable blogroll page') . '</label></p>' .
        '<p><label class="classic">' . form::checkbox('blogrollpage_new_window', '1', $settings->blogrollpage->blogrollpage_new_window) . __('Open links in new window') . '</label></p>' .
        '</div>';
    }

    public static function adminBeforeBlogSettingsUpdate(BlogSettingsInterface $settings): void
    {
        $settings->blogrollpage->put('blogrollpage_enabled', !empty($_POST['blogrollpage_enabled']), 'boolean');
        $settings->blogrollpage->put('blogrollpage_new_window', !empty($_POST['blogrollpage_new_window']), 'boolean');
    }
}
