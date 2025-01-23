<?php

namespace HAAPlugin\Common\Entity;

class OrderMetaDTO
{
    /**
     * The full name of the customer.
     *
     * @var string
     */
    public string $customer_name;

    /**
     * The billing address of the customer.
     *
     * @var string
     */
    public string $customer_billing_address;

    /**
     * The city in the customer's billing address.
     *
     * @var string
     */
    public string $customer_billing_city;

    /**
     * The state in the customer's billing address.
     *
     * @var string
     */
    public string $customer_billing_state;

    /**
     * The postal code of the customer's billing address.
     *
     * @var string
     */
    public string $customer_postal_code;

    /**
     * The country in the customer's billing address.
     *
     * @var string
     */
    public string $customer_billing_country;

    public function __construct(string $billing_data)
    {
        $split_billing_data = explode("  ", $billing_data);
        $this->customer_name = $split_billing_data[0];
        $this->customer_billing_address = $split_billing_data[1];
        $address = explode(" ", $split_billing_data[2]);
        $this->customer_billing_city = $address[0];
        $this->customer_billing_state = $address[1];
        $this->customer_postal_code = $address[2];
        $this->customer_billing_country = $address[3];
    }
}