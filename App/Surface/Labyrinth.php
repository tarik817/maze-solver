<?php

namespace App\Surface;

class Labyrinth implements SurfaceInterface
{
	protected $grid;

	/**
	 * Labyrinth constructor.
	 *
	 * @param $coordinatesFile
	 */
	public function __construct($coordinatesFile)
	{

		$this->grid = $this->processGrid($coordinatesFile);
	}

	/**
	 * Process grid, get grid coordinates from file.
	 *
	 * @param $coordinatesFile
	 * @return array
	 */
	protected function processGrid($coordinatesFile)
	{
		$result = [];
		foreach (file($coordinatesFile) as $row) {
			$result[] = explode(' ', $row);
		}

		return $result;
	}

	/**
	 * @inheritdoc
	 */
	public function getGrid() : array
	{

		return $this->grid;
	}

}
