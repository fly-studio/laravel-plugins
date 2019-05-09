<?php

namespace Plugins\Wechat\App\Http\Controllers;

use Event;
use EasyWeChat\OpenPlatform\Application;
use EasyWeChat\OpenPlatform\Server\Guard;
use Overtrue\LaravelWeChat\Events\OpenPlatform as Events;

class OpenPlatformController
{
    /**
     * Register for open platform.
     *
     * @param \EasyWeChat\OpenPlatform\Application $application
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Application $application)
    {
        $server = $application->server;

        $server->on(Guard::EVENT_AUTHORIZED, function ($payload) {
            Event::dispatch(new Events\Authorized($payload));
        });
        $server->on(Guard::EVENT_UNAUTHORIZED, function ($payload) {
            Event::dispatch(new Events\Unauthorized($payload));
        });
        $server->on(Guard::EVENT_UPDATE_AUTHORIZED, function ($payload) {
            Event::dispatch(new Events\UpdateAuthorized($payload));
        });

        return $server->serve();
    }
}
