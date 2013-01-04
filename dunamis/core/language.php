<?php


class DunLanguage extends DunObject
{
	/**
	 * Stores the language in use
	 * @access		protected
	 * @var			string
	 * @since		1.0.0
	 */
	protected $_idiom	= null;
	
	protected static $instance	= null;
	
	protected $_trans	= array();
	
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $options: contains an array of arguments
	 *
	 * @since		1.0.0
	 */
	public function __construct( $options = array() )
	{
		parent :: __construct( $options );
	}
	
	
	/**
	 * Add an array to the translation array
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $trans: the array to add
	 * 
	 * @since		1.0.0
	 */
	public function appendTranslations( $trans = array() )
	{
		$this->_trans	= array_merge( $this->_trans, $trans );
		return self :: $instance;
	}
	
	
	/**
	 * Method to get the idiom from the object
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		string
	 * @since		1.0.0
	 */
	public function getIdiom()
	{
		return $this->_idiom;
	}
	
	
	/**
	 * Singleton
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 * @param		array		- $options: contains an array of arguments
	 *
	 * @return		object
	 * @since		1.0.0
	 */
	public static function getInstance( $options = array() )
	{
		//self :: $instance = null;
	
		if (! is_object( self :: $instance ) ) {
			
			if ( defined( 'DUN_ENV' ) ) {
				$classname = ucfirst( strtolower( DUN_ENV ) ) . 'DunLanguage';
				self :: $instance	= new $classname();
			}
			else {
				self :: $instance = new self( $options );
			}
		}
	
		return self :: $instance ;
	}
	
	
	/**
	 * Loads a language file into place
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $module: contains the module name
	 * 
	 * @since		1.0.0
	 */
	public function loadLanguage( $module = null )
	{
		$dun	= & get_dunamis( $module );
		$path	=   $dun->getModulePath( $module, 'lang');
		$idiom	=   $this->getIdiom();
		
		$paths	= array( $path . 'English.php', $path . ucfirst( $idiom ) . '.php' );
		
		foreach ( $paths as $path ) {
			if (! file_exists( $path ) ) continue;
			include_once( $path );
			$this->appendTranslations( $lang );
		}
		
		return self :: $instance;
	}
	
	
	/**
	 * Method to set the idiom to the object
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $idiom: contains the language idiom
	 * 
	 * @since		1.0.0
	 */
	public function setIdiom( $idiom = null )
	{
		if ( $idiom == null ) return;
		$this->_idiom = strtolower( $idiom );
		return self :: $instance;
	}
	
	
	/**
	 * Method to translate a string
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $string: the string to translate
	 * @param		array		- $args: any replacement variables to include (sprintf)
	 * 
	 * @return		string
	 * @since		1.0.0
	 */
	public function translate( $string = null, $args = array() )
	{
		if ( $string == null ) return $string;
		if (! isset( $this->_trans[$string] ) ) return $string;
		if ( empty( $args ) ) return $this->_trans[$string];
		array_unshift( $args, $this->_trans[$string] );
		return call_user_func_array( 'sprintf', $args );
	}
}