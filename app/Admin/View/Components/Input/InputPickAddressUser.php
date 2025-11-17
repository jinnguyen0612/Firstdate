<?php

namespace App\Admin\View\Components\Input;

class InputPickAddressUser extends Input
{

    public $value;

    public $label;

    public $name;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $name = 'address', $value = null, $required = false)
    {
        //
        parent::__construct('text', $required);
        $this->value = $value;
        $this->label = $label;
        $this->name = $name;
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.input.pick-address-user');
    }
}
