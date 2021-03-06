<?php
/**
 * @package         @packageName@
 * @version         @fileVers@
 *
 * @author          @buildAuthor@
 * @link            @buildUrl@
 * @copyright       @copyRight@
 * @license         @buildLicense@
 */

defined('DUNAMIS') OR exit('No direct script access allowed');

/**
 * Dropdown Field
 * @desc		This is used to render a dropdown field for a form in the Dunamis Framework
 * @package		Dunamis
 * @subpackage	Core
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
*/
class DropdownDunFields extends DunFields
{
	protected $_optid				=	'id';
	protected $_optname				=	'name';
	protected $_optgroup			=	'group';
	protected $options				=	array();
	protected $value				=	array();
	protected $_translateoptions	=	true;
	
	public function __construct( $settings = array() )
	{
		foreach( array( 'options', 'value', 'translateoptions' ) as $item ) {
			if ( array_key_exists( $item, $settings ) ) {
				if ( $item == 'translateoptions' ) {
					$key = '_' . $item;
					$this->$key = (bool) $settings[$item];
					continue;
				}
				$this->$item = (array) $settings[$item];
				unset( $settings[$item] );
			}
		}
		
		parent :: __construct( $settings );
		
		foreach ( $settings as $key => $value ) {
			$this->attributes[$key] = $value;
		}
	}
	
	
	/**
	 * Renders a form field
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $options: any options to pass along
	 * 
	 * @return		string containing form field
	 * @since		1.0.0
	 */
	public function field( $options = array() )
	{
		$name		= $this->name;
		$value		= (array) $this->value;
		$id			= $this->id;
		
		$attr		= array_to_string( array_merge( $this->attributes, $options ) );
		$optns		= $this->options;
		
		$form		=	'<select id="' . $id . '" name="'.$name.'" '.$attr.">\n";
		$oid		=	$this->_optid;
		$oname		=	$this->_optname;
		$ogroup		=	$this->_optgroup;
		$prevgroup	=	false;
		
		foreach ( $optns as $optn ) {
			$optn		=	(object) $optn;
			if ( isset( $optn->$ogroup ) ) {
				if ( $prevgroup ) {
					$form .= '</optgroup>';
				}
				$form	.=	'<optgroup label="' . $optn->$ogroup . '">';
				continue;
			}
			$selected	=	( in_array( $optn->$oid, $value ) ? ' selected="selected"' : '' ); 
			$form		.=	'<option value="' . $optn->$oid . '"' . $selected . '>' . ( $this->_translateoptions ? t( $optn->$oname ) : $optn->$oname ) . "</option>\n";
		}
		
		if ( $prevgroup ) {
			$form .= '</optgroup>';
		}
		
		return $form . '</select>';
	}
	
	
	/**
	 * Method to set an array option to the field
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $options: contains array of name | id pairs
	 * 
	 * @since		1.0.0
	 */
	public function setOption( $options = array() )
	{
		$this->options = $options;
	}
}