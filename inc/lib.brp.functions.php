<?php
/* This program is free software. It comes without any warranty, to
     * the extent permitted by applicable law. You can redistribute it
     * and/or modify it under the terms of the Do What The Fuck You Want
     * To Public License, Version 2, as published by Sam Hocevar. See
     * the LICENSE file or http://www.wtfpl.net/ for more details. */

if (!defined('DC_RC_PATH')) { return; }

abstract class functionsBlogrollPage
{
    public static function getBlogroll($category = null,$rand = null)
    {
        $blogroll = new dcBlogroll($GLOBALS['core']->blog);
        $links = $blogroll->getLinksHierarchy($blogroll->getLinks());

        if ($category) {
            if (!isset($links[$category])) {
                return '';
            }
            $links = array($links[$category]);
        }

        if (isset($rand)) {
            foreach ($links as $v) { foreach ($v as $_v) { $_links[] = $_v; } }
            $links = $_links;
            shuffle($links);
            if (count($links) > $rand || $rand != 0 || $rand != '') {
                $_links = array();
                for ($i = 0; $i < $rand; $i++) {
                    $_links[] = array_shift($links);
                    if (empty($links)) break;
                }
                $links = $_links;
            }
        }

        return $links;
    }

    public static function makeLink($link,$new_window = null)
    {
        $title = $link['link_title'];
        $href  = $link['link_href'];
        $desc = $link['link_desc'];
        $lang  = $link['link_lang'];
        $xfn = $link['link_xfn'];

        $link =
        '<a href="'.html::escapeHTML($href).'"'.
        ((!$lang) ? '' : ' hreflang="'.html::escapeHTML($lang).'"').
        ((!$desc) ? '' : ' title="'.html::escapeHTML($desc).'"').
        ((!$xfn) ? '' : ' rel="'.html::escapeHTML($xfn).'"').
        ((!$new_window) ? '' : ' onclick="window.open(this.href); return false;"').
        '>'.
        html::escapeHTML($title).
        '</a>';

        return $link;
    }
}
