<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        'auth-login',

        // Users
        'users-save-batch',

        // Payments
        'payments-save',

        // Payment Details
        'paymentdetails-save'

    ];
}
