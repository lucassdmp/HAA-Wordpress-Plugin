<?php

namespace HAAPlugin\Plataform\Components;

/**
 * Class Dropdown
 * 
 * Represents a reusable dropdown (HTML <select>) component.
 * Allows customization of options, attributes, and selected value.
 *
 * @package HAAPlugin\Plataform\Components
 */
class Dropdown
{
    /**
     * Options for the dropdown.
     * Keys represent the values, and values represent the display labels.
     * 
     * @var array
     */
    private $options;

    /**
     * Name attribute for the <select> element.
     * 
     * @var string
     */
    private $name;

    /**
     * Selected value for the dropdown.
     * 
     * @var string|null
     */
    private $selected;

    /**
     * Additional attributes for the <select> element.
     * 
     * @var array
     */
    private $attributes;

    /**
     * Constructor to initialize dropdown properties.
     *
     * @param array $options Array of options in the format ['key' => 'label'].
     * @param string $name Name attribute for the <select> element.
     * @param string|null $selected Optional selected value.
     * @param array $attributes Optional additional attributes for the <select> element.
     */
    public function __construct(array $options, string $name, ?string $selected = null, array $attributes = [])
    {
        $this->options = $options;
        $this->name = $name;
        $this->selected = $selected;
        $this->attributes = $attributes;
    }

    /**
     * Generate the HTML for the dropdown.
     *
     * @return string The HTML string for the dropdown.
     */
    public function render(): string
    {
        $attributesString = $this->buildAttributes();
        $html = sprintf('<select name="%s"%s>', htmlspecialchars($this->name), $attributesString);

        foreach ($this->options as $key => $label) {
            $isSelected = ($key === $this->selected) ? ' selected' : '';
            $html .= sprintf(
                '<option value="%s"%s>%s</option>',
                htmlspecialchars($key),
                $isSelected,
                htmlspecialchars($label)
            );
        }

        $html .= '</select>';
        return $html;
    }

    /**
     * Build additional attributes as a string for the <select> element.
     *
     * @return string The string of HTML attributes.
     */
    private function buildAttributes(): string
    {
        $attributesString = '';
        foreach ($this->attributes as $key => $value) {
            $attributesString .= sprintf(' %s="%s"', htmlspecialchars($key), htmlspecialchars($value));
        }
        return $attributesString;
    }
}
