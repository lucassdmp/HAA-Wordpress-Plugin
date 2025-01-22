<?php

namespace HAAPlugin;

if (!defined('ABSPATH')) {
    exit;
}

use HAAPlugin\Plataform\View\AdminMenu;

class HeleneAbiassyAcademy
{
    /**
     * The ONE instance for the HAA plugin class
     * 
     *  @var HeleneAbiassyAcademy|null
     */
    private static $instance = null;

    /**
     * Constructor for the main HAA plugin class
     */
    private function __construct()
    {
        $this->define_constants();
        $this->add_hooks();
    }

    /**
     * Get the singleton instance of the HAA class.
     *
     * @return HeleneAbiassyAcademy
     */
    public static function get_instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Prevent cloning of the object
     */
    public function __clone()
    {
    }

    /**
     * Prevent unserializing the object
     */
    public function __wakeup()
    {
    }

    /**
     *  Define Plugin Constants
     */

    private function define_constants()
    {
        //Base Plugin Setup
        define("HAA_PLUGIN_VERSION", '1.0');
        define('HAA_PLUGIN_DIR', plugin_dir_path(__FILE__));
        define('HAA_PLUGIN_URL', plugin_dir_url(__FILE__));

        //Main Admin Menu Section
        define("HAA_ADMIN_PAGE_TITLE", "Helene Abiassy Academy");
        define("HAA_ADMIN_MENU_TITLE", "Helene Abiassy Academy");
        define("HAA_ADMIN_SLUG", "ha-academy");

        //Export Order Admin Menu Section
        define("HAA_EXPORT_ORDER_PAGE_TITLE", "Export WC Orders");
        define("HAA_EXPORT_ORDER_PAGE_MENU_TITLE", "Export WC Orders");
        define("HAA_EXPORT_ORDER_PAGE_SLUG", "export-wc-order");

        define("HAA_ASSETS_PATH", plugin_dir_path(__FILE__) . "../../assets/");
        define("HAA_JS_PATH", HAA_ASSETS_PATH . "js/");
        define("HAA_CSS_PATH", HAA_ASSETS_PATH . "css/");

    }

    /**
     * Add hooks and filters.
     */
    private function add_hooks()
    {
        add_action("admin_menu", [$this, 'initialize_admin_menu']);

        $this->initialize_bootstrap_header();
    }

    /**
     * Initializes the plugin
     */
    public function initialize_admin_menu()
    {
        $admin_menu = AdminMenu::get_instance();
    }

    /**
     * Add Bootstrap CSS to the WordPress front end and admin areas.
     */
    public function initialize_bootstrap_header()
    {
        // Enqueue Bootstrap CSS for the front end
        add_action('wp_enqueue_scripts', function () {
            wp_enqueue_style(
                'bootstrap-css',
                'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css',
                [],
                '5.1.3',
                'all'
            );
        });

        // Enqueue Bootstrap CSS for the admin area
        add_action('admin_enqueue_scripts', function () {
            wp_enqueue_style(
                'bootstrap-css-admin',
                'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css',
                [],
                '5.1.3',
                'all'
            );
        });
    }


}

