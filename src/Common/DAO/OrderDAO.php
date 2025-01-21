<?php

namespace HAAPlugin\Common\DAO;

if (!defined('ABSPATH')) {
    exit;
}

use HAAPlugin\Common\Entity\OrderDTO;

/**
 * Class OrderDAO
 * 
 * Data Access Object for managing orders in the database.
 * Handles queries related to the `prefix_wc_orders` table.
 */
class OrderDAO extends BaseDAO
{
    /**
     * Table name for orders.
     *
     * @var string
     */
    private $ordersTable;

    /**
     * Store the singleton instance
     * 
     * @var OrderDAO|null
     */
    private static $instance = null;

    /**
     * Private constructor to initialize the orders table name.
     */
    private function __construct()
    {
        $BaseDAO__instace = BaseDAO::get_instance();
        $this->ordersTable = $this->db_instance->prefix . 'wc_orders';
    }

    /**
     * Get the singleton instance of the OrderDAO class.
     *
     * @return OrderDAO
     */
    public static function get_instance(): OrderDAO
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Get orders by status.
     *
     * @param string $status The order status to filter by.
     * 
     * @return OrderDTO[] An array of OrderDTO objects.
     */
    public function getOrdersByStatus(string $status): array
    {
        $query = $this->db_instance->prepare("SELECT * FROM {$this->ordersTable} WHERE status = %s", $status);
        $results = $this->db_instance->get_results($query);

        return $this->mapToOrderDTOArray($results);
    }

    /**
     * Get an order by ID.
     *
     * @param int $id The order ID.
     * 
     * @return OrderDTO|null Returns an OrderDTO object if found, or null if not found.
     */
    public function getOrderById(int $id): ?OrderDTO
    {
        $query = $this->db_instance->prepare("SELECT * FROM {$this->ordersTable} WHERE ID = %d", $id);
        $result = $this->db_instance->get_row($query);

        return $this->mapToOrderDTO($result);
    }

    /**
     * Get orders by billing email.
     *
     * @param string $billingEmail The billing email to filter by.
     * 
     * @return OrderDTO[] An array of OrderDTO objects.
     */
    public function getOrdersByBillingEmail(string $billingEmail): array
    {
        $query = $this->db_instance->prepare("SELECT * FROM {$this->ordersTable} WHERE billing_email = %s", $billingEmail);
        $results = $this->db_instance->get_results($query);

        return $this->mapToOrderDTOArray($results);
    }

    /**
     * Get orders by currency.
     *
     * @param string $currency The currency to filter by.
     * 
     * @return OrderDTO[] An array of OrderDTO objects.
     */
    public function getOrdersByCurrency(string $currency): array
    {
        $query = $this->db_instance->prepare("SELECT * FROM {$this->ordersTable} WHERE currency = %s", $currency);
        $results = $this->db_instance->get_results($query);

        return $this->mapToOrderDTOArray($results);
    }

    /**
     * Get orders by payment method.
     *
     * @param string $paymentMethod The payment method to filter by.
     * 
     * @return OrderDTO[] An array of OrderDTO objects.
     */
    public function getOrdersByPaymentMethod(string $paymentMethod): array
    {
        $query = $this->db_instance->prepare("SELECT * FROM {$this->ordersTable} WHERE payment_method = %s", $paymentMethod);
        $results = $this->db_instance->get_results($query);

        return $this->mapToOrderDTOArray($results);
    }

    /**
     * Private mapper function to map a single order object to an OrderDTO.
     *
     * @param \stdClass|null $orderObj The database order object.
     * 
     * @return OrderDTO|null The mapped OrderDTO or null if the object is null.
     */
    private function mapToOrderDTO($orderObj): ?OrderDTO
    {
        if (!$orderObj) {
            return null;
        }

        return new OrderDTO(
            (int) $orderObj->ID,
            (string) $orderObj->billing_email,
            (string) $orderObj->currency,
            (string) $orderObj->payment_method,
            (string) $orderObj->status,
            [],
        );
    }

    /**
     * Private helper to map an array of order objects to an array of OrderDTOs.
     *
     * @param array $orderObjs The database order objects.
     * 
     * @return OrderDTO[] An array of OrderDTOs.
     */
    private function mapToOrderDTOArray(array $orderObjs): array
    {
        return array_map([$this, 'mapToOrderDTO'], $orderObjs);
    }
}
