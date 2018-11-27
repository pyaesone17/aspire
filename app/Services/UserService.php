<?php 

namespace App\Services;

use App\Repository\UserRepository;
use Illuminate\Contracts\Hashing\Hasher;

class UserService
{
    public $hasher;
    
    public $userRepository;

    public function __construct(UserRepository $userRepository, Hasher $hasher)
    {
        $this->userRepository = $userRepository;
        $this->hasher = $hasher;
    }

    public function registerUser($name, $email, $password)
    {
        $password = $this->hasher->make($password);
        $user = $this->userRepository->create($name, $email, $password);

        return $user;
    }
}
