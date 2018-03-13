<?php

namespace Plugins\OAuth2\App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use Laravel\Passport\Bridge\User;
use App\Http\Controllers\Controller;

trait RetrievesAuthRequestFromSession
{
    /**
     * Get the authorization request from the session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \League\OAuth2\Server\RequestTypes\AuthorizationRequest
     * @throws \Exception
     */
    protected function getAuthRequestFromSession(Request $request)
    {
        return tap($request->session()->get('authRequest'), function ($authRequest) use ($request) {
            if (! $authRequest) {
                throw new Exception('Authorization request was not present in the session.');
            }

            $authRequest->setUser(new User($request->user()->getKey()));

            $authRequest->setRedirectUri($request->input('redirect_uri'));

            $authRequest->setAuthorizationApproved(true);

        });
    }
}
