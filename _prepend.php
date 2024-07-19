<?php
/* This program is free software. It comes without any warranty, to
     * the extent permitted by applicable law. You can redistribute it
     * and/or modify it under the terms of the Do What The Fuck You Want
     * To Public License, Version 2, as published by Sam Hocevar. See
     * the LICENSE file or http://www.wtfpl.net/ for more details. */

if (!defined('DC_RC_PATH')) { return; }

$__autoload['functionsBlogrollPage'] = dirname(__FILE__).'/inc/lib.brp.functions.php';
$__autoload['behaviorsBlogrollPage'] = dirname(__FILE__).'/inc/lib.brp.behaviors.php';
$__autoload['widgetsBlogrollPage'] = dirname(__FILE__).'/_widgets.php';

$core->addBehavior('initWidgets',array('widgetsBlogrollPage','initWidgets'));
$core->url->register('blogroll','blogroll','^blogroll(?:/?)(.+)?$',array('urlBlogrollPage','blogroll'));
