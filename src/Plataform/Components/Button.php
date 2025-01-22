<?php

namespace HAAPlugin\Plataform\Components;

/**
 * Class Button
 * 
 * Represents a reusable button (HTML <button>) component.
 * Allows customization of label, type, and additional attributes.
 *
 * @package HAAPlugin\Plataform\Components
 */
class Button
{
    /**
     * Label for the button.
     * Represents the text or HTML content of the button.
     *
     * @var string
     */
    protected $label;

    /**
     * Type attribute for the <button> element.
     * Common values: 'button', 'submit', 'reset'.
     *
     * @var string
     */
    protected $type;

    /**
     * Additional attributes for the <button> element.
     * Example: ['id' => 'btn-id', 'class' => 'btn-primary'].
     *
     * @var array
     */
    protected $attributes;

    /**
     * Constructor to initialize button properties.
     *
     * @param string $label The text or HTML content of the button.
     * @param string $type The type of the button (default: 'button').
     * @param array $attributes Optional additional attributes for the <button> element.
     */
    public function __construct(string $label, string $type = 'button', array $attributes = [])
    {
        $this->label = $label;
        $this->type = $type;
        $this->attributes = $attributes;
    }

    /**
     * Generate the HTML for the button.
     *
     * @return string The HTML string for the button.
     */
    public function render(): string
    {
        $attributesString = $this->buildAttributes();
        return sprintf(
            '<button type="%s"%s>%s</button>',
            htmlspecialchars($this->type),
            $attributesString,
            htmlspecialchars($this->label)
        );
    }

    /**
     * Build additional attributes as a string for the <button> element.
     *
     * @return string The string of HTML attributes.
     */
    protected function buildAttributes(): string
    {
        $attributesString = '';
        foreach ($this->attributes as $key => $value) {
            $attributesString .= sprintf(' %s="%s"', htmlspecialchars($key), htmlspecialchars($value));
        }
        return $attributesString;
    }
}
