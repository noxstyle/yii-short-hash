<?php

class ShortHashTest extends CTestCase
{
	const STATUS_PASS = 1;
	const STATUS_FAIL = 2;

	/**
	 * @var ShortHash $hasher instance of hasher
	 */
	protected $hasher;

	/**
	 * @var Array $testNumbers numbers to be tested
	 */
	protected $testNumbers;

	public function setUp()
	{
		$this->hasher = Yii::app()->shortHash;
	}

	/**
	 * Quick test to see the extension is working properly
	 */
	public function testHasher()
	{
		$this->assertNotNull($this->hasher);
		
		$this->assertTrue(method_exists($this->hasher, 'hash'));
		$this->assertTrue(method_exists($this->hasher, 'unhash'));

		$testHash = $this->hasher->hash(123);
		$this->assertNotNull($testHash);
		$this->assertEquals(123, $this->hasher->unhash($testHash));
	}

	/**
	 * Hash length of one applicable for numbers lower than 62
	 */
	public function testIntegrityLengthOne()
	{
		$this->testNumbers = array(1,2,3,10,23,61,rand(0,61),rand(0,61),rand(0,61));
		$this->_runIntegrityTest(1);

		# Failing numbers
		$this->testNumbers = array(62,63, 5846, 8457);
		$this->_runFailingIntegrityTest(1, self::STATUS_FAIL);
	}

	/**
	 * Hash length of two applicable for numbers lower than 3844
	 */
	public function testIntegrityLengthTwo()
	{
		$this->testNumbers = array(1,1000,rand(0,3843),rand(0,3843),rand(0,3843),rand(0,3843),rand(0,3843));
		$this->_runIntegrityTest(2);

		# Failing numbers
		$this->testNumbers = array(3844, rand(3844,100000000),rand(3844,100000000),rand(3844,100000000));
		$this->_runFailingIntegrityTest(2, self::STATUS_FAIL);
	}

	/**
	 * Hash length of three applicable for numbers lower than 238328
	 */
	public function testIntegrityLengthThree()
	{
		$this->testNumbers = array(1, 5, 10, 18, 54, 135, 1645, 54231, 99999);
		$this->_runIntegrityTest(3,$testNumbers);

		# Failing numbers
		$this->testNumbers = array(
			238328, rand(238328, 238328*10), rand(238328, 238328*10)
		);
		$this->_runFailingIntegrityTest(3, self::STATUS_FAIL);
	}

	/**
	 * Hash length of four applicable for numbers lower than 62⁴ (14776336)
	 */
	public function testIntegrityLengthFour()
	{
		$this->testNumbers = array(1, 5, 10, 18, 54, 135, 1645, 54231, 5894654, rand(10, 10000000), rand(10, 10000000), rand(10, 10000000));
		$this->_runIntegrityTest(4);

		# Failing numbers
		$this->testNumbers = array(
			14776336, rand(14776336, 14776336*5), rand(14776336, 14776336*5),
			rand(14776336, 14776336*5), rand(14776336, 14776336*5)
		);
		$this->_runFailingIntegrityTest(4, self::STATUS_FAIL);
	}

	/**
	 * Hash length of five applicable for numbers lower than 62⁵ (916132832)
	 */
	public function testIntegrityLengthFive()
	{
		$this->testNumbers = array(1, 5, 10, 18, 54, 135, 1645, 54231, 9999999,
			rand(10, 10000000), rand(10, 10000000), rand(10, 10000000));
		$this->_runIntegrityTest(5);

		# Failing numbers
		$this->testNumbers = array(
			916132832, rand(916132832, 916132832*5), rand(916132832, 916132832*5),
			rand(916132832, 916132832*5), rand(916132832, 916132832*5)
		);
		$this->_runFailingIntegrityTest(5, self::STATUS_FAIL);
	}

