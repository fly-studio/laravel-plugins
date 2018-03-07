<?php

namespace Plugins\OAuth2\App\Http\Controllers\Api;

use Laravel\Passport\Passport;
use App\Http\Controllers\Controller;

class ScopeController extends Controller
{
    /**
     * Get all of the available scopes for the application.
     *
     * @return \Illuminate\Support\Collection
     */
    public function all()
    {
        return Passport::scopes();
    }
}
