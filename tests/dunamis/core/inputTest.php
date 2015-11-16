<?php

/* Bootstrap! */
require dirname( dirname( __DIR__ ) ) . DIRECTORY_SEPARATOR . 'bootstrap.php';


/**
 * Test class for DunInput.
 * Generated by PHPUnit on 2013-10-17 at 13:19:39.
 */
class DunInputTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var DunInput
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        get_dunamis();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

	/**
	 * @covers DunInput::getInstance
	 */
	public function testGetInstance()
	{
		get_dunamis( 'dunamis' );
		$input	=	dunloader( 'input', false, array() );
		$this->assertTrue( $input !== null, 'Loader did not return an object' );
		$this->assertTrue( is_object( $input ) );
		$this->assertInstanceOf( 'DunInput', $input );
		return $input;
	}
	
	
	/**
	 * @covers DunInput::getVar
	 * @depends testGetInstance
	 */
	public function testGetVarWithDefault( $input )
	{
		$this->assertTrue( $input->getVar( 'variable', 'test', 'get' ) == 'test' );
	}
	
	
	/**
	 * @covers DunInput::getVar
	 * @depends testGetInstance
	 */
	public function testGetVarString( $input )
	{
		$this->assertTrue( is_a( $input, 'DunInput' ) );
		if ( isset( $_ENV['bamboo'] ) && $_ENV['bamboo'] == 'true' ) {
			$this->assertTrue( $input->getVar( 'HTTP_HOST', 'Something', 'server' ) == 'jwhmcs.com' );
		}
		else {
			$this->assertTrue( $input->getVar( 'HTTP_HOST', 'Something', 'server' ) == 'localhost.com' || $input->getVar( 'HTTP_HOST', 'Something', 'server' ) == 'localhost' );
		}
	}
	
	
	/**
	 * @covers DunInput::getVar
	 * @depends testGetInstance
	 */
	public function testGetVarArray( $input )
	{
		$this->assertTrue( is_array( $input->getVar( 'argv', array(), 'server', 'array' ) ) );
	}
	
	
	/**
	 * @covers DunInput::getVar
	 * @depends testGetInstance
	 */
	public function testCleanString( $input )
	{
		$this->assertTrue( is_string( $input->clean( 'HTTP_HOST', 'string' ) ) );
	}
	
	
	/**
	 * @covers DunInput::getVar
	 * @depends testGetInstance
	 */
	public function testCleanArray( $input )
	{
		$this->assertTrue( is_array( $input->clean( 'argv', 'array' ) ) );
	}
}
?>
