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

class FrontendBehaviors
{
    public static function publicBreadcrumb(string $context): string
    {
        return $context === 'blogrollpage' ? __('Links') : '';
    }
}
