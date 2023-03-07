<?php

namespace My\Plugin\Fields;

use My\Plugin\Help;

class Select extends Base
{
    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct('select');
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
        $atts = array_intersect_key($field, array_flip(['id', 'name']));

        echo '<select' . Help::escAttr($atts) . '>';

        foreach ($field['choices'] as $option_value => $option_label) {
            printf(
                '<option value="%1$s"%2$s>%3$s</option>',
                esc_attr($option_value),
                selected($field['value'], $option_value, false),
                esc_html($option_label)
            );
        }

        echo '</select>';
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
        return $value;
    }
}
