<?php

namespace HAAPlugin\Common\Entity;

use DateTime;
use HAAPlugin\Common\Entity\OrderMetaDTO;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Data Transfer Object (DTO) for an Order.
 *
 * This class encapsulates order-related data for transferring information
 * between layers of the application. It includes details about the order,
 * customer, payment, items, and billing information.
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
     * The email of the customer who placed the order.
     *
     * @var string|null
     */
    public ?string $Customer;

    /**
     * The currency of the order (e.g., 'USD', 'BRL', 'EUR').
     *
     * @var string
     */
    public string $currency;

    /**
     * The total amount paid for the order.
     *
     * @var float
     */
    public float $totalAmount;

    /**
     * The current status of the order (e.g., 'processing', 'completed').
     *
     * @var string
     */
    public string $status;

    /**
     * An array of items included in the order.
     *
     * @var OrderItemDTO[]
     */
    public array $items;

    /**
     * The date and time the order was processed.
     *
     * @var DateTime
     */
    public DateTime $orderDate;

    /**
     * The country where the order originated.
     *
     * @var string
     */
    public string $origin;

    /**
     * The payment method used for the order (e.g., 'credit_card', 'paypal').
     *
     * @var string
     */
    public string $payment_method;

    /**
     * The display name for the payment method (e.g., 'Credit Card', 'PayPal').
     *
     * @var string
     */
    public string $payment_method_title;

    /**
     * The metadata for Billing data.
     *
     * @var OrderMetaDTO|null
     */
    public ?OrderMetaDTO $billing_data;

    /**
     * Constructor for creating an OrderDTO object.
     *
     * @param int $ID The unique order ID (WC Order ID).
     * @param string $billing_email The email address of the customer.
     * @param string $currency The currency in which the order was made (e.g., 'USD', 'BRL').
     * @param string $totalAmount The total amount paid for the order.
     * @param string $status The status of the order (e.g., 'processing', 'completed').
     * @param array $items An array of OrderItemDTO objects representing the items in the order.
     * @param string $payment_method The payment method used for the order.
     * @param string $payment_method_title The display name of the payment method.
     * @param OrderMetaDTO $billing_data A string containing billing data, with fields separated by double spaces.
     */
    public function __construct(
        int $ID,
        string $billing_email,
        string $currency,
        string $totalAmount,
        string $status,
        array $items,
        string $payment_method,
        string $payment_method_title,
        ?OrderMetaDTO $billing_data = null
    ) {
        $this->ID = $ID;
        $this->Customer = $billing_email;
        $this->currency = $currency;
        $this->totalAmount = floatval($totalAmount);
        $this->status = $status;
        $this->items = $items;
        $this->payment_method = $payment_method;
        $this->payment_method_title = $payment_method_title;
        $this->billing_data = $billing_data;
    }

    public function toCSV()
    {
        $csvData = [
            $this->ID,
            $this->Customer,
            $this->currency,
            $this->totalAmount,
            $this->status,
            $this->payment_method,
            $this->payment_method_title
        ];
    
        if ($this->billing_data) {
            $csvData = array_merge($csvData, [
                $this->billing_data->customer_name,
                $this->billing_data->customer_billing_address,
                $this->billing_data->customer_billing_city,
                $this->billing_data->customer_billing_state,
                $this->billing_data->customer_postal_code,
                $this->billing_data->customer_billing_country
            ]);
        }
    
        return $csvData;
    }
    
}
