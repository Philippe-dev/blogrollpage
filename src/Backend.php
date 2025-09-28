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
use Dotclear\Helper\Html\Form\Checkbox;
use Dotclear\Helper\Html\Form\Fieldset;
use Dotclear\Helper\Html\Form\Label;
use Dotclear\Helper\Html\Form\Legend;
use Dotclear\Helper\Html\Form\Para;
use Dotclear\Helper\Process\TraitProcess;
use Dotclear\Interface\Core\BlogSettingsInterface;

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

        App::behavior()->addBehavior('adminBlogPreferencesFormV2', [self::class,'adminBlogPreferencesForm']);
        App::behavior()->addBehavior('adminBeforeBlogSettingsUpdate', [self::class,'adminBeforeBlogSettingsUpdate']);
        App::behavior()->addBehaviors([
            // SimpleMenu behaviors
            'adminSimpleMenuAddType'    => SimpleMenuBehaviors::adminSimpleMenuAddType(...),
            'adminSimpleMenuBeforeEdit' => SimpleMenuBehaviors::adminSimpleMenuBeforeEdit(...),
        ]);

        return true;
    }

    public static function adminBlogPreferencesForm(BlogSettingsInterface $settings): string
    {
        // Add fieldset for plugin options
        echo
        (new Fieldset('blogrollpage'))
        ->legend((new Legend(__('Blogroll page'))))
        ->fields([
            (new Para())->items([
                (new Checkbox('blogrollpage_enabled', $settings->blogrollpage->blogrollpage_enabled))
                    ->value(1)
                    ->label((new Label(__('Enable blogroll page'), Label::INSIDE_TEXT_AFTER))),
            ]),
            (new Para())->items([
                (new Checkbox('blogrollpage_new_window', $settings->blogrollpage->blogrollpage_new_window))
                    ->value(1)
                    ->label((new Label(__('Open links in new window'), Label::INSIDE_TEXT_AFTER))),
            ]),
        ])
        ->render();

        return '';
    }

    public static function adminBeforeBlogSettingsUpdate(BlogSettingsInterface $settings): void
    {
        $settings->blogrollpage->put('blogrollpage_enabled', !empty($_POST['blogrollpage_enabled']), 'boolean');
        $settings->blogrollpage->put('blogrollpage_new_window', !empty($_POST['blogrollpage_new_window']), 'boolean');
    }
}
