<?php 

namespace App\Repository;
use App\User;

class UserRepository
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
