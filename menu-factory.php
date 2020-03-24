<?php

/**
 * Plugin Name:       Menu Factory
 * Plugin URI:        https://menu-factory.gutenburger.com
 * Description:       A tiny Factory for building menus automatically from taxonomy, maintaining the exact hierarchy.
 * Version:           1.0.0
 * Author:            Sharif Mohammad Eunus
 * Author URI:        https://smeunus.github.io
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       menu-factory
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org.
 */
define('MENU_FACTORY_VERSION', '1.0.0');

require_once plugin_dir_path(__FILE__) . 'admin/callbacks.php';
require_once plugin_dir_path(__FILE__) . 'admin/menu-factory-admin.php';
require_once plugin_dir_path(__FILE__) . 'menu-factory-nav.php';

function menu_factory_initialize()
{
    global $pagenow;

    if (is_admin()) {
        (new Menu_Factory_Admin)->register();
    }

    if ($pagenow == 'nav-menus.php') {
        (new Menu_Factory_Nav)->register();
    }
}

menu_factory_initialize();
