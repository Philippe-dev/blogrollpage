<?php
/* This program is free software. It comes without any warranty, to
     * the extent permitted by applicable law. You can redistribute it
     * and/or modify it under the terms of the Do What The Fuck You Want
     * To Public License, Version 2, as published by Sam Hocevar. See
     * the LICENSE file or http://www.wtfpl.net/ for more details. */

if (!defined('DC_RC_PATH')) { return; }

abstract class behaviorsBlogrollPage
{
    public static function adminBlogPreferencesForm($core,$settings)
    {
        echo '<div class="fieldset"><h4>'.__('Blogroll page').'</h4>'.
        '<p><label class="classic">'.form::checkbox('blogrollpage_enabled','1',$settings->blogrollpage->blogrollpage_enabled).__('Enable blogroll page').'</label></p>'.
        '<p><label class="classic">'.form::checkbox('blogrollpage_new_window','1',$settings->blogrollpage->blogrollpage_new_window).__('Open links in new window').'</label></p>'.
        '</div>';
    }

    public static function adminBeforeBlogSettingsUpdate($settings)
    {
        $settings->addNameSpace('blogrollpage');
        $settings->blogrollpage->put('blogrollpage_enabled',!empty($_POST['blogrollpage_enabled']),'boolean');
        $settings->blogrollpage->put('blogrollpage_new_window',!empty($_POST['blogrollpage_new_window']),'boolean');
    }

    public static function publicBreadcrumb($context,$separator)
    {
        if ($context == 'blogroll') {
            if ($GLOBALS['_ctx']->blogrollpage_cat) {
                $u = $GLOBALS['core']->blog->url.$GLOBALS['core']->url->getURLFor('blogroll');

                return '<a href="'.$u.'">'.__('Links').'</a>'.$separator.$GLOBALS['_ctx']->blogrollpage_cat;
            } else {
                return __('Links');
            }
        }
    }
}
