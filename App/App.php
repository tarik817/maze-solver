<?php

namespace App;

use App\View\HtmlDisplay;

class App
{

	/**
	 * @var array $settings application settings.
	 */
	protected $settings;

	/**
	 * App constructor.
	 *
	 * @param array $settings
	 */
	public function __construct(array $settings)
	{
		$this->settings = $settings;
	}

	/**
	 * Run application.
	 */
	public function run()
	{
		$playerPath = [];
		$maze = (new SurfaceContext(new $this->settings['surface']($this->settings['surface_file'])))->executeStrategy();

		$startPoints = $this->getStartingPointsFromRequest();

		if ($startPoints) {
			$playerPath = (new PlayerContext(new $this->settings['player']($maze, $startPoints)))->executeStrategy();
		}

		HtmlDisplay::view($maze, $playerPath);
	}

	/**
	 * Get triggered maze coordinates.
	 *    If no coordinates provided - return false.
	 *
	 * @return array|bool
	 */
	public function getStartingPointsFromRequest()
	{
		if (isset($_POST['x']) and isset($_POST['y'])) {
			return ['x' => $_POST['x'], 'y' => $_POST['y']];
		}

		return false;
	}

}
