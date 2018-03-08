<?php

namespace Plugins\OAuth2\App\Http\Controllers\Api;

use Illuminate\Http\Response;
use Psr\Http\Message\ResponseInterface;
use Addons\Core\Http\Response\TextResponse;
use Addons\Core\Http\Response\ApiResponse;

trait ConvertsPsrResponses
{
    /**
     * Convert a PSR7 response to a Illuminate Response.
     *
     * @param \Psr\Http\Message\ResponseInterface $psrResponse
     * @return \Illuminate\Http\Response
     */
    public function convertResponse($psrResponse)
    {
        $body = strval($psrResponse->getBody());
        $data = json_decode($body, true);

        if (empty($data))
        {
            return new ApiResponse(
                $body,
                $psrResponse->getStatusCode(),
                $psrResponse->getHeaders()
            );
        }
        $response = null;
        if (isset($data['error']))
        {
            $response = new TextResponse(
                null,
                $psrResponse->getStatusCode(),
                $psrResponse->getHeaders()
            );

            $response->setResult('failure')->setMessage(['title' => $data['error'], 'content' => isset($data['hint']) ? $data['hint'] : $data['message']]);
        } else {
            $response = new ApiResponse(
                null,
                $psrResponse->getStatusCode(),
                $psrResponse->getHeaders()
            );
        }

        $response->setData(array_except($data, ['error', 'message', 'hint']));

        return $response->setFormatter('json');
    }
}
