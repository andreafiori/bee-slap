<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

include_once("../classes/BeesSlap.php");

class BeesSlapTest extends \PHPUnit_Framework_TestCase
{
	private $beesSlap;

	protected function setUp()
	{
		$this->beesSlap = new BeesSlap();
	}

	public function testRecoverBeeKindToHit()
	{
		$this->assertTrue( in_array($this->beesSlap->recoverBeeKindToHit(), array_keys($this->beesSlap->getBees())) );
	}

	public function testrecoverBeeNumber()
	{
		$beeKind = $this->beesSlap->recoverBeeKindToHit();
		
		$this->assertTrue( is_numeric($this->beesSlap->recoverBeeNumber($beeKind)) );
	}
	
	public function testDeductHitPoints()
	{
		$beeKind = $this->beesSlap->recoverBeeKindToHit();
		
		$number = $this->beesSlap->recoverBeeNumber($beeKind);
		
		$bees = $this->beesSlap->getBees();
		
		$this->assertTrue( $this->beesSlap->deductHitPoints($beeKind, $number) < $bees[$beeKind]['initialPoints'] );
	}

	public function testIsQueenDeadIsTrue()
	{
		$bees = $this->beesSlap->getBees();
		
		$number = $this->beesSlap->recoverBeeNumber('queen');
		
		$points = $this->beesSlap->deductHitPoints('queen', $number, 100);
		
		$this->assertTrue( $this->beesSlap->isQueenDead() );
	}
	
	public function testIsQueenDeadIsFalse()
	{
		$number = $this->beesSlap->recoverBeeNumber('queen');
		
		$points = $this->beesSlap->deductHitPoints('queen', $number, 1);
		
		$this->assertFalse( $this->beesSlap->isQueenDead() );
	}
	
	public function testIsBeeDeadIsTrue()
	{
		$beeKind = $this->beesSlap->recoverBeeKindToHit();
		
		$number = $this->beesSlap->recoverBeeNumber($beeKind);
				
		$this->beesSlap->deductHitPoints($beeKind, $number, 100);

		$this->assertTrue($this->beesSlap->isBeeDead($beeKind, $number));
	}
	
	public function testIsBeeDeadIsFalse()
	{
		$beeKind = $this->beesSlap->recoverBeeKindToHit();
		
		$number = $this->beesSlap->recoverBeeNumber($beeKind);
				
		$this->beesSlap->deductHitPoints($beeKind, $number);

		$this->assertFalse($this->beesSlap->isBeeDead($beeKind, $number));
	}
}
