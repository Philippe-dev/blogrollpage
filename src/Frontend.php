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

class Frontend
{
    use TraitProcess;

    public static function init(): bool
    {
        return self::status(My::checkContext(My::FRONTEND));
    }

    public static function process(): bool
    {
        if (!self::status()) {
            return false;
        }

        // Don't do things in frontend if plugin disabled
        $settings = My::settings();
        if (!(bool) $settings->active) {
            return false;
        }

        App::frontend()->template()->addBlock('BlogrollPage', FrontendTemplate::BlogrollPage(...));
        App::frontend()->template()->addValue('BlogrollPageTitle', FrontendTemplate::BlogrollPageTitle(...));
        App::frontend()->template()->addValue('BlogrollPageHeader', FrontendTemplate::BlogrollPageHeader(...));
        App::frontend()->template()->addBlock('BlogrollPageIfTitle', FrontendTemplate::BlogrollPageIfTitle(...));
        App::frontend()->template()->addBlock('BlogrollPageIfCategoryTitle', FrontendTemplate::IfCategoryTitle(...));
        App::frontend()->template()->addValue('BlogrollPageCategoryTitle', FrontendTemplate::BlogrollPageCategoryTitle(...));
        App::frontend()->template()->addBlock('BlogrollPageLinks', FrontendTemplate::Links(...));
        App::frontend()->template()->addValue('BlogrollPageLink', FrontendTemplate::Link(...));
        App::frontend()->template()->addValue('BlogrollPageLinkTitle', FrontendTemplate::LinkTitle(...));
        App::frontend()->template()->addValue('BlogrollPageLinkHref', FrontendTemplate::LinkHref(...));
        App::frontend()->template()->addBlock('BlogrollPageIfLinkDesc', FrontendTemplate::IfLinkDesc(...));
        App::frontend()->template()->addValue('BlogrollPageLinkDesc', FrontendTemplate::LinkDesc(...));
        App::frontend()->template()->addBlock('BlogrollPageIfLinkLang', FrontendTemplate::IfLinkLang(...));
        App::frontend()->template()->addValue('BlogrollPageLinkLang', FrontendTemplate::LinkLang(...));
        App::frontend()->template()->addBlock('BlogrollPageIfLinkXFN', FrontendTemplate::IfLinkXFN(...));
        App::frontend()->template()->addValue('BlogrollPageLinkXFN', FrontendTemplate::LinkXFN(...));

        App::behavior()->addBehaviors([
            'publicBreadcrumb' => FrontendBehaviors::publicBreadcrumb(...),
            'initWidgets' => Widgets::initWidgets(...),
        ]);

        return true;
    }
}
