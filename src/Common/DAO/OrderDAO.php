<?php

namespace HAAPlugin\Common\DAO;

if (!defined('ABSPATH')) {
    exit;
}

use HAAPlugin\Common\Entity\OrderDTO;
use HAAPlugin\Common\Entity\OrderMetaDTO;

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
    private string $ordersTable;
    private string $ordersMetaTable;

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
        parent::__construct();
        $this->ordersTable = $this->db_instance->prefix . 'wc_orders';
        $this->ordersMetaTable = $this->db_instance->prefix . 'wc_orders_meta';
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

        $meta = $this->db_instance->get_results($this->db_instance->prepare("SELECT * FROM {$this->ordersMetaTable} where order_id = %d AND meta_key = %s", $result->id, '_shipping_address_index'));

        return $this->mapToOrderDTO($result, new OrderMetaDTO($meta));
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
        $query = $this->db_instance->prepare("SELECT * FROM {$this->db_instance->ordersTable} WHERE billing_email = %s", $billingEmail);
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
        $query = $this->db_instance->prepare("SELECT * FROM {$this->db_instance->ordersTable} WHERE currency = %s", $currency);
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
        $query = $this->db_instance->prepare("SELECT * FROM {$this->db_instance->ordersTable} WHERE payment_method = %s", $paymentMethod);
        $results = $this->db_instance->get_results($query);

        return $this->mapToOrderDTOArray($results);
    }

    /**
     * Get all orders
     * 
     * @return OrderDTO[] An array of OrderDTO objects.
     */
    public function getAllOrders()
    {
        $results = $this->db_instance->get_results("SELECT * FROM {$this->ordersTable} Order by 1 desc");

        $metas = $this->getAllMetaFromOrder($results);

        return $this->mapToOrderDTOArray($results, $metas);
    }

    /**
     * Private mapper function to map a single order object to an OrderDTO.
     *
     * @param \stdClass|null $orderObj The database order object.
     * @param ?OrderMetaDTO $orderObjMeta represents an basic order meta attributes.
     * 
     * @return OrderDTO|null The mapped OrderDTO or null if the object is null.
     */
    private function mapToOrderDTO($orderObj, $orderObjMeta = null): ?OrderDTO
    {
        if (!$orderObj) {
            return null;
        }
        return new OrderDTO(
            ID: (int) $orderObj->id,
            billing_email: (string) $orderObj->billing_email,
            currency: (string) $orderObj->currency,
            totalAmount: floatval($orderObj->total_amount),
            status: (string) $orderObj->status,
            items: [],
            payment_method: (string) $orderObj->payment_method,
            payment_method_title: (string) $orderObj->payment_method_title,
            billing_data:  $orderObjMeta ?? null
        );
    }

    /**
     * Private helper to map an array of order objects to an array of OrderDTOs.
     *
     * @param array $orderObjs The database order objects.
     * @param array $metas The meta data for each order in a dict array.
     * 
     * @return OrderDTO[] An array of OrderDTOs.
     */
    private function mapToOrderDTOArray(array $orderObjs, array $metas = []): array
    {
        $ListOrOrders = array();
        foreach($orderObjs as $order){
            if(isset($metas[$order->id])){
                $ListOrOrders[] = $this->mapToOrderDTO($order, new OrderMetaDTO($metas[$order->id][0]->meta_value));
            }else{
                $ListOrOrders[] = $this->mapToOrderDTO($order );
            }
        }

        return $ListOrOrders;
    }

    /**
     * TODO: FIX THE CODE BELOW FOR GENERIC GET AND MOVE TO OrderMETADAO
     * Private helper to map an array of order objects to an array of OrderMetaDTO.
     *
     * @param array $orderObjs The database order objects.
     * 
     * @return OrderMetaDTO Object mapped from array of attributes.
     */
    private function mapToOrderMetaDTO($orderMetaObj)
    {
        $shippingAddressIndex = null;
        foreach ($orderMetaObj as $row) {
            if ($row->meta_key === '_shipping_address_index') {
                $shippingAddressIndex = $row->meta_value;
                break;
            }
        }
        return new OrderMetaDTO($shippingAddressIndex);
    }

    private function getAllMetaFromOrder($orderArray){
        $meta = array();
        foreach($orderArray as $order){
            $meta[$order->id] = $this->db_instance->get_results($this->db_instance->prepare("SELECT * FROM {$this->ordersMetaTable} where order_id = %d AND meta_key = %s", $order->id, '_shipping_address_index'));
        }
        return $meta;
    }
}
