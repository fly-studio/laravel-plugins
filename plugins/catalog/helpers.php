<?php

if (! function_exists('catalog_search'))
{
	function catalog_search($key = null, $subKeys = null)
	{
		return \Plugins\Catalog\App\Catalog::searchCatalog($key, $subKeys);
	}
}
