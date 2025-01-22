<?php

namespace HAAPlugin\Common\Core;

use HAAPlugin\Plataform\Components\ListElement;

class ExportListElement
{
    /**
     * Directory path for the export files (within wp-content/uploads/haa-orders/).
     *
     * @var string
     */
    public $export_dir;

    /**
     * Public URL for accessing the exported files.
     *
     * @var string
     */
    public $export_url;

    /**
     * Constructor to initialize upload paths and ensure the directory exists.
     */
    public function __construct()
    {
        $upload_dir = wp_upload_dir();
        $this->export_dir = $upload_dir['basedir'] . '/haa-orders/';
        $this->export_url = $upload_dir['baseurl'] . '/haa-orders/';

        // Ensure the directory exists
        if (!file_exists($this->export_dir)) {
            wp_mkdir_p($this->export_dir);
        }
    }

    /**
     * Export the provided ListElement to a CSV file.
     *
     * @param ListElement $list_element The ListElement object to export.
     * @param string $filename The desired filename (optional).
     * @return string The URL of the exported CSV file.
     * @throws \Exception If an error occurs during file creation.
     */
    public function exportToCSV(ListElement $list_element, $filename = 'orders.csv')
    {
        $file_path = $this->export_dir . $filename;

        $file = fopen($file_path, 'w');
        if (!$file) {
            throw new \Exception('Failed to create CSV file at: ' . $file_path);
        }

        try {
            fputcsv($file, $list_element->getHeaders());

            foreach ($list_element->getRows() as $row) {
                fputcsv($file, $row->getData());
            }
        } finally {
            fclose($file);
        }

        return $this->export_url . $filename;
    }
}
