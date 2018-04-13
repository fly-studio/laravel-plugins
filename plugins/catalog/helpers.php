<?php

if (! function_exists('catalogs_get'))
{
	function catalogs_get($idOrName = null, $subKeys = null)
	{
		if (is_numeric($idOrName))
			return \Plugins\Catalog\App\Catalog::getCatalogsById($idOrName, $subKeys);
		else
			return \Plugins\Catalog\App\Catalog::getCatalogsByName($idOrName, $subKeys);
	}
}

if (! function_exists('catalogs_get_by_name'))
{
	function catalogs_get_by_name($name = null, $subKeys = null)
	{
		return \Plugins\Catalog\App\Catalog::getCatalogsByName($name, $subKeys);
	}
}

if (! function_exists('catalogs_get_by_id'))
{
	function catalogs_get_by_id($id = null, $subKeys = null)
	{
		return \Plugins\Catalog\App\Catalog::getCatalogsById($id, $subKeys);
	}
}
