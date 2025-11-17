<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Select2 extends Component
{
    public $name;
    public $placeholder;
    public $required;
    public $class;
    public $dataAjaxUrl;
    public $dataAjaxData;

    public function __construct(
        $name,
        $placeholder = null,
        $required = false,
        $class = '',
        $dataAjaxUrl = null,
        $dataAjaxData = null
    ) {
        $this->name = $name;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->class = $class;
        $this->dataAjaxUrl = $dataAjaxUrl;
        $this->dataAjaxData = $dataAjaxData;
    }

    public function render()
    {
        return view('components.select2');
    }
}
