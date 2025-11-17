<?php

namespace App\Api\V1\Services\Auth;

use Illuminate\Http\Request;

interface AuthServiceInterface
{

    public function store(Request $request);
    public function draftUpdate(Request $request);
    public function update(Request $request);

    public function delete($id);

    public function updateTokenPassword(Request $request);
    public function generateRouteGetPassword($view);
    public function getInstance();
    public function topUpWallet(Request $request);
    public function withdraw(Request $request);
}
