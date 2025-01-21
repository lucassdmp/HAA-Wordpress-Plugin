<?php

namespace HAAPlugin\Plataform\Business;

if (!defined('ABSPATH')) {
    exit;
}

use HAAPlugin\Common\DAO\CustomerDAO;
use HAAPlugin\Common\Entity\CustomerDTO;

/**
 * Class CustomerBUS
 * 
 * Business logic for managing customer-related operations.
 */
class CustomerBUS
{
    /**
     * The instance of CustomerDAO.
     *
     * @var CustomerDAO
     */
    private $customerDAO;

    /**
     * Constructor to initialize CustomerDAO.
     */
    public function __construct()
    {
        $this->customerDAO = CustomerDAO::get_instance();
    }

    /**
     * Get a customer by their ID.
     *
     * @param int $id The customer ID.
     * 
     * @return CustomerDTO|null Returns a CustomerDTO object if found, or null if not found.
     */
    public function getCustomerById(int $id): ?CustomerDTO
    {
        return $this->customerDAO->getCustomerById($id);
    }

    /**
     * Get a customer by their email address.
     *
     * @param string $email The email address.
     * 
     * @return CustomerDTO|null Returns a CustomerDTO object if found, or null if not found.
     */
    public function getCustomerByEmail(string $email): ?CustomerDTO
    {
        return $this->customerDAO->getCustomerByEmail($email);
    }

    /**
     * Get all customers by display name.
     *
     * @param string $displayName The display name to filter by.
     * 
     * @return CustomerDTO[] An array of CustomerDTO objects.
     */
    public function getCustomersByDisplayName(string $displayName): array
    {
        return $this->customerDAO->getCustomersByDisplayName($displayName);
    }

    /**
     * Get all customers who have made any order.
     *
     * @return CustomerDTO[] An array of CustomerDTO objects.
     */
    public function getAllCustomerWithOrders(): array
    {
        return $this->customerDAO->getAllCustomerWithOrders();
    }
}
