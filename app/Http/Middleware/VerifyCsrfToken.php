<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        "https://aiwriter.so-sighty.fr/*",
        "http://aiwriter.so-sighty.fr/*",
        "http://aiwriter.so-sighty.fr/api/*",
        "http://localhost:3000/*",
    ];
}
