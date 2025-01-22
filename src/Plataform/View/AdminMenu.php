<?php

namespace HAAPlugin\Plataform\View;

if (!defined('ABSPATH')) {
    exit;
}

use HAAPlugin\Plataform\View\ExportFilter;
use HAAPlugin\Plataform\View\OrderList;

/**
 * AdminMenu class
 * 
 * This class handles the creation and management of the admin menu in the WordPress dashboard. It ensures that the main plugin menu and relevant submenu pages, such as the order export section, are added to the WordPress admin sidebar.
 * 
 */
class AdminMenu
{

    /**
     * Singleton instance of the AdminMenu class.
     * 
     * @var AdminMenu|null
     */
    private static $instance = null;

    /**
     * Private constructor to prevent multiple instances of the AdminMenu class.
     * Initializes the main admin menu and order export admin section.
     */
    private function __construct()
    {
        $this->initiatiate_main_admin_menu();
        $this->initiate_order_export_admin_section();
    }

    /**
     * Retrieves the Singleton instance of the AdminMenu class.
     * If no instance exists, it creates one.
     *
     * @return AdminMenu The instance of the AdminMenu class.
     */
    public static function get_instance(): AdminMenu
    {
        if (is_null(self::$instance)) {
            self::$instance = new AdminMenu();
        }
        return self::$instance;
    }

    /**
     * Initializes the main admin menu page.
     * Registers a top-level menu in the WordPress admin sidebar.
     * 
     * @return void
     */
private function initiatiate_main_admin_menu()
{
    // Path to your SVG file
    $svg_url = 'https://www.heleneabiassi.academy/wp-content/uploads/2024/04/ICONS-EBOOK-HELENE-02.svg';
    // Get the SVG content
    $svg_content = file_get_contents($svg_url);
    // Encode the SVG to Base64
    $base64_svg = base64_encode($svg_content);
    
    // Use the Base64 encoded SVG as the menu icon
    add_menu_page(
        HAA_ADMIN_PAGE_TITLE,    // Page title
        HAA_ADMIN_MENU_TITLE,    // Menu title
        'manage_options',        // Capability required
        HAA_ADMIN_SLUG,          // Menu slug
        [$this, 'show_main_admin_menu_content'], // Callback function for content
        'data:image/svg+xml;base64,' . $base64_svg, // Base64 encoded SVG as icon
        3 // Position of the menu item
    );
}

    /**
     * Initializes the order export admin section as a submenu.
     * Registers a submenu under the main plugin menu for order export functionality.
     * 
     * @return void
     */
    private function initiate_order_export_admin_section()
    {
        add_submenu_page(
            HAA_ADMIN_SLUG,               // Parent slug
            HAA_EXPORT_ORDER_PAGE_TITLE,  // Page title
            HAA_EXPORT_ORDER_PAGE_MENU_TITLE, // Submenu title
            'manage_options',             // Capability required
            HAA_EXPORT_ORDER_PAGE_SLUG,   // Submenu slug
            [$this, 'show_export_admin_section'] // Callback function for content
        );
        
    }

    /**
     * Displays content for the main admin menu page.
     * This is the main page content that appears when the top-level menu is clicked.
     * 
     * @return void
     */
    public function show_main_admin_menu_content()
    {
        echo '<h1>Helene Abiassy Academy!</h1>';
    }

    /**
     * Displays content for the export admin section.
     * This is the settings page content for the order export submenu.
     * 
     * @return void
     */
    public function show_export_admin_section()
    {
        echo '<h1>Export WC Orders</h1>';
        // Define headers

       ExportFilter::get_instance()->render();
       $OrderList = OrderList::get_instance()->GetOrderList();
       $exportButton = new ExportOrderListButton("Export Order", ['class' => 'btn btn-primary']);

       echo $exportButton->render();
       echo $OrderList->render();
       echo $exportButton->get_download_script($OrderList);
       
    }
}
