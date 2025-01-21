<?php

namespace HAAPlugin\Plataform\Components;

/**
 * Class ListRow
 * Represents a single row with data and attributes for customization.
 */
class ListRow
{
    /**
     * Data for the row.
     *
     * @var array
     */
    private $data;

    /**
     * Attributes for the row.
     *
     * @var array
     */
    private $attributes;

    /**
     * Constructor to initialize row properties.
     *
     * @param array $data The row's data.
     * @param array $attributes Optional attributes for the <tr> element.
     */
    public function __construct(array $data, array $attributes = [])
    {
        $this->data = $data;
        $this->attributes = $attributes;
    }

    /**
     * Get the row data.
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Get the row attributes.
     *
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
