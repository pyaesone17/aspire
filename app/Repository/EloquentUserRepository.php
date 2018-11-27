<?php 

namespace App\Repository;

use App\User;
use App\Repository\Contracts\UserRepositoryContract;

class EloquentUserRepository implements UserRepositoryContract
{
    public $user;

    public function __construct(User $user) 
    {
        $this->user = $user;
    }

    public function find($id)
    {
        return $this->user->newQuery()->find($id);
    }

    public function create($name, $email, $password)
    {
        return $this->user->create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);
    }
}
