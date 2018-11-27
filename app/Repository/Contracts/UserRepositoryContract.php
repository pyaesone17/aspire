<?php 

namespace App\Repository\Contracts;

interface UserRepositoryContract
{
    public function find($id);

    public function create($name, $email, $password);
}
