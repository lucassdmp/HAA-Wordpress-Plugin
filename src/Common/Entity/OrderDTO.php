<?php

namespace HAAPlugin\Common\Entity;

use DateTime;
use HAAPlugin\Business\CustomerBUS;
use HAAPlugin\Common\Entity\CustomerDTO;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Data Transfer Object (DTO) for an Order.
 * 
 * This class represents a data structure for an order, used to transfer
 * order-related data between layers in an application. It includes information
 * about the customer, order details, payment status, and items in the order.
 */
class OrderDTO
{
    /**
     * The unique identifier for the order (WC Order ID).
     * 
     * @var int
     */
    public int $ID;

    /**
     * Represents the customer who placed the order.
     * This is a reference to the CustomerDTO object that contains customer details.
     * 
     * @var CustomerDTO
     */
    public CustomerDTO $Customer;

    /**
     * The currency in which the order was made.
     * This is an Enum value representing the currency (USD, BRL, EUR).
     * 
     * @var string
     */
    public string $currency;

    /**
     * The total amount paid for the order in the selected currency.
     * 
     * @var float
     */
    public float $totalAmount;

    /**
     * The status of the order.
     * This is an Enum value representing the order status (e.g., processing, completed).
     * 
     * @var string
     */
    public string $status;

    /**
     * A list of items included in the order.
     * This is an array of OrderItemDTO objects.
     * 
     * @var OrderItemDTO[]
     */
    public array $items;

    /**
     * The exact time the order was processed.
     * 
     * @var DateTime
     */
    public DateTime $orderDate;

    /**
     * The country of origin for the order.
     * This is a string representing the country code or name where the order was made.
     * 
     * @var string
     */
    public string $origin;

    /**
     * Constructor for creating an OrderDTO object.
     *
     * @param int $orderId The order ID (WC Order ID).
     * @param string $billing_email The customer email for the order.
     * @param string $currency The currency in which the order was made (e.g., 'USD', 'BRL', 'EUR').
     * @param float $totalAmount The total amount paid for the order.
     * @param string $status The order status (e.g., 'processing', 'completed').
     * @param array $items An array of OrderItemDTO objects representing items in the order.
     * @param DateTime $orderDate The date and time when the order was processed.
     */
    public function __construct(
        int $ID,
        string $billing_email,
        string $currency,
        string $totalAmount,
        string $status,
        array $items
    ) {
        $customer_bus = new CustomerBUS();

        $this->ID = $ID;
        $this->Customer = $customer_bus->getCustomerByEmail($billing_email);
        $this->currency = $currency;
        $this->totalAmount = floatval($totalAmount);
        $this->status = $status;
        $this->items = $items;
    }
}
