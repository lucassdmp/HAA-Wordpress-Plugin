<?php

namespace HAAPlugin\Plataform\View;

use HAAPlugin\Plataform\Business\CustomerBUS;
use HAAPlugin\Plataform\Components\Dropdown;

/**
 * Class ExportFilter
 * 
 * Handles the rendering of the export filter UI, utilizing reusable Dropdown components.
 * Enqueues necessary scripts and styles for functionality.
 */
class ExportFilter
{
    /**
     * The CSS class for the export filter container.
     * 
     * @var string
     */
    private static string $haa_exportfilter_container = "haa-exportfilter-container";

    /**
     * Singleton instance of ExportFilter.
     * 
     * @var ExportFilter|null
     */
    private static $instance;

    /**
     * Private constructor to initialize the class.
     */
    private function __construct()
    {
        $this->init();
    }

    /**
     * Get the singleton instance of ExportFilter.
     * 
     * @return ExportFilter
     */
    public static function get_instance(): ExportFilter
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Initialize the class by enqueuing scripts and styles.
     */
    private function init()
    {
        $this->enqueue_export_filter_scripts();
        $this->enqueue_export_filter_styles();
    }

    /**
     * Enqueue the JavaScript for the export filter functionality.
     */
    private function enqueue_export_filter_scripts()
    {
        wp_enqueue_script(
            'haa-export-filter',
            HAA_JS_PATH . "haa-export-filter.js",
            ['jquery'],
            '1.0.0',
            true
        );

        wp_localize_script('haa-export-filter', 'haaExportFilterData', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('haa-export-filter-nonce'),
        ]);
    }

    /**
     * Enqueue the CSS for the export filter UI.
     */
    private function enqueue_export_filter_styles()
    {
        wp_enqueue_style(
            'haa-exportfilter-style',
            HAA_CSS_PATH . "export-filter.css",
            [],
            '1.0.0'
        );
    }

    /**
     * Render the export filter HTML using Dropdown components.
     * 
     * @return string The HTML for the export filter.
     */
    public function render(): string
    {
        $CustomerBUS = new CustomerBUS();
        // Define options for the dropdowns
        $currencyOptions = [
            '' => 'Select Currency',
            'USD' => 'USD',
            'BRL' => 'BRL',
            'EUR' => 'EUR'
        ];

        $statusOptions = [
            '' => 'Select Status',
            'processing' => 'Processing',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled'
        ];

        $customerOptions = $this->mapCustomerListToDropDownList($CustomerBUS->getAllCustomerWithOrders());

        $paymentOptions = [
            '' => 'Select Payment Method',
            'eupago_multibanco' => 'Multibanco',
            'eupago_cc' => 'EUPAGO - Cartão de Crédito',
            'pix' => 'PIX'
        ];

        // Create Dropdown instances
        $currencyDropdown = new Dropdown($currencyOptions, 'Moeda', null, ['class' => 'form-select']);
        $statusDropdown = new Dropdown($statusOptions, 'Status', null, ['class' => 'form-select']);
        $customerDropdown = new Dropdown($customerOptions, 'Cliente', null, ['class' => 'form-select']);
        $paymentDropdown = new Dropdown($paymentOptions, 'Metodo de Pagamento', null, ['class' => 'form-select']);

        // Render HTML
        ob_start();
        ?>
        <div class="<?php echo esc_attr(self::$haa_exportfilter_container); ?> container mt-4">
            <form id="haa-exportfilter-form" class="row gx-2 gy-2 align-items-center">
                <div class="col-md-3">
                    <label for="filter-currency" class="form-label">Currency</label>
                    <?php echo $currencyDropdown->render(); ?>
                </div>
                <div class="col-md-3">
                    <label for="filter-status" class="form-label">Status</label>
                    <?php echo $statusDropdown->render(); ?>
                </div>
                <div class="col-md-3">
                    <label for="filter-customer" class="form-label">Customer</label>
                    <?php echo $customerDropdown->render(); ?>
                </div>
                <div class="col-md-3">
                    <label for="filter-payment" class="form-label">Payment Method</label>
                    <?php echo $paymentDropdown->render(); ?>
                </div>
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary">
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>
        <?php
        return ob_get_clean();
    }

    private function mapCustomerListToDropDownList($array){
        $return_array = array();
        $return_array["0"] = "Usuário";
        
        foreach($array as $customer){
           
            $return_array[$customer->ID] = $customer->display_name;
        }

        return $return_array;
    }
}
