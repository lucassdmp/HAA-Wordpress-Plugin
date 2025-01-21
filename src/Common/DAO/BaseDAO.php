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
     * Public constructor to prevent direct instantiation.
     * Initializes the $wpdb instance.
     */
    public function __construct() {
        global $wpdb;
        $this->db_instance = $wpdb;
    }
}
