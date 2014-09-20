<?php

/**
 * Navigation menu rendering engine
 *
 * @author     Justas Butkus <justas@butkus.lt>
 * @since      2013.02.22
 *
 * @package    AllInOneCalendar
 * @subpackage AllInOneCalendar.Utility.Render
 */
class Ai1ec_Render_Navigation_Utility
    implements Ai1ec_Render_Renderable_Entity_Utility
{

	/**
	 * @inherit
	 */
	public function __construct( Ai1ec_Render_Entity_Utility $parent ) {
		$this->_parent = $parent;
	}

	/**
	 * @inherit
	 */
	public function get_snippet() {
		return $this->_parent->get_view(
			'navigation.php',
			$this->_parent->get( NULL )
		);
	}

}
