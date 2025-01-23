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

    public object $origin;

    /**
     * Constructor to initialize row properties.
     *
     * @param array $data The row's data.
     * @param array $attributes Optional attributes for the <tr> element.
     */
    public function __construct(array $data, array $attributes = [], object $entity)
    {
        $this->data = $data;
        $this->attributes = $attributes;
        $this->origin = $entity;
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
