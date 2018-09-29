<?php

namespace App\Player;

class Robot implements PlayerInterface
{

	private $surface;
	public $position = [];
	public $stepPosition;
	public $prevPosition;
	public $path = [];
	public $available;
	public $exits;
	public $needRemove = false;

	/**
	 * Robot constructor.
	 *
	 * @param array $maze
	 * @param array $startPoints
	 */
	public function __construct(array $maze, array $startPoints)
	{
		$this->position = [(int)$startPoints['x'] => (int)$startPoints['y']];
		$this->surface = $maze;
		$this->exits = $this->getExits();
		$this->available = $this->getAvailable();
		array_push($this->path, $this->position);
	}


	/**
	 * @inheritdoc
	 */
	public function getSteps(): array
	{
		// Init step.
		$this->stepPosition = $this->position;
		// Go forward
		$nextStep = $this->stepForward();
		// If find the way.
		if ($nextStep) {

			return array_values($this->path);
		}

		return [];
	}


	/**
	 * Get maze exits coordinates.
	 *
	 * @return array
	 */
	public function getExits()
	{
		$grid = $this->surface;
		$topDownRows = [
			'top' => 0,
			'down' => count($grid) - 1,
		];
		$widthOfCell = count($grid[0]) - 1;
		$exits = [];
		foreach ($grid as $x => $row) {
			if (in_array($x, $topDownRows)) {
				foreach ($row as $y => $cell) {
					if (trim($cell)) {
						$exits[] = [$x => (int)trim($y)];
					}
				}
			} else {
				if (trim($row[$widthOfCell])) {
					$exits[] = [$x => $widthOfCell];
				} elseif (trim($row[0])) {
					$exits[] = [$x => (int)trim($row[0])];
				}
			}
		}

		return $exits;
	}

	/**
	 * Get maze available cells coordinates.
	 *
	 * @return array
	 */
	public function getAvailable()
	{
		$result = [];
		foreach ($this->surface as $x => $row) {
			foreach ($row as $y => $cell) {
				if (trim($cell)) {
					$result[] = [$x => $y];
				}
			}
		}

		return $result;
	}

	/**
	 * Go to next random step, write all steps, check if maze is solved.
	 *
	 * @return bool False when have no available steps and true when maze is solved.
	 */
	public function stepForward()
	{
		// Check available steps.
		$available = $this->getAvailableForStep($this->stepPosition);
		if (!empty($available)) {
			// Go to random step.
			shuffle($available);
			$nextSector = $available[0];
			$x = key($nextSector);
			$this->prevPosition = $this->stepPosition;
			$this->stepPosition = [$x => $nextSector[$x]];
			array_push($this->path, $this->stepPosition);
			// Check if solve the maze.
			$isTheLastOne = $this->checkIfCurrentStepIsTheLast();
			if ($isTheLastOne) {
				return true;
			}

			// If available steps, go forward.
			return $this->stepForward();
		}

		return false;
	}

	/**
	 * Check fo intersection between current step position and labyrinth end.
	 *
	 * @return bool
	 */
	public function checkIfCurrentStepIsTheLast()
	{
		foreach ($this->exits as $row) {

			foreach ($row as $key => $value) {
				if (isset($this->stepPosition[$key]) and $this->stepPosition[$key] == $value) {
					// Return true if solve maze.
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * Handle available steps for current position.
	 *
	 * @param $pos
	 * @return array
	 */
	public function getAvailableForStep($pos)
	{
		$x = key($pos);
		$y = $pos[$x];
		// All possible next step position.
		$positions = [
			[$x - 1 => $y],
			[$x + 1 => $y],
			[$x => $y - 1],
			[$x => $y + 1],
		];
		$result = [];
		// Check available moves.
		foreach ($this->available as $row) {
			foreach ($row as $x => $y) {
				foreach ($positions as $pos) {
					if (isset($pos[$x]) and $pos[$x] == $y) {
						$result[] = [$x => $y];
					}
				}
			}
		}
		// If can go only back.
		if ((count($result) < 2 and isset($this->prevPosition))
			and isset($result[0])
			and $result[0] === $this->prevPosition
		) {
			// If dead end, remove and and fire up that need be removed.
			if ($this->removeFromAvailable($this->stepPosition)) {
				// Set flag that this part of path need be removed.
				$this->needRemove = true;
			}
		} else {
			// Filter out previous step from available steps.
			foreach ($result as $key => $items) {
				foreach ($items as $x => $y) {
					if (isset($this->prevPosition[$x]) and $this->prevPosition[$x] === $y) {
						unset($result[$key]);
					}
				}
			}
		}
		// Remove dead end part of path.
		if (count($result) > 1 and $this->needRemove) {
			$this->removeFromAvailable($this->prevPosition);
			$this->needRemove = false;
		}

		return $result;
	}

	/**
	 * Remove given coordinates from available.
	 *
	 * @param $needle
	 * @return bool
	 */
	public function removeFromAvailable($needle)
	{
		foreach ($this->available as $key => $row) {
			foreach ($row as $x => $y) {
				if (isset($needle[$x]) and $needle[$x] === $y) {
					unset($this->available[$key]);

					return true;
				}
			}
		}

		return false;
	}

}
