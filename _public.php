<?php
/* This program is free software. It comes without any warranty, to
     * the extent permitted by applicable law. You can redistribute it
     * and/or modify it under the terms of the Do What The Fuck You Want
     * To Public License, Version 2, as published by Sam Hocevar. See
     * the LICENSE file or http://www.wtfpl.net/ for more details. */

if (!defined('DC_RC_PATH')) { return; }

$core->addBehavior('publicBreadcrumb',array('behaviorsBlogrollPage','publicBreadcrumb'));

$core->tpl->addBlock('BlogrollPage',array('tplBlogrollPage','BlogrollPage'));
$core->tpl->addValue('BlogrollPageTitle',array('tplBlogrollPage','Title'));
$core->tpl->addBlock('BlogrollPageIfTitle',array('tplBlogrollPage','IfTitle'));
$core->tpl->addBlock('BlogrollPageIfCategoryTitle',array('tplBlogrollPage','IfCategoryTitle'));
$core->tpl->addValue('BlogrollPageCategoryTitle',array('tplBlogrollPage','CategoryTitle'));
$core->tpl->addBlock('BlogrollPageLinks',array('tplBlogrollPage','Links'));
$core->tpl->addValue('BlogrollPageLink',array('tplBlogrollPage','Link'));
$core->tpl->addValue('BlogrollPageLinkTitle',array('tplBlogrollPage','LinkTitle'));
$core->tpl->addValue('BlogrollPageLinkHref',array('tplBlogrollPage','LinkHref'));
$core->tpl->addBlock('BlogrollPageIfLinkDesc',array('tplBlogrollPage','IfLinkDesc'));
$core->tpl->addValue('BlogrollPageLinkDesc',array('tplBlogrollPage','LinkDesc'));
$core->tpl->addBlock('BlogrollPageIfLinkLang',array('tplBlogrollPage','IfLinkLang'));
$core->tpl->addValue('BlogrollPageLinkLang',array('tplBlogrollPage','LinkLang'));
$core->tpl->addBlock('BlogrollPageIfLinkXFN',array('tplBlogrollPage','IfLinkXFN'));
$core->tpl->addValue('BlogrollPageLinkXFN',array('tplBlogrollPage','LinkXFN'));

abstract class urlBlogrollPage extends dcUrlHandlers
{
    public static function blogroll($args)
    {
        $_ctx = &$GLOBALS['_ctx'];
        $core = &$GLOBALS['core'];

        if (!$core->blog->settings->blogrollpage->blogrollpage_enabled) {
            self::p404();
        }

        if ($args != '') {
            $blogroll = functionsBlogrollPage::getBlogroll(urldecode($args));
            if (!$blogroll) {
                dcUrlHandlers::p404();
            } else {
                $_ctx->blogrollpage_cat = $args;
            //	$GLOBALS['_ctx']->blogrollpage_blogroll = $blogroll;
            }
        } else {
            $blogroll = functionsBlogrollPage::getBlogroll();
        }

        $_ctx->blogrollpage_blogroll = $blogroll;

        $core->tpl->setPath($core->tpl->getPath(), dirname(__FILE__).'/../default-templates');

        $tplset = $core->themes->moduleInfo($core->blog->settings->system->theme, 'tplset');
        if (!empty($tplset) && is_dir(dirname(__FILE__) . '/default-templates/' . $tplset)) {
            $core->tpl->setPath($core->tpl->getPath(), dirname(__FILE__) . '/default-templates/' . $tplset);
        } else {
            $core->tpl->setPath($core->tpl->getPath(), dirname(__FILE__) . '/default-templates/' . DC_DEFAULT_TPLSET);
        }
        self::serveDocument('blogroll.html');
        //exit;
    }
}

abstract class tplBlogrollPage
{
    public static function BlogrollPage($attr,$content)
    {
        $res = '<?php foreach ($_ctx->blogrollpage_blogroll as $category => $links) { ?>';
        $res .= $content;
        $res .= '<?php } ?>';

        return $res;
    }

    public static function IfTitle($attr,$content)
    {
        $res = '<?php $brp_cat = $_ctx->blogrollpage_cat; if (!empty($brp_cat)) { ?>';
        $res .= $content;
        $res .= '<?php } ?>';

        return $res;
    }

    public static function Title($attr)
    {
        $f = $GLOBALS['core']->tpl->getFilters($attr);

        return '<?php echo '.sprintf($f,'$brp_cat').'; ?>';
    }

    public static function IfCategoryTitle($attr,$content)
    {
        $res = '<?php if (!empty($category)) { ?>';
        $res .= $content;
        $res .= '<?php } ?>';

        return $res;
    }

    public static function CategoryTitle($attr)
    {
        $f = $GLOBALS['core']->tpl->getFilters($attr);

        return '<?php echo '.sprintf($f,'$category').'; ?>';
    }

    public static function Links($attr,$content)
    {
        $res = '<?php foreach ($links as $link) { ?>';
        $res .= $content;
        $res .= '<?php } ?>';

        return $res;
    }

    public static function Link($attr)
    {
        return '<?php echo functionsBlogrollPage::makeLink($link,$core->blog->settings->blogrollpage->blogrollpage_new_window); ?>';
    }

    public static function LinkTitle($attr)
    {
        $f = $GLOBALS['core']->tpl->getFilters($attr);

        return '<?php echo '.sprintf($f,'$link[\'link_title\']').'; ?>';
    }

    public static function LinkHref($attr)
    {
        $f = $GLOBALS['core']->tpl->getFilters($attr);

        return '<?php echo '.sprintf($f,'$link[\'link_href\']').'; ?>';
    }

    public static function IfLinkDesc($attr,$content)
    {
        $res = '<?php if (!empty($link[\'link_desc\'])) { ?>';
        $res .= $content;
        $res .= '<?php } ?>';

        return $res;
    }

    public static function LinkDesc($attr)
    {
        $f = $GLOBALS['core']->tpl->getFilters($attr);

        return '<?php echo '.sprintf($f,'$link[\'link_desc\']').'; ?>';
    }

    public static function IfLinkLang($attr,$content)
    {
        $res = '<?php if (!empty($link[\'link_lang\'])) { ?>';
        $res .= $content;
        $res .= '<?php } ?>';

        return $res;
    }

    public static function LinkLang($attr)
    {
        $f = $GLOBALS['core']->tpl->getFilters($attr);

        return '<?php echo '.sprintf($f,'$link[\'link_lang\']').'; ?>';
    }

    public static function IfLinkXFN($attr,$content)
    {
        $res = '<?php if (!empty($link[\'link_xfn\'])) { ?>';
        $res .= $content;
        $res .= '<?php } ?>';

        return $res;
    }

    public static function LinkXFN($attr)
    {
        $f = $GLOBALS['core']->tpl->getFilters($attr);

        return '<?php echo '.sprintf($f,'$link[\'link_xfn\']').'; ?>';
    }
}
