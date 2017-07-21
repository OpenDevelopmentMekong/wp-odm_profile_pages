<?php
/**
 * Plugin Name: ODM Profile Pages
 * Plugin URI: http://github.com/OpenDevelopmentMekong/odm_profile_pages
 * Description: Internal wordpress plugin for exposing custom content type for profile pages
 * Version: 2.4.0
 * Author: Alex Corbi (mail@lifeformapps.com)
 * Author URI: http://www.lifeformapps.com
 * License: GPLv3.
 */

// Require utils
require_once plugin_dir_path(__FILE__).'utils/utils.php';

// Require post types
require_once plugin_dir_path(__FILE__).'post-types/profile-pages.php';

if (!class_exists('Odm_Profile_Pages_Plugin')) {

    class Odm_Profile_Pages_Plugin
    {
        private static $instance;

        private static $post_type;

        public static function get_instance()
        {
            if (null == self::$instance) {
                self::$instance = new self();
            }

            if (null == self::$post_type) {
              self::$post_type = new Odm_Profile_Pages_Post_Type();
            }

            return self::$instance;
        }

        public function __construct()
        {
            add_action('init', array($this, 'register_styles'));
						add_action('init', array($this, 'load_text_domain'));
            add_action('admin_notices', array($this, 'check_requirements'));
        }

        public function register_styles()
        {
            wp_enqueue_style('style-profiles',  plugin_dir_url(__FILE__).'css/profile-pages.css');
		        wp_enqueue_style('responsive-profiles',  plugin_dir_url(__FILE__).'css/responsive.css');
        }

				public function load_text_domain()
				{
					load_plugin_textdomain( 'wp-odm_profile_pages', false,  dirname( plugin_basename( __FILE__ ) ) . '/i18n' );
				}

        function check_requirements(){
          if (!check_requirements_profile_pages()):
            echo '<div class="error"><p>ODM Profile pages: WPCKAN plugin is missing, deactivated or missconfigured. Please check.</p></div>';
          endif;
        }

        public static function activate()
        {
            // Do nothing
        }

        public static function deactivate()
        {
            // Do nothing
        }
    }
}

if (class_exists('Odm_Profile_Pages_Plugin')) {
  register_activation_hook(__FILE__, array('Odm_Profile_Pages_Plugin', 'activate'));
  register_deactivation_hook(__FILE__, array('Odm_Profile_Pages_Plugin', 'deactivate'));
}

add_action('plugins_loaded', array('Odm_Profile_Pages_Plugin', 'get_instance'));
