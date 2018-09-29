<?php

namespace App\Surface;

interface SurfaceInterface
{
	/**
	 * Get all maze cells.
	 *
	 * @return array
	 */
	public function getGrid(): array;
}
