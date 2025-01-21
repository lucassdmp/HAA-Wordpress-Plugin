<?php

namespace Src\Plataform\View;

class ExportFilter
{
    private static string $haa_exportfilter_container = "haa-exportfilter-container";
    private static string $haa_exportfilter_select = "haa-exportfilter-container";
    private static string $haa_exportfilter_button = "haa-exportfilter-container";

    private static $instance;

    private function __construct()
    {
        $this->init();
    }

    public static function get_instance(): ExportFilter   
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function init(){
        $this->enqueue_export_filter_scripts();
        $this->enqueue_export_filter_styles();
    }


    private function enqueue_export_filter_scripts(){
        wp_enqueue_scripts();
    }

    private function enqueue_export_filter_styles(){

    }

}