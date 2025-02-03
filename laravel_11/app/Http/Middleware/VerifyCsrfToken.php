<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * CSRF doğrulaması yapılmayacak URI'ler.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/*'  // API rotalarını CSRF kontrolünden muaf tut
    ];
} 