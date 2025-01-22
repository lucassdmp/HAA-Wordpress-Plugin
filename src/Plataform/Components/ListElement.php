<?php

namespace HAAPlugin\Plataform\Components;

use HAAPlugin\Plataform\Components\ListRow;
/**
 * Class ListElement
 * A generic list element class for rendering a table-like structure with headers and rows.
 */
class ListElement
{
    /**
     * The headers for the list.
     *
     * @var array
     */
    private $headers;

    /**
     * The rows for the list.
     *
     * @var ListRow[]
     */
    private $rows;

    /**
     * Additional attributes for the list element.
     *
     * @var array
     */
    private $attributes;

    /**
     * Constructor to initialize list properties.
     *
     * @param array $headers An array of header strings.
     * @param ListRow[] $rows An array of ListRow objects.
     * @param array $attributes Optional additional attributes for the <table> element.
     */
    public function __construct(array $headers, array $rows, array $attributes = [])
    {
        $this->headers = $headers;
        $this->rows = $rows;
        $this->attributes = $attributes;
    }

      /**
     * Get the headers of the list.
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Get the rows of the list.
     *
     * @return ListRow[]
     */
    public function getRows(): array
    {
        return $this->rows;
    }

    /**
     * Get the attributes of the list.
     *
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Generate the HTML for the list.
     *
     * @return string The HTML string for the list.
     */
    public function render(): string
    {
        $attributesString = $this->buildAttributes();
        $html = "<table$attributesString>";

        // Render the headers
        $html .= $this->renderHeaders();

        // Render the rows
        $html .= $this->renderRows();

        $html .= '</table>';
        return $html;
    }

    /**
     * Build additional attributes as a string for the <table> element.
     *
     * @return string
     */
    private function buildAttributes(): string
    {
        $attributesString = '';
        foreach ($this->attributes as $key => $value) {
            $attributesString .= sprintf(' %s="%s"', htmlspecialchars($key), htmlspecialchars($value));
        }
        return $attributesString;
    }

    /**
     * Render the headers row.
     *
     * @return string
     */
    private function renderHeaders(): string
    {
        $html = '<thead><tr>';
        foreach ($this->headers as $header) {
            $html .= sprintf('<th>%s</th>', htmlspecialchars($header));
        }
        $html .= '</tr></thead>';
        return $html;
    }

    /**
     * Render the data rows.
     *
     * @return string
     */
    private function renderRows(): string
    {
        $html = '<tbody>';
        foreach ($this->rows as $row) {
            $html .= $this->renderRow($row);
        }
        $html .= '</tbody>';
        return $html;
    }

    /**
     * Render a single row.
     *
     * @param ListRow $row The row to render.
     * @return string
     */
    private function renderRow(ListRow $row): string
    {
        $attributesString = $this->buildRowAttributes($row->getAttributes());
        $html = "<tr$attributesString>";

        // Loop through row data in the same order as headers
        foreach ($this->headers as $index => $header) {
            $value = $row->getData()[$index] ?? ''; // Use index-based access
            $html .= sprintf('<td>%s</td>', htmlspecialchars($value));
        }

        $html .= '</tr>';
        return $html;
    }


    /**
     * Build attributes for a <tr> element as a string.
     *
     * @param array $attributes
     * @return string
     */
    private function buildRowAttributes(array $attributes): string
    {
        $attributesString = '';
        foreach ($attributes as $key => $value) {
            $attributesString .= sprintf(' %s="%s"', htmlspecialchars($key), htmlspecialchars($value));
        }
        return $attributesString;
    }


}
