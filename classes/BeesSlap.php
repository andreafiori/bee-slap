<?php

class BeesSlap {
	
	private $log = array();

	/**
	 * Bees with their own points and hit points
	 *
	 * @var array
	 */
	private $bees = array(
		'queen' => array(
			'number'		=> 3,
			'initialPoints'	=> 100,
			'hitPoints'		=> 7,
		),
		'workers' => array(
			'number'		=> 5,
			'initialPoints' => 75,
			'hitPoints'		=> 12,
		),
		'drone' => array(
			'number'		=> 7,
			'initialPoints' => 75,
			'hitPoints'		=> 18,
		),
	);

	/**
	 * Set the array with the bee line-up
	 *
	 * @param array|null $bees
	 */
	public function __construct($bees = null)
	{
		if ( is_array($bees) ) {
			$this->rowLineUps($bees);
		} else {
			$this->rowLineUps($this->bees);
		}
	}

	/**
	 * Row all bees into a line-up
	 *
	 * @param array $bees
	 * @return array
	 */
	public function rowLineUps(array $bees)
	{
		foreach($bees as &$bee) {
			if (isset($bee['lineUp'])) {
				break;
			}

			unset($bee['lineUp']);

			for($i=1; $i <= $bee['number']; $i++) {
				$bee['lineUp'][$i] = $bee['initialPoints'];
			}
		}
		
		$this->bees = $bees;
		
		return $this->bees;
	}

	/**
	 * Choose a random bee kind to hit
	 *
	 * @return string
	 */
	public function recoverBeeKindToHit()
	{
		return array_rand($this->bees);
	}

	/**
	 * Recover a bee number
	 * 
	 * @param string $beeKind
	 * 
	 * @return int
	 */
	public function recoverBeeNumber($beeKind)
	{
		if ( !isset($this->bees[$beeKind]) ) {
			throw new \InvalidArgumentException($beeKind.' is not a valid bee kind');
		}
		
		return rand(1, $this->bees[$beeKind]['number']);
	}

	/**
	 * Deduct life points from a bee
	 *
	 * @param string $beeKind
	 * @param int $number
	 * @param null $hitPoints
	 *
	 * @return mixed
	 */
	public function deductHitPoints($beeKind, $number, $hitPoints = null)
	{
		if ( is_numeric($hitPoints) ) {
			$this->bees[$beeKind]['lineUp'][$number] -= $hitPoints;
		} else {
			$this->bees[$beeKind]['lineUp'][$number] -= $this->bees[$beeKind]['hitPoints'];
		}

		return $this->bees[$beeKind]['lineUp'][$number];
	}

	/**
	 * Check if all queen bee are dead
	 *
	 * @return bool
	 */
	public function areAllQueeensDead()
	{
		foreach($this->bees['queen']['lineUp'] as $key => $value) {
			if ($value > $this->bees['queen']['hitPoints']) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Check if a bee is dead
	 *
	 * @param string $beeKind
	 * @param int $number
	 *
	 * @return bool
	 */
	public function isBeeDead($beeKind, $number)
	{
		if ($this->bees[$beeKind]['lineUp'][$number] < $this->bees[$beeKind]['hitPoints']) {
			return true;
		}

		return false;
	}

	/**
	 * @param string $beeKind
	 * @param int $number
	 */
	public function removeBee($beeKind, $number)
	{
		$this->bees[$beeKind]['number'] -= 1;
		if ($this->bees[$beeKind]['number'] <= 0) {
			unset($this->bees[$beeKind]);
		} else {
			unset($this->bees[$beeKind]['lineUp'][$number]);
			
			sort($this->bees[$beeKind]['lineUp'][$number]);
		}
	}
	
	/**
	 * Get all bees
	 * 
	 * @return array
	 */
	public function getBees()
	{
		return $this->bees;
	}
	
	public function addLog($array)
	{
		$this->log[] = $array;
	}
	
	public function getLog($log)
	{
		return $this->log;
	}
	
	public function resetLog()
	{
		$this->log = [];
	}
}
