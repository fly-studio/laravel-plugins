<?php

namespace Plugins\OAuth2\App\Http\Controllers\Api;

use Illuminate\Support\Arr;
use Illuminate\Http\Response;
use Psr\Http\Message\ResponseInterface;
use Addons\Core\Http\Output\ResponseFactory;

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
            return app(ResponseFactory::class)
                ->api($body)
                ->code($psrResponse->getStatusCode()),
                ->withHeaders($psrResponse->getHeaders())
                ;
        }

        $response = null;

        if (isset($data['error']))
        {
            $response = app(ResponseFactory::class)
                ->error()
                ->code($psrResponse->getStatusCode)
                ->withHeaders($psrResponse->getHeaders())
                ->message([$data['error'], isset($data['hint']) ? $data['hint'] : $data['message'])
                ;
        }
        else
        {
            $response = napp(ResponseFactory::class)
                ->api(null)
                ->code($psrResponse->getStatusCode()),
                ->withHeaders($psrResponse->getHeaders())
                ;
        }

        $response->data(Arr::except($data, ['error', 'message', 'hint']));

        return $response->of('json');
    }
}
