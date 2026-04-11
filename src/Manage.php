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
use Dotclear\Helper\Html\Form\Form;
use Dotclear\Helper\Html\Form\Input;
use Dotclear\Helper\Html\Form\Label;
use Dotclear\Helper\Html\Form\Link;
use Dotclear\Helper\Html\Form\Note;
use Dotclear\Helper\Html\Form\Para;
use Dotclear\Helper\Html\Form\Submit;
use Dotclear\Helper\Html\Form\Text;
use Dotclear\Helper\Html\Form\Textarea;
use Dotclear\Helper\Html\Html;
use Dotclear\Helper\Process\TraitProcess;
use Exception;

class Manage
{
    use TraitProcess;

    /**
     * Initializes the page.
     */
    public static function init(): bool
    {
        return self::status(My::checkContext(My::MANAGE));
    }

    /**
     * Processes the request(s).
     */
    public static function process(): bool
    {
        if (!self::status()) {
            return false;
        }

        if ($_POST !== []) {
            try {
                $active                  = !empty($_POST['active']);
                $blogrollpage_new_window = !empty($_POST['blogrollpage_new_window']);

                $page_title  = $_POST['page_title'];
                $page_header = $_POST['page_header'];

                // Everything's fine, save options
                $settings = My::settings();

                $settings->put('active', $active, App::blogWorkspace()::NS_BOOL);
                $settings->put('blogrollpage_new_window', $blogrollpage_new_window, App::blogWorkspace()::NS_BOOL);

                $settings->put('page_title', $page_title, App::blogWorkspace()::NS_STRING, 'Blogroll page title');
                $settings->put('page_header', $page_header, App::blogWorkspace()::NS_STRING, 'Blogroll page header');

                App::blog()->triggerBlog();
                App::backend()->notices()->addSuccessNotice(__('Setting have been successfully updated.'));
                My::redirect();
            } catch (Exception $e) {
                App::error()->add($e->getMessage());
            }
        }

        return true;
    }

    /**
     * Renders the page.
     */
    public static function render(): void
    {
        if (!self::status()) {
            return;
        }

        $head        = '';
        $rich_editor = App::auth()->getOption('editor');
        $rte_flag    = true;
        $rte_flags   = @App::auth()->prefs()->interface->rte_flags;
        if (is_array($rte_flags) && in_array('blogrollpage', $rte_flags)) {
            $rte_flag = $rte_flags['blogrollpage'];
        }

        if ($rte_flag) {
            $head = App::behavior()->callBehavior(
                'adminPostEditor',
                $rich_editor['xhtml'],
                'blogrollpage',
                ['#page_header'],
                'xhtml'
            ) .
            My::jsLoad('blogrollpage.js');
        }

        $settings = My::settings();

        $active                  = $settings->active;
        $blogrollpage_new_window = $settings->blogrollpage_new_window;
        $page_title              = $settings->page_title;
        $page_header             = $settings->page_header;

        if ($page_title === null) {
            $page_title = __('Blogroll page');
        }

        App::backend()->page()->openModule(My::name(), $head);

        echo App::backend()->page()->breadcrumb(
            [
                Html::escapeHTML(App::blog()->name()) => '',
                __('Blogroll page')                   => '',
            ]
        );
        echo App::backend()->notices()->getNotices();

        // Form

        echo (new Form('blogrollpage'))
            ->action(App::backend()->getPageURL())
            ->method('post')
            ->fields([
                (new Para())->items([
                    (new Checkbox('active', $active))
                        ->value(1)
                        ->label((new Label(__('Activate'), Label::INSIDE_TEXT_AFTER))),
                ]),

                (new Para())->items([
                    (new Checkbox('blogrollpage_new_window', $blogrollpage_new_window))
                        ->value(1)
                        ->label((new Label(__('Open links in new window'), Label::INSIDE_TEXT_AFTER))),
                ]),

                (new Para())->items([
                    (new Input('page_title'))
                        ->size(30)
                        ->maxlength(256)
                        ->value(Html::escapeHTML($page_title))
                        //->required(true)
                        ->placeholder(__('Title'))
                        ->label((new Label(
                            __('Page title:'),
                            Label::OUTSIDE_TEXT_BEFORE
                        ))->id('page_title_label')),
                ]),
                (new Para())->items([
                    (new Textarea('page_header'))
                        ->cols(30)
                        ->rows(2)
                        ->lang(App::auth()->getInfo('user_lang'))
                        ->spellcheck(true)
                        ->value(Html::escapeHTML($page_header))
                        ->label((new Label(__('Blogroll description'), Label::OUTSIDE_TEXT_BEFORE))),
                ]),
                (new Note())
                    ->class(['form-note', 'info', 'maximal'])
                    ->items([
                        (new Text(null, __('Your blogroll URL:') . '&nbsp;')),
                        (new Link())
                            ->href(App::blog()->url() . App::url()->getURLFor('blogrollpage'))
                            ->class(['outgoing'])
                            ->text(App::blog()->url() . App::url()->getURLFor('blogrollpage') . '. '),
                        (new Text(null, __('You may use the widget or Simple Menu predefined entry to link to it.'))),
                    ]),

                // Submit
                (new Para())->items([
                    (new Submit(['frmsubmit']))
                        ->value(__('Save')),
                    ... My::hiddenFields(),
                ]),

            ])
        ->render();

        App::backend()->page()->closeModule();
    }
}
