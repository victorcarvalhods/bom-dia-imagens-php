<?php

use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\UserAlreadyExistsException;
use App\Models\User;
use App\services\UserClass;
use Illuminate\Support\Facades\Hash;

class UserService
{

    private function existsUserWithSameEmail(String $email)
    {
        return User::where("email", $email)->exists();
    }

    public function createUser(UserClass $user)
    {
        if (!$this->existsUserWithSameEmail($user->getEmail())) {
            $createdUser = User::create([
                "email" => $user->getEmail(),
                "password" => Hash::make($user->getPassword()),
            ]);
            return $createdUser;
        }
        throw new UserAlreadyExistsException();
    }

    public function authenticate(UserClass $user){
        $bdUser = User::getUserByEmail($user->getEmail());

        if (!$bdUser) {
            throw new InvalidCredentialsException();
        }

        $doesPasswordsMatches = Hash::check($user->getPassword(), $bdUser->password);

        if (!$doesPasswordsMatches) {
            throw new InvalidCredentialsException();
        }

        return $bdUser;
    }


}
