<?php

namespace App;


use App\Surface\SurfaceInterface;

class SurfaceContext
{
	/**
	 * @var SurfaceInterface
	 */
	private $surface;

	/**
	 * SurfaceContext constructor.
	 *
	 * @param SurfaceInterface $surface
	 */
	public function __construct(SurfaceInterface $surface)
	{
		$this->surface = $surface;
	}

	/**
	 * Process surface context.
	 *
	 * @return array
	 */
	public function executeStrategy()
	{
		return $this->surface->getGrid();
	}

}
