<?php
/**
 *
 */

namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class MatchesPasswordException extends ValidationException
{
    // customize the validation message
    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Password dose not match.',
        ]
    ];
}