<?php

namespace HAAPlugin\Plataform\View;

use HAAPlugin\Plataform\Components\Button;
use HAAPlugin\Common\Core\ExportListElement;
use HAAPlugin\Plataform\Components\ListElement;

/**
 * ExportOrderListButton class
 * 
 * Represents a button that triggers the download of a CSV file with the order list when clicked.
 *
 * @package HAAPlugin\Plataform\View
 */
class ExportOrderListButton extends Button
{
    /**
     * @var ExportListElement
     */
    private $exportList;

    /**
     * Constructor to initialize the button with a custom label and attributes.
     * It also initializes the ExportListElement object.
     *
     * @param string $label The label of the button.
     * @param array $attributes Optional additional attributes for the button.
     */
    public function __construct(string $label = 'Export Order List', array $attributes = [])
    {
        // Set custom label and additional attributes
        parent::__construct($label, 'button', $attributes);
        $this->exportList = new ExportListElement();
    }

    /**
     * Generate the HTML for the button, including the functionality to trigger the CSV download.
     *
     * @return string The HTML string for the button.
     */
    public function render(): string
    {
        // Add custom JS to trigger CSV download on click
        $attributesString = $this->buildAttributes();
        $attributesString .= ' onclick="exportOrderListCSV()"';

        return sprintf(
            '<button type="%s"%s>%s</button>',
            htmlspecialchars($this->type),
            $attributesString,
            htmlspecialchars($this->label)
        );
    }

    /**
     * Generate the JavaScript for the CSV download trigger.
     *
     * @return string The JavaScript code for triggering the CSV download.
     */
    public function get_download_script(ListElement $listElement): string
    {
        // Generate the URL for the CSV file
        $csvUrl = $this->exportList->exportToCSV($listElement);

        return "
            <script>
                function exportOrderListCSV() {
                    window.location.href = '$csvUrl';
                }
            </script>
        ";
    }
}
