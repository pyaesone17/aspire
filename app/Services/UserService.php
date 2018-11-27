<?php 

namespace App\Services;

use Illuminate\Contracts\Hashing\Hasher;
use App\Repository\Contracts\UserRepositoryContract;

class UserService
{
    public $hasher;
    
    public $userRepository;

    public function __construct(UserRepositoryContract $userRepository, Hasher $hasher)
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