	/**
	 * Hash length of six applicable for numbers lower than 62⁶ (56800235584)
	 */
	public function testIntegrityLengthSix()
	{
		$this->testNumbers = array(
			1, 5 , 12 ,56800235583, rand(1, 56800235583),
			rand(1, 56800235583), rand(1, 56800235583)
		);
		$this->_runIntegrityTest(6);

		# Failing numbers
		$this->testNumbers = array(
			56800235584, rand(56800235584, 56800235584*10),
			rand(56800235584, 56800235584*10), rand(56800235584, 56800235584*10)
		);
		$this->_runIntegrityTest(6, self::STATUS_FAIL);
	}

	/**
	 * Hash length of seven applicable for numbers lower than 62⁷ (3521614606208)
	 */	
	public function testIntegrityLengthSeven()
	{
		$this->testNumbers = array(
			1, 5 , 12 ,3521614606207, rand(1, 3521614606207),
			rand(1, 3521614606207), rand(1, 3521614606207)
		);
		$this->_runIntegrityTest(7);

		# Failing numbers
		$this->testNumbers = array(
			3521614606208, rand(3521614606208, 3521614606208*10),
			rand(3521614606208, 3521614606208*10), rand(3521614606208, 3521614606208*10)
		);
		$this->_runIntegrityTest(7, self::STATUS_FAIL);
	}

	/**
	 * Hash length of seven applicable for numbers lower than 62⁸ (218340105584896)
	 */	
	public function testIntegrityLengthEight()
	{
		$this->testNumbers = array(
			1, 10, 92, rand(1, pow(62,8)-1), rand(1, pow(62,8)-1), rand(1, pow(62,8)-1)
		);
		$this->_runIntegrityTest(8);

		# Failing numbers
		$this->testNumbers = array(
			pow(62, 8), rand(pow(62, 8), pow(62, 8)*10), rand(pow(62, 8), pow(62, 8)*10)
		);
		$this->_runIntegrityTest(8,self::STATUS_FAIL);
	}

	/**
	 * Hash length of seven applicable for numbers lower than 62⁹ (13537086546263552)
	 */	
	public function testIntegrityLengthNine()
	{
		$this->testNumbers = array(1, rand(1, pow(62,9)-1), rand(1, pow(62,9)-1), rand(1, pow(62,9)-1));
		$this->_runIntegrityTest(9);

		# Failing numbers
		$this->testNumbers = array(
			pow(62,9), rand(pow(62,9), pow(62,9)*10),rand(pow(62,9), pow(62,9)*10)
		);
		$this->_runIntegrityTest(9, self::STATUS_FAIL);
	}

	/**
	 * Hash length of seven applicable for numbers lower than 62¹⁰ (839299365868340224)
	 */	
	public function testIntegrityLengthTen()
	{
		$this->testNumbers = array(1, 50, rand(1, pow(62,10)-1),rand(1, pow(62,10)-1),rand(1, pow(62,10)-1));
		$this->_runIntegrityTest(10);

		$this->testNumbers = array(
			pow(62,10), rand(pow(62,10), pow(62,10)*10), rand(pow(62,10), pow(62,10)*10)
		);
		$this->_runFailingIntegrityTest(10);
	}

	protected function _runIntegrityTest($len, $status=1)
	{
		$this->hasher->setLength($len);
		$this->assertEquals($len,$this->hasher->getLength());

		if ($status === self::STATUS_PASS)
			$this->_runPassingIntegrityTest();
		else
			$this->_runFailingIntegrityTest();
	}

	protected function _runPassingIntegrityTest()
	{
		foreach ($this->testNumbers as $number)
		{
			$hashed = $this->hasher->hash($number);
			$this->assertEquals($number, $this->hasher->unhash($hashed));
		}
	}

	protected function _runFailingIntegrityTest()
	{
		foreach ($this->testNumbers as $number)
		{
			$hashed = $this->hasher->hash($number);
			$this->assertNotEquals($number, $this->hasher->unhash($number));
		}
	}
}