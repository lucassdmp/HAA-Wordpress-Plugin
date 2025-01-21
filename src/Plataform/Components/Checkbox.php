<?php

namespace HAAPlugin\Plataform\Components;

/**
 * Class Checkbox
 * 
 * Represents a reusable checkbox (HTML <input type="checkbox">) component.
 * Allows customization of name, checked status, and additional attributes.
 *
 * @package HAAPlugin\Plataform\Components
 */
class Checkbox
{
    /**
     * Name attribute for the checkbox input element.
     *
     * @var string
     */
    private $name;

    /**
     * Value attribute for the checkbox input element.
     *
     * @var string
     */
    private $value;

    /**
     * Indicates whether the checkbox is checked.
     *
     * @var bool
     */
    private $checked;

    /**
     * Additional attributes for the checkbox input element.
     * Example: ['id' => 'checkbox-id', 'class' => 'checkbox-class'].
     *
     * @var array
     */
    private $attributes;

    /**
     * Constructor to initialize checkbox properties.
     *
     * @param string $name The name attribute for the checkbox input element.
     * @param string $value The value attribute for the checkbox input element.
     * @param bool $checked Indicates if the checkbox is checked (default: false).
     * @param array $attributes Optional additional attributes for the checkbox input element.
     */
    public function __construct(string $name, string $value, bool $checked = false, array $attributes = [])
    {
        $this->name = $name;
        $this->value = $value;
        $this->checked = $checked;
        $this->attributes = $attributes;
    }

    /**
     * Generate the HTML for the checkbox input field.
     *
     * @return string The HTML string for the checkbox input field.
     */
    public function render(): string
    {
        $attributesString = $this->buildAttributes();
        $checkedAttribute = $this->checked ? ' checked' : '';
        return sprintf(
            '<input type="checkbox" name="%s" value="%s"%s%s>',
            htmlspecialchars($this->name),
            htmlspecialchars($this->value),
            $checkedAttribute,
            $attributesString
        );
    }

    /**
     * Build additional attributes as a string for the checkbox input element.
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
