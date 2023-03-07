<?php

namespace My\Plugin;

class Help
{
    /**
     * Escape attributes
     *
     * @param array $attributes
     *
     * @return string
     */
    public static function escAttr($attributes)
    {
        $return = '';

        foreach ($attributes as $name => $value) {
            $return .= sprintf(' %1$s="%2$s"', esc_attr($name), esc_attr($value));
        }

        return $return;
    }
}

