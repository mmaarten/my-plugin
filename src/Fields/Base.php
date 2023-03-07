<?php

namespace My\Plugin\Fields;

abstract class Base
{
    protected $id = '';

    /**
     * Construct
     *
     * @param string $id
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;

        add_action('my_plugin_render_field/type=' . $this->id, [$this, 'renderField']);
        add_filter('my_plugin_sanitize_field_value/type=' . $this->id, [$this, 'sanitizeFieldValue'], 10, 2);
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
