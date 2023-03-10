<?php

namespace My\Plugin\Fields;

use My\Plugin\Help;

class Radios extends Base
{
    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct('radios');
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
        echo '<ul>';

        foreach ($field['choices'] as $option_value => $option_label) {
            printf(
                '<li><label><input type="radio" name="%1$s" value="%2$s"%3$s>%4$s</label></li>',
                esc_attr($field['name']),
                esc_attr($option_value),
                checked(in_array($option_value, $field['value']), true, false),
                esc_html($option_label)
            );
        }

        echo '</ul>';
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
        return is_array($value) ? $value : [];
    }
}
