<?php namespace App\Modules;

/**
*  MenuBar contents
*/
class MenuBar
{
	function getContent()
	{
		require_once(SRC_BASE_PATH.'template/menu-bar.php');
	}
}