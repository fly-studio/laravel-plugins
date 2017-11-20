<?php

/*
 * This file is part of the overtrue/laravel-wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Plugins\Wechat\App\Events\Events;

use Overtrue\Socialite\User;
use Illuminate\Queue\SerializesModels;

class WeChatUserAuthorized
{
    use SerializesModels;

    public $app;
    public $user;
    public $isNewSession;

    /**
     * Create a new event instance.
     *
     * @param \Overtrue\Socialite\User $user
     * @param bool                     $isNewSession
     */
    public function __construct(OfficialAccount $app, User $user, $isNewSession = false)
    {
        $this->app = $app;
        $this->user = $user;
        $this->isNewSession = $isNewSession;
    }

    /**
     * Retrieve the authorized user.
     *
     * @return \Overtrue\Socialite\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Retrieve the authorized user.
     *
     * @return \Overtrue\Socialite\User
     */
    public function getApp()
    {
        return $this->app;
    }

    /**
     * Check the user session is first created.
     *
     * @return bool
     */
    public function isNewSession()
    {
        return $this->isNewSession;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
