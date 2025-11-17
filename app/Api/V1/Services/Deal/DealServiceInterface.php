<?php

namespace App\Api\V1\Services\Deal;
use Illuminate\Http\Request;

interface DealServiceInterface 
{

    public function chooseDistrictOptions(Request $request);
    public function chooseDistrictFromOptions($id);
    
    public function chooseDateOptions(Request $request);
    public function chooseDateFromOptions($id);
    
    public function choosePartnerOptions(Request $request);
    public function choosePartnerFromOptions($id);
    
    public function cancel(Request $request);
	
}