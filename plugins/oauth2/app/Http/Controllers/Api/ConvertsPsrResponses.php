<?php

namespace Plugins\OAuth2\App\Http\Controllers\Api;

use Illuminate\Http\Response;
use Psr\Http\Message\ResponseInterface;
use Addons\Core\Http\Response\TextResponse;

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
            return new TextResponse(
                $body,
                $psrResponse->getStatusCode(),
                $psrResponse->getHeaders()
            );
        }

        $response = new TextResponse(
            '',
            $psrResponse->getStatusCode(),
            $psrResponse->getHeaders()
        );

        if (isset($data['error']))
        {
            $response->setResult('failure');
            $response->setMessage(['title' => $data['error'], 'content' => $data['message']]);
        }

        $response->setData(array_except($data, ['error', 'message']));

        return $response->setFormatter('json');
    }
}
