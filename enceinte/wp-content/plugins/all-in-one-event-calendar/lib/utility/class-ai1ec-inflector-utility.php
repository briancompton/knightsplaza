<?php

/**
 * Method responsible for changing case/wrapping of methods/classes
 *
 * @author     Timely Network Inc
 * @since      1.11.2
 *
 * @package    AllInOneEventCalendar
 * @subpackage AllInOneEventCalendar.Lib.Utility
 */
class Ai1ec_Inflector_Utility
{

	/**
	 * Turn input to class-like name
	 *
	 * @param string $name Arbitrary name to convert to Ai1EC-like class name
	 *
	 * @return string Ai1EC-like class name
	 */
	static public function classify( $name ) {
		$list = preg_split( '#[_\-\s]+#', $name, -1, PREG_SPLIT_NO_EMPTY );
		foreach ( $list as &$part ) {
			$part = ucfirst( strtolower( $part ) );
		}
		return implode( '_', $list );
	}

}