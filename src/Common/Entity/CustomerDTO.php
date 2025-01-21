<?php

namespace HAAPlugin\Common\Entity;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Data Transfer Object (DTO) for a Customer.
 * 
 * This class represents a data structure for a customer, used to transfer
 * customer-related data between layers in an application.
 */
class CustomerDTO
{
    /**
     * The unique identifier for the customer.
     * 
     * @var int
     */
    public int $ID;

    /**
     * The email address of the customer.
     * 
     * @var string
     */
    public string $email;

    /**
     * The display name of the customer.
     * This can be used to represent the customer in the UI or for personalization.
     * 
     * @var string
     */
    public string $display_name;

    /**
     * CustomerDTO constructor.
     * 
     * Initializes a new instance of the CustomerDTO class with the specified customer data.
     * 
     * @param int $ID The unique identifier for the customer.
     * @param string $email The email address of the customer.
     * @param string $display_name The display name of the customer.
     */
    public function __construct(int $ID, string $email, string $display_name)
    {
        $this->ID = $ID;
        $this->email = $email;
        $this->display_name = $display_name;
    }
}
