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
use Dotclear\Helper\Html\Form\Link;
use Dotclear\Helper\Html\Form\None;
use Dotclear\Helper\Html\Form\Para;
use Dotclear\Helper\Html\Form\Set;
use Dotclear\Helper\Html\Form\Text;
use Dotclear\Helper\Html\Html;
use Dotclear\Plugin\widgets\WidgetsElement;

class FrontendWidgets
{
    public static function renderWidget(WidgetsElement $w): string
    {
        if ($w->offline) {
            return '';
        }

        if (($w->homeonly == 1 && !App::url()->isHome(App::url()->getType())) || ($w->homeonly == 2 && App::url()->isHome(App::url()->getType()))) {
            return '';
        }

        $settings = My::settings();
        if (!$settings->active) {
            return '';
        }

        $buffer = (new Set())
            ->items([
                $w->title ? new Text(null, $w->renderTitle(Html::escapeHTML($w->title))) : new None(),
                (new Para())
                    ->items([
                        (new Link())
                            ->href(App::blog()->url() . App::url()->getURLFor('blogrollpage'))
                            ->text($w->get('link_title') ? Html::escapeHTML($w->get('link_title')) : __('Blogroll page')),
                    ]),
            ])
        ->render();

        return $w->renderDiv((bool) $w->content_only, 'blogrollpage ' . $w->class, '', $buffer);
    }
}
