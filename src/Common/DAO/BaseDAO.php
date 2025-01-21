<?php

namespace HAAPlugin\Common\DAO;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class BaseDAO
 * 
 * Base class for all DAOs, manages the global $wpdb instance.
 * Implements the Singleton pattern to ensure only one instance of the class is created.
 */
class BaseDAO {
    /**
     * The database instance (global $wpdb)
     * 
     * @var \WPDB_INSTANCE
     */
    protected $db_instance;

    /**
     * Store the singleton instance
     * 
     * @var BaseDAO|null
     */
    private static $instance = null;

    /**
     * Private constructor to prevent direct instantiation.
     * Initializes the $wpdb instance.
     */
    private function __construct() {
        global $wpdb;
        $this->db_instance = $wpdb;
    }

    /**
     * Get the singleton instance of the BaseDAO class
     * 
     * @return BaseDAO
     */
    public static function get_instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Prevent cloning of the object
     */
    public function __clone() {}

    /**
     * Prevent unserializing the object
     */
    public function __wakeup() {}
}
