<?php
/**
 * This file is part of Lyra payment form API.
 * Copyright (C) Lyra Network.
 * See COPYING.txt for license details.
 */
namespace Lyranetwork;

/**
 * Class representing a form field to send to the payment platform.
 */
class Field
{

    /**
     * Field name, matches the HTML input name attribute.
     *
     * @var string
     */
    private $name;

    /**
     * Field label in English, may be used by translation systems.
     *
     * @var string
     */
    private $label;

    /**
     * PCRE regular expression the field value must match.
     *
     * @var string
     */
    private $regex;

    /**
     * Whether the form requires the field to be set (even as an empty string).
     *
     * @var boolean
     */
    private $required;

    /**
     * Field value. Null or string.
     *
     * @var string
     */
    private $value = null;

    /**
     * Constructor.
     *
     * @param string $name
     * @param string $label
     * @param string $regex
     * @param boolean $required
     */
    public function __construct($name, $label, $regex, $required = false)
    {
        $this->name = $name;
        $this->label = $label;
        $this->regex = $regex;
        $this->required = $required;
    }

    /**
     * Checks the current value.
     *
     * @return boolean
     */
    public function isValid()
    {
        if (! $this->isFilled() && $this->required) {
            return false;
        }

        if ($this->isFilled() && ! preg_match($this->regex, $this->value)) {
            return false;
        }

        return true;
    }

    /**
     * Setter for value.
     *
     * @param mixed $value
     * @return boolean
     */
    public function setValue($value)
    {
        $value = ($value === null) ? null : (string) $value;
        // we save value even if invalid but we return "false" as warning
        $this->value = $value;

        return $this->isValid();
    }

    /**
     * Return the current value of the field.
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Is the field required in the payment request ?
     *
     * @return boolean
     */
    public function isRequired()
    {
        return $this->required;
    }

    /**
     * Return the name (HTML attribute) of the field.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Return the english human-readable name of the field.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Has a value been set ?
     *
     * @return boolean
     */
    public function isFilled()
    {
        return $this->value !== null;
    }
}
