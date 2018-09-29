<?php

namespace App;

use App\Player\PlayerInterface;

class PlayerContext
{
	/**
	 * @var PlayerInterface
	 */
	private $player;

	/**
	 * PlayerContext constructor.
	 *
	 * @param PlayerInterface $player
	 */
	public function __construct(PlayerInterface $player)
	{
		$this->player = $player;
	}

	/**
	 * Process surface context.
	 *
	 * @return array
	 */
	public function executeStrategy()
	{
		return $this->player->getSteps();
	}

}
