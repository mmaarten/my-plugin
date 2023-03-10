<?php

namespace My\Plugin\Fields;

use My\Plugin\Help;

class Editor extends Base
{
    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct('editor');
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
        $atts['class'] = 'my-plugin-editor';

        echo '<textarea' . Help::escAttr($atts) . '>' . esc_textarea($field['value']) . '</textarea>';
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
