<?php

namespace App\Exceptions;

use Exception;

class BookingUnavailableException extends Exception
{
    public function __construct(string $message = 'The selected date slot is fully booked.')
    {
        parent::__construct($message);
    }
}
