<?php

namespace My\Plugin\Fields;

use My\Plugin\Help;

class Number extends Base
{
    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct('number');
    }

    /**
     * Render field
     *
     * @param array $field
     *
     * @return void
     */
    public function renderField($field)
    {
        $atts = array_intersect_key($field, array_flip(['id', 'name', 'value', 'min', 'max', 'step']));
        $atts['type']  = 'number';
        $atts['class'] = 'regular-text';

        echo '<input' . Help::escAttr($atts) . '>';
    }

    /**
     * Sanitize field
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public function sanitizeFieldValue($value, $field)
    {
        if ($value === '' || $value === null || $value === false ) {
            return $value;
        }

        return intval($value);
    }
}
