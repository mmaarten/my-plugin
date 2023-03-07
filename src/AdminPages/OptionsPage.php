<?php

namespace My\Plugin\AdminPages;

class OptionsPage extends Base
{
    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct('test', 'Test');

        $this->addSection('default', '', null);

        $this->addField(
            [
                'name'  => 'textfield',
                'title' => 'Textfield',
                'type'  => 'text',
            ]
        );

        $this->addField(
            [
                'name'  => 'textarea',
                'title' => 'Textarea',
                'type'  => 'textarea',
                'rows'  => 8,
            ]
        );

        $this->addField(
            [
                'name'  => 'number',
                'title' => 'Number',
                'type'  => 'number',
                'description' => 'Description about this field.'
            ]
        );

        $this->addField(
            [
                'name'  => 'select',
                'title' => 'Select',
                'type'  => 'select',
                'choices' => [
                    'option_1' => 'Option 1',
                    'option_2' => 'Option 2',
                    'option_3' => 'Option 3',
                ],
            ]
        );

        $this->addField(
            [
                'name'  => 'checkboxes',
                'title' => 'Checkboxes',
                'type'  => 'checkboxes',
                'choices' => [
                    'option_1' => 'Option 1',
                    'option_2' => 'Option 2',
                    'option_3' => 'Option 3',
                ],
            ]
        );
    }
}
