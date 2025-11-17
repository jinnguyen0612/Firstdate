<?php

namespace App\View\Partner\Components;

use Illuminate\View\Component;

class CardDeal extends Component
{
    public $code;
    public $status;
    public $from;
    public $to;
    public $time;
    public $date;
    public $userMale;
    public $userFemale;
    public $dealId;
    public $bookingId;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        ?string $code = '00000000',
        ?string $status = 'pending',
        ?string $from = null,
        ?string $to = null,
        ?string $time = null,
        ?string $date = null,
        ?string $userMale = null,
        ?string $userFemale = null,
        ?int $dealId = null,
        ?int $bookingId = null
    ) {
        //
        $this->code = $code;
        $this->status = $status;
        $this->from = $from;
        $this->to = $to;
        $this->time = $time;
        $this->date = $date;
        $this->userMale = $userMale;
        $this->userFemale = $userFemale;
        $this->dealId = $dealId;
        $this->bookingId = $bookingId;
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('partner.components.card-deal');
    }
}
