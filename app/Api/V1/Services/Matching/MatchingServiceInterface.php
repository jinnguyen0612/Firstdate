<?php

namespace App\Api\V1\Services\Matching;
use Illuminate\Http\Request;

interface MatchingServiceInterface 
{
    /**
     * Tạo mới
     * 
     * @var Illuminate\Http\Request $request
     * 
     * @return mixed
     */
    public function add(Request $request);
	
	/**
     * Xóa
     * 
     * @var Illuminate\Http\Request $request
     * 
     * @return mixed
     */
	public function delete(Request $request);
}