<?php
/* This program is free software. It comes without any warranty, to
     * the extent permitted by applicable law. You can redistribute it
     * and/or modify it under the terms of the Do What The Fuck You Want
     * To Public License, Version 2, as published by Sam Hocevar. See
     * the LICENSE file or http://www.wtfpl.net/ for more details. */

if (!defined('DC_CONTEXT_ADMIN')) { return; }

$core->addBehavior('adminBlogPreferencesForm',array('behaviorsBlogrollPage','adminBlogPreferencesForm'));
$core->addBehavior('adminBeforeBlogSettingsUpdate',array('behaviorsBlogrollPage','adminBeforeBlogSettingsUpdate'));

