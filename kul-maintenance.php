<?php
/*
	Plugin Name: Kul Maintenance
	Plugin URI: http://wordpress.org/plugins/kul-maintenance/
	Description: Used for Maintenance mode with slider and contact form while updating or used as coming soon.
	Version: 1.4.1
	Author: kulchan.pvt.ltd, Kaushal Dip Subba
	Twitter: kulchanpvtltd
	Author URI: http://kaushaldip.com
	Text Domain: kul-maintenance
	License URI: http://www.gnu.org/licenses/gpl-2.0.txt
	License: GPL2
*/

/*  Copyright 2020  Kaushal dip Subba.  (email : kulchan.kaushal@gmail.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as 
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
if (!defined('ABSPATH')) {
    exit;
}

//checking if class is predefine or not
if (!class_exists('Kul_maintenance')) :

    class Kul_maintenance
    {
        function __construct()
        {
            add_action('plugins_loaded', array(&$this, 'constants'), 1);
            add_action('plugins_loaded', array(&$this, 'required'), 2);
            add_action('plugins_loaded', array(&$this, 'admin'), 3);

            register_activation_hook(__FILE__, array(&$this, 'activation'));
            register_deactivation_hook(__FILE__, array(&$this, 'deactivation'));
            global $kul_maintenance_variable;
            $kul_maintenance_variable = new stdClass;

            add_action('wp', array(&$this, 'kul_redirection'), 1);
            add_action('wp_logout', array(&$this, 'kul_logout'));
            add_action('upgrader_process_complete', 'my_upgrade_function', 10, 2);
        }

        function constants()
        {
            define('KUL_MAINTENANCE_VERSION', '1.1');
            define('KUL_MAINTENANCE_DB_VERSION', 1);
            define('KUL_MAINTENANCE_WP_VERSION', get_bloginfo('version'));
            define('KUL_MAINTENANCE_DIR', trailingslashit(plugin_dir_path(__FILE__)));
            define('KUL_MAINTENANCE_URI', trailingslashit(plugin_dir_url(__FILE__)));
            define('KUL_MAINTENANCE_REQUIRED', KUL_MAINTENANCE_DIR . trailingslashit('require'));
            define('KUL_MAINTENANCE_VIEW', KUL_MAINTENANCE_DIR . trailingslashit('view'));
        }

        function required()
        {
            require_once(KUL_MAINTENANCE_REQUIRED . 'functions.php');
            //require_once( KUL_MAINTENANCE_INCLUDES . 'update.php' );
            require_once(KUL_MAINTENANCE_DIR . 'view/functions.php');
        }

        function admin()
        {
            if (is_admin()) {
                require_once(KUL_MAINTENANCE_REQUIRED . 'admin.php');
            }
        }

        function activation()
        {
            $kul_option = get_option('kul_maintenance_options');

            if (!$kul_option) {
                $this->install_databasefile();
            }
        }

        function deactivation()
        {
        }

        function kul_logout()
        {
            wp_safe_redirect(site_url());
            exit;
        }

        function kul_redirection()
        {
            kul_run_redirection();
        }

        function install_databasefile()
        {
            require_once(trailingslashit(plugin_dir_path(__FILE__)) . 'install.php');
        }

        function check_slider_active()
        {
            $kul_maintenance_slider_status = get_option('kul_maintenance_slider_status');

            if (!$kul_maintenance_slider_status) {
                update_option('kul_maintenance_slider_status', 'true');
            }
        }


        function my_upgrade_function($upgrader_object, $options)
        {
            $current_plugin_path_name = plugin_basename(__FILE__);

            if ($options['action'] == 'update' && $options['type'] == 'plugin') {
                foreach ($options['packages'] as $each_plugin) {
                    if ($each_plugin == $current_plugin_path_name) {
                        $this->check_slider_active();
                    }
                }
            }
        }

    }

    $kul_maintenance = new Kul_maintenance();
endif;