<?php

namespace App\Services\Interfaces;

interface RoleInterface
{
    public function getAllRoles();
    public function getTotalCustomers();
    public function getTotalCashiers();
    public function updateRole($role, $data);
}
