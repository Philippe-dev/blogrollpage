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

use Dotclear\Plugin\widgets\WidgetsStack;

class Widgets
{
    public static function initWidgets(WidgetsStack $w): string
    {
        

        $br = new Blogroll(App::blog());
        $h = $br->getLinksHierarchy($br->getLinks());
        $h = array_keys($h);
        $categories = array();
        foreach ($h as $v) {
            if ($v) {
                $categories[$v] = $v;
            }
        }
        unset($br,$h);

		
        $target_combo = array(
						__('All categories') => '/brp-all/',
						__('No link') => '/brp-none/'
					) + $categories;
					
        $cat_combo = $target_combo;

        $w
            ->create('blogrollpage',__('Blogroll page'),array('widgetsBlogrollPage','getWidget'),null,'Blogroll page and random links');
            ->setting('title',__('Title (optional)'),__('Links'))
            ->setting('random_category',__('Show random links:'),'/brp-all/','combo',$cat_combo)
            ->setting('random_number',__('Number of links:'),5)
            ->setting('new_window',__('Open random links in new window'),0,'check')
            ->setting('link_title',__('Link to blogroll page title:'),__('More links...'))
            ->setting('link_target',__('Link target:'),'/brp-all/','combo',$target_combo)
            ->addHomeOnly()
            ->addContentOnly()
            ->addClass()
            ->addOffline();
    }

    public static function getWidget($w)
    {
        
        if ($w->offline) {
            return '';
        }

        if (($w->homeonly == 1 && !App::url()->isHome(App::url()->getType())) || ($w->homeonly == 2 && App::url()->isHome(App::url()->getType()))) {
            return '';
        }

        // Can't link to blogroll page if blogroll page disabled
        if (!App::blog()->settings()->blogrollpage->blogrollpage_enabled) $w->link_target = '/brp-none/';
        if ($w->link_target == '/brp-none/' && $w->random_category == '/brp-none/') return;

        // Generates blogroll page URL if needed
        if ($w->link_target != '/brp-none/') {
			if ($w->link_target == '/brp-all/') $w->link_target = '';
			$brp_link = App::blog()->url().App::url()->getURLFor("blogroll"),$w->link_target);
		}

        $res = ($w->title ? $w->renderTitle(html::escapeHTML($w->title)) : '');

        if ($w->random_category != '/brp-none/') {
			if ($w->random_category == '/brp-all/') $w->random_category = '';
			
            $links = FrontendUrl::getBlogroll($w->random_category,$w->random_number);
            $res .= '<ul>';
            foreach ($links as $link) {
                $res .= '<li>'.Frontend::makeLink($link,$w->new_window).'</li>';
            }
            $res .= '</ul>';
		}

            if (isset($brp_link) && $w->link_title != '') {
                $res .= '<p><a href="'.$brp_link.'" title="'.$w->link_title.'">'.$w->link_title.'</a></p>';
            }
			
        return $w->renderDiv($w->content_only, 'blogroll ' . $w->class, '', $res);

    }
}



