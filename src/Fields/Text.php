<?php

namespace My\Plugin\Fields;

use My\Plugin\Help;

class Text extends Base
{
    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct('text');
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
        $atts = array_intersect_key($field, array_flip(['id', 'name', 'value']));
        $atts['type']  = 'text';
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
        return sanitize_text_field($value);
    }
}
