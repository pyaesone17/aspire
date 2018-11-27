<?php

namespace App\Exceptions;

use Exception;

class LoanException extends Exception
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
