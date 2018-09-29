<?php

namespace App\View;


class HtmlDisplay
{

	protected static $templatePath = __DIR__ . '/mazeDisplay.php';

	/**
	 * Process displaying.
	 *
	 * @param array $maze
	 * @param array $playerPath
	 */
	public static function view(array $maze, array $playerPath)
	{
		require_once static::$templatePath;

		return;
	}

}
