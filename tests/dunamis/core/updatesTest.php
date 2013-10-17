<?php

/* Bootstrap! */
require dirname( dirname( __DIR__ ) ) . DIRECTORY_SEPARATOR . 'bootstrap.php';


/**
 * Test class for DunUpdates.
 * Generated by PHPUnit on 2013-10-17 at 09:35:01.
 */
class DunUpdatesTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var DunUpdates
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
     * @covers DunUpdates::getInstance
     */
    public function testGetInstance()
    {
    	$update		=	dunloader( 'updates' );
    	$this->assertTrue( $update !== null, 'Loader did not return an object' );
    	$this->assertTrue( is_object( $update ) );
    	$this->assertInstanceOf( 'DunUpdates', $update );
    	return $update;
    }
    
    
	/**
	 * @covers DunUpdates::__call
	 * @depends testGetInstance
	 */
	public function testSetVariable( $update )
	{
		$update->setTarget( 'value' );
		$update->setTest( 'test' );
		$this->assertAttributeContains( 'value', '_target', $update );
		$this->assertAttributeContains( 'test', '_test', $update );
		return $update;
	}
	
	
	/**
	 * @covers DunUpdates::__call
	 * @depends testSetVariable
	 */
	public function testHasVariable( $update )
	{
		$value = $update->hasTarget();
		$this->assertTrue( $value );
		
		$value = $update->hasTest();
		$this->assertTrue( $value );
		
		$this->assertFalse( $update->hasNothing() );
		return $update;
	}
	
	
	/**
	 * @covers DunUpdates::__call
	 * @depends testSetVariable
	 */
	public function testGetVariable( $update )
	{
		$value = $update->getTarget();
		$this->assertTrue( $value == 'value' );
		
		$value = $update->getTest();
		$this->assertTrue( $value == 'test' );
		return $update;
	}



    /**
     * @covers DunUpdates::downloadAndReturn
     */
	public function testDownloadAndReturn()
	{
		$update	=	dunloader( 'updates' );
		$update->setUrl( 'https://www.gohigheris.com/customer-downloads/dunamis-framework/v1.1.5/dunamiswhmcsv1-1-5-zip' );
		$value	=	$update->downloadAndReturn( $update->getUrl(), array( 'username' => 'Steven', 'password' => 'J4VuMUaKnvwo9agtO3dx' ) ) ;
		$this->assertTrue( $update->getError() === null );
	}
	
	
	/**
	 * @covers DunUpdates::downloadAndStore
	 */
	public function testDownloadAndStore()
	{
		$update	=	dunloader( 'updates' );
		$update->setUrl( 'https://www.gohigheris.com/customer-downloads/dunamis-framework/v1.1.5/dunamiswhmcsv1-1-5-zip' );
		
		if ( isset( $_ENV['bamboo'] ) && $_ENV['bamboo'] == 'true' ) {
			$update->setTarget( '/home/jwhmcsco/public_html/hosting/tmp/updatetest.tmp' );
		}
		else {
			$update->setTarget( 'c:\xampp\tmp\update.tmp' );
		}
		
		$value	=	$update->downloadAndStore( $update->getUrl(), null, array( 'username' => 'Steven', 'password' => 'J4VuMUaKnvwo9agtO3dx' ) ) ;
		$this->assertTrue( $value !== false, $update->getError() );
	}
	
	
    /**
     * @covers DunUpdates::getAdapters
     * @depends testGetInstance
     */
	public function testGetAdapters( $update )
	{
		$adapters = $update->getAdapters();
		$this->assertTrue( is_array( $adapters ) );
		$this->assertContains( 'curl', $adapters );
	}
}
?>
