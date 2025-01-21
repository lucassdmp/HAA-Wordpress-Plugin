<?php

namespace HAAPlugin\Plataform\Business;

use HAAPlugin\Common\DAO\OrderDAO;
use HAAPlugin\Common\Entity\OrderDTO;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class OrderBUS
 * 
 * Handles business logic for orders.
 */
class OrderBUS
{
    /**
     * The instance of OrderDAO.
     *
     * @var OrderDAO
     */
    private $orderDAO;

    /**
     * Constructor initializes the OrderDAO instance.
     */
    public function __construct()
    {
        $this->orderDAO = OrderDAO::get_instance();
    }

    /**
     * Get an order by its ID.
     *
     * @param int $id The order ID.
     * 
     * @return OrderDTO|null Returns an OrderDTO object if found, or null otherwise.
     */
    public function getOrderById(int $id): ?OrderDTO
    {
        return $this->orderDAO->getOrderById($id);
    }

    /**
     * Get orders by status.
     *
     * @param string $status The status to filter orders by.
     * 
     * @return OrderDTO[] An array of OrderDTO objects.
     */
    public function getOrdersByStatus(string $status): array
    {
        return $this->orderDAO->getOrdersByStatus($status);
    }

    /**
     * Get orders by a customer's billing email.
     *
     * @param string $billingEmail The customer's billing email.
     * 
     * @return OrderDTO[] An array of OrderDTO objects.
     */
    public function getOrdersByBillingEmail(string $billingEmail): array
    {
        return $this->orderDAO->getOrdersByBillingEmail($billingEmail);
    }

    /**
     * Get orders by currency.
     *
     * @param string $currency The currency to filter orders by.
     * 
     * @return OrderDTO[] An array of OrderDTO objects.
     */
    public function getOrdersByCurrency(string $currency): array
    {
        return $this->orderDAO->getOrdersByCurrency($currency);
    }

    /**
     * Get orders by payment method.
     *
     * @param string $paymentMethod The payment method to filter orders by.
     * 
     * @return OrderDTO[] An array of OrderDTO objects.
     */
    public function getOrdersByPaymentMethod(string $paymentMethod): array
    {
        return $this->orderDAO->getOrdersByPaymentMethod($paymentMethod);
    }
}
