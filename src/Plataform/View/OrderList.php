<?php

namespace HAAPlugin\Plataform\View;

use HAAPlugin\Plataform\Business\OrderBUS;
use HAAPlugin\Common\Entity\OrderDTO;
use HAAPlugin\Plataform\Components\ListElement;
use HAAPlugin\Plataform\Components\ListRow;

class OrderList
{
    public static $instance;
    private static $order_list_table_id = "haa-orderlist-table";
    private $headers;
    private OrderBUS $OrderBus;

    public array $orders;

    private function __construct()
    {
        $this->headers = ["ID", "Billing Address", "Customer Name", "Currency", "Amount", "Payment Method", "Country"];
        $this->OrderBus = new OrderBUS();
    }

    /**
     * Get the singleton instance of OrderList.
     *
     * @return OrderList
     */
    public static function get_instance(): OrderList
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function GetOrderList()
    {
        $this->orders = $this->OrderBus->getAllOrders();

        $attributes = $this->buildTableAttributes();

        $rows = $this->mapOrdersToListArray($this->orders, $this->headers);

        $list = new ListElement($this->headers, $rows, $attributes);

        return $list;
    }

    /**
     * Build attributes for the table element.
     *
     * @return array
     */
    private function buildTableAttributes(): array
    {
        return [
            'id' => self::$order_list_table_id,
            'class' => 'table table-striped table-hover table-responsive',
            'data-role' => 'order-list', 
        ];
    }

    /**
     * Receives an array of orders and returns a mapped instance of ListRow array.
     *
     * @param OrderDTO[] $all_orders All orders from the site without any filters
     * @param array $headers Table Header for mapping
     *
     * @return ListRow[]
     */
    public function mapOrdersToListArray($all_orders, $headers)
    {
        $return_array = [];

        foreach ($all_orders as $order) {
            $mappedOrder = [];
            foreach ($headers as $header) {
                switch ($header) {
                    case "ID":
                        $mappedOrder[] = $order->ID;
                        break;
                    case "Billing Address":
                        $mappedOrder[] = $order->Customer ?? 'N/A';
                        break;
                    case "Customer Name":
                        $mappedOrder[] = $order->billing_data->customer_name;
                        break;
                    case "Country":
                        $mappedOrder[] = $order->billing_data->customer_billing_country;
                        break;
                    case "Currency":
                        $mappedOrder[] = $order->currency;
                        break;
                    case "Amount":
                        $mappedOrder[] = $order->totalAmount;
                        break;
                    case "Payment Method":
                        $mappedOrder[] = $order->payment_method_title;
                        break;
                    default:
                        $mappedOrder[] = 'N/A';
                        break;
                }
            }

            $return_array[$order->ID] = new ListRow($mappedOrder, [], $order);
        }

        return $return_array;
    }
}
