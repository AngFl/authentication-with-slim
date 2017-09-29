<?php
/**
 *
 */

namespace App\Validation\Rules;

use App\Models\User;
use Respect\Validation\Rules\AbstractRule;

class EmailAvailable extends AbstractRule
{
    public function validate($inputEmailData)
    {
        // email is already exist
        return (
            (new User)
                ->where('email', $inputEmailData)
                ->count()
            ) === 0;
    }
}