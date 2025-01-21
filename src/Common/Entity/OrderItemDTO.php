<?php

namespace HAAPlugin\Common\Entity;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Data Transfer Object (DTO) for an Order Item.
 * 
 * This class represents a single item in an order, including details such as 
 * the item's ID, name, quantity, and price.
 */
class OrderItemDTO
{
    /**
     * The unique identifier for the order item.
     * 
     * @var int
     */
    public int $ID;

    /**
     * The name of the item in the order.
     * 
     * @var string
     */
    public string $name;

    /**
     * The quantity of the item ordered.
     * 
     * @var int
     */
    public int $quantity;

    /**
     * The price of a single unit of the item.
     * 
     * @var float
     */
    public float $price;

    /**
     * Constructor for the OrderItemDTO class.
     * 
     * @param int $itemId The unique identifier for the order item.
     * @param string $name The name of the item.
     * @param int $quantity The quantity of the item in the order.
     * @param float $price The price per unit of the item.
     */
    public function __construct(int $itemId, string $name, int $quantity, float $price)
    {
        $this->itemId = $itemId;
        $this->name = $name;
        $this->quantity = $quantity;
        $this->price = $price;
    }
}
