<?php

$enable_drivers = config('socialite.enable_drivers');
foreach($enable_drivers as $driver)
{
	$classname = studly_case($driver);
	$eventer->listen(\SocialiteProviders\Manager\SocialiteWasCalled::class, 'SocialiteProviders\\' . config('socialite.drivers.'.$driver.'.namespace',$classname) . '\\'. config('socialite.drivers.'.$driver.'.class_name', $classname) .'ExtendSocialite@handle');
}
