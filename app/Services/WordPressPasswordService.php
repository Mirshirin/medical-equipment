<?php

namespace App\Services;

class WordPressPasswordService
{
    public static function check($password, $hashedPassword)
{
    // If the hash format is WordPress's, we use `crypt`
    if (substr($hashedPassword, 0, 3) === '$P$') {
        return crypt($password, $hashedPassword) === $hashedPassword;
    }

    return false; // Otherwise, you can return false or implement another logic
}

}
