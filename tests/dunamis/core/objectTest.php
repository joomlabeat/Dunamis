<?php

/* Bootstrap! */
require dirname( dirname( __DIR__ ) ) . DIRECTORY_SEPARATOR . 'bootstrap.php';


/**
 * Test class for DunObject.
 * Generated by PHPUnit on 2013-10-17 at 11:01:08.
 */
class DunObjectTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var DunObject
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        get_dunamis();
        $this->object	=	new DunObject();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }
    
    
	/**
	 * @covers DunUpdates::__call
	 */
	public function testSetVariable()
	{
		$this->object->setTest( 'value' );
		$this->assertAttributeContains( 'value', '_test', $this->object );
		return $this->object;
	}
	
	
	/**
	 * @covers DunUpdates::__call
	 * @depends testSetVariable
	 */
	public function testHasVariable( $object )
	{
		$value = $object->hasTest();
		$this->assertTrue( $value );
		
		$this->assertFalse( $object->hasNothing() );
		return $update;
	}
	
	
	/**
	 * @covers DunUpdates::__call
	 * @depends testSetVariable
	 */
	public function testGetVariable( $object )
	{
		$value = $object->getTest();
		$this->assertTrue( $value == 'value' );
	}
}
?>
