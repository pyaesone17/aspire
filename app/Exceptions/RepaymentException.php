<?php

namespace App\Exceptions;

use Exception;

class RepaymentException extends Exception
{
    /**
     * Render the exception.
     */
    public function render($request)
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
            'errors' => [
                $this->getMessage(),
            ],
        ]);
    }
}
