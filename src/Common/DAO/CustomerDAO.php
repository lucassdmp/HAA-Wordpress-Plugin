<?php

namespace HAAPlugin\Common\DAO;

if (!defined('ABSPATH')) {
    exit;
}

use HAAPlugin\Common\Entity\CustomerDTO;

/**
 * Class CustomerDAO
 * 
 * Data Access Object for managing customers in the database.
 * Handles queries related to the `users` table.
 */
class CustomerDAO extends BaseDAO
{
    /**
     * Table name for users.
     *
     * @var string
     */
    private $usersTable;

    /**
     * Store the singleton instance.
     *
     * @var CustomerDAO|null
     */
    private static $instance = null;

    /**
     * Private constructor to initialize the users table name.
     */
    private function __construct()
    {
        $BaseDAO__instace = BaseDAO::get_instance();
        $this->usersTable = $this->db_instance->users;
    }

    /**
     * Get the singleton instance of the CustomerDAO class.
     *
     * @return CustomerDAO
     */
    public static function get_instance(): CustomerDAO
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Get customer data by customer ID.
     *
     * @param int $id The customer ID.
     * 
     * @return CustomerDTO|null Returns a CustomerDTO object if found, or null if not found.
     */
    public function getCustomerById(int $id): ?CustomerDTO
    {
        $query = $this->db_instance->prepare("SELECT * FROM {$this->usersTable} WHERE ID = %d", $id);
        $result = $this->db_instance->get_row($query);

        return $this->mapToCustomerDTO($result);
    }

    /**
     * Retrieves customer data by email.
     *
     * @param string $email The email address of the customer to fetch.
     * 
     * @return CustomerDTO|null Returns a CustomerDTO object if found, or null if not found.
     */
    public function getCustomerByEmail(string $email): ?CustomerDTO
    {
        $query = $this->db_instance->prepare("SELECT * FROM {$this->usersTable} WHERE user_email = %s", $email);
        $result = $this->db_instance->get_row($query);

        return $this->mapToCustomerDTO($result);
    }

    /**
     * Get all customers with a specific display name.
     *
     * @param string $displayName The display name to filter by.
     * 
     * @return CustomerDTO[] An array of CustomerDTO objects.
     */
    public function getCustomersByDisplayName(string $displayName): array
    {
        $query = $this->db_instance->prepare("SELECT * FROM {$this->usersTable} WHERE display_name = %s", $displayName);
        $results = $this->db_instance->get_results($query);

        return $this->mapToCustomerDTOArray($results);
    }

    /**
     * Private mapper function that maps a database row to a CustomerDTO.
     *
     * @param \stdClass|null $userObj The WordPress user object.
     * 
     * @return CustomerDTO|null The mapped CustomerDTO or null if the object is null.
     */
    private function mapToCustomerDTO($userObj): ?CustomerDTO
    {
        if (!$userObj) {
            return null;
        }

        return new CustomerDTO(
            (int) $userObj->ID,
            (string) $userObj->user_email,
            (string) $userObj->display_name
        );
    }

    /**
     * Private helper to map an array of database rows to an array of CustomerDTO objects.
     *
     * @param array $userObjs The database user objects.
     * 
     * @return CustomerDTO[] An array of CustomerDTO objects.
     */
    private function mapToCustomerDTOArray(array $userObjs): array
    {
        return array_map([$this, 'mapToCustomerDTO'], $userObjs);
    }
}
