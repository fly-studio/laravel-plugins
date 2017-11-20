<?php

use Plugins\Wechat\App\Events\WeChatUserAuthorized;

$eventer->listen(WeChatUserAuthorized::class, 'Plugins\Wechat\App\Listeners\OAuth2User');
