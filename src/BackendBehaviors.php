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
use Dotclear\Helper\Html\Form\Checkbox;
use Dotclear\Helper\Html\Form\Fieldset;
use Dotclear\Helper\Html\Form\Label;
use Dotclear\Helper\Html\Form\Legend;
use Dotclear\Helper\Html\Form\Para;
use Dotclear\Interface\Core\BlogSettingsInterface;

class BackendBehaviors
{
    /*
     * Display blogrollpage fieldset settings.
     *
     * @param   BlogSettingsInterface   $settings   The settings
     */
    public static function adminBlogPreferencesForm(BlogSettingsInterface $settings): void
    {
        // Add fieldset for plugin options
        echo
        (new Fieldset('blogrollpage'))
        ->legend((new Legend(__('Blogroll page'))))
        ->fields([
            (new Para())->items([
                (new Checkbox('active', $settings->blogrollpage->active))
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
    }

    /*
     * Save blogrollpage settings.
     *
     * @param   BlogSettingsInterface   $settings   The settings
     */
    public static function adminBeforeBlogSettingsUpdate(BlogSettingsInterface $settings): void
    {
        $settings->put('active', $active, App::blogWorkspace()::NS_BOOL);
        $settings->put('blogrollpage_new_window', $blogrollpage_new_window, App::blogWorkspace()::NS_BOOL);
    }

    /**
     * @param      ArrayObject<string, mixed>  $rte
     */
    public static function adminRteFlags(ArrayObject $rte): string
    {
        $rte['blogrollpage'] = [true, __('Blogroll page description')];

        return '';
    }
}
