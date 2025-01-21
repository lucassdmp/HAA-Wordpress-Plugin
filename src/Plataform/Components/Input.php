<?php

namespace HAAPlugin\Plataform\Components;

/**
 * Class InputField
 * 
 * Represents a reusable input field (HTML <input>) component.
 * Allows customization of type, name, value, and additional attributes.
 *
 * @package HAAPlugin\Plataform\Components
 */
class Input
{
    /**
     * Type of the input field.
     * Common values: 'text', 'email', 'password', 'number', etc.
     *
     * @var string
     */
    private $type;

    /**
     * Name attribute for the <input> element.
     *
     * @var string
     */
    private $name;

    /**
     * Value attribute for the <input> element.
     *
     * @var string|null
     */
    private $value;

    /**
     * Additional attributes for the <input> element.
     * Example: ['id' => 'input-id', 'class' => 'input-class'].
     *
     * @var array
     */
    private $attributes;

    /**
     * Constructor to initialize input field properties.
     *
     * @param string $type The type of the input field (e.g., 'text', 'email').
     * @param string $name The name attribute for the <input> element.
     * @param string|null $value The value attribute for the <input> element (optional).
     * @param array $attributes Optional additional attributes for the <input> element.
     */
    public function __construct(string $type, string $name, ?string $value = null, array $attributes = [])
    {
        $this->type = $type;
        $this->name = $name;
        $this->value = $value;
        $this->attributes = $attributes;
    }

    /**
     * Generate the HTML for the input field.
     *
     * @return string The HTML string for the input field.
     */
    public function render(): string
    {
        $attributesString = $this->buildAttributes();
        return sprintf(
            '<input type="%s" name="%s" value="%s"%s>',
            htmlspecialchars($this->type),
            htmlspecialchars($this->name),
            htmlspecialchars($this->value ?? ''),
            $attributesString
        );
    }

    /**
     * Build additional attributes as a string for the <input> element.
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
