<?php

namespace App\Player;

interface PlayerInterface
{
	/**
	 * Get passed steps.
	 *
	 * @return array
	 */
	public function getSteps(): array;
}
