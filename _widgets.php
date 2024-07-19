<?php
/* This program is free software. It comes without any warranty, to
     * the extent permitted by applicable law. You can redistribute it
     * and/or modify it under the terms of the Do What The Fuck You Want
     * To Public License, Version 2, as published by Sam Hocevar. See
     * the LICENSE file or http://www.wtfpl.net/ for more details. */

if (!defined('DC_RC_PATH')) { return; }

abstract class widgetsBlogrollPage
{
    public static function initWidgets($w)
    {
        $br = new dcBlogroll($GLOBALS['core']->blog);
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

        $w->create('blogrollpage',__('Blogroll page'),array('widgetsBlogrollPage','getWidget'),null,'Blogroll page and random links');
        $w->blogrollpage->setting('title',__('Title (optional)'),__('Links'));
        $w->blogrollpage->setting('random_category',__('Show random links:'),'/brp-all/','combo',$cat_combo);
        $w->blogrollpage->setting('random_number',__('Number of links:'),5);
        $w->blogrollpage->setting('new_window',__('Open random links in new window'),0,'check');
        $w->blogrollpage->setting('link_title',__('Link to blogroll page title:'),__('More links...'));
        $w->blogrollpage->setting('link_target',__('Link target:'),'/brp-all/','combo',$target_combo);
        $w->blogrollpage->setting('homeonly',__('Display on:'),0,'combo',array(__('All pages') => 0, __('Home page only') => 1, __('Except on home page') => 2));
        $w->blogrollpage->setting('content_only',__('Content only'),0,'check');
        $w->blogrollpage->setting('class',__('CSS class:'),'');
    }

    public static function getWidget($w)
    {
        global $core;
        if (($w->homeonly == 1 && $core->url->type != 'default') ||
            ($w->homeonly == 2 && $core->url->type == 'default')) {
            return;
        }

        // Can't link to blogroll page if blogroll page disabled
        if (!$core->blog->settings->blogrollpage->blogrollpage_enabled) $w->link_target = '/brp-none/';
        if ($w->link_target == '/brp-none/' && $w->random_category == '/brp-none/') return;

        // Generates blogroll page URL if needed
        if ($w->link_target != '/brp-none/') {
			if ($w->link_target == '/brp-all/') $w->link_target = '';
			$brp_link = $core->blog->url.$core->url->getURLFor('blogroll',$w->link_target);
		}

        $res = ($w->title ? $w->renderTitle(html::escapeHTML($w->title)) : '');

        if ($w->random_category != '/brp-bone/') {
			if ($w->random_category == '/brp-all/') $w->random_category = '';
			
            $links = functionsBlogrollPage::getBlogroll($w->random_category,$w->random_number);
            $res .= '<ul>';
            foreach ($links as $link) {
                $res .= '<li>'.functionsBlogrollPage::makeLink($link,$w->new_window).'</li>';
            }
            $res .= '</ul>';
		}

            if (isset($brp_link) && $w->link_title != '') {
                $res .= '<p><a href="'.$brp_link.'" title="'.$w->link_title.'">'.$w->link_title.'</a></p>';
            }
			
        return $w->renderDiv($w->content_only, 'blogroll ' . $w->class, '', $res);

    }
}
