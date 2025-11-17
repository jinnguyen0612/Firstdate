<?php

namespace App\Admin\Traits;

use App\Enums\Role\Role;

trait Roles
{
    public function getRoleUser(): string
    {
        return Role::User->value;
    }
    
    public function getRolePartner(): string
    {
        return Role::Partner->value;
    }

    public function getRoleStudent(): string
    {
        return Role::Student->value;
    }
    public function getRoleTeacher(): string
    {
        return Role::Teacher->value;
    }


    public function getRoleSupperAdmin(): string
    {
        return Role::SupperAdmin->value;
    }

    public function getRoleSubAdmin(): string
    {
        return Role::SubAdmin->value;
    }

    public function getRoleDriver(): string
    {
        return Role::Driver->value;
    }

    public function getRoleHotel(): string
    {
        return Role::Hotel->value;
    }

    public function getRoleStore(): string
    {
        return Role::Store->value;
    }

    public function getRoleRestaurant(): string
    {
        return Role::Restaurant->value;
    }

    public function getRoleVehicleOwner(): string
    {
        return Role::VehicleOwner->value;
    }
}
