<?php namespace App\Modules;

class Footer
{
	/**
	 *  Display Footer Content
	 */
	function getContent()
	{
		$query = new BlogQueries;
		require_once(SRC_BASE_PATH.'template/footer.php');
	}
}