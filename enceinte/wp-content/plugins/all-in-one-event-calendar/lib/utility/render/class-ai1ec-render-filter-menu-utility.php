<?php

/**
 * Filter menu rendering engine
 *
 * @author     Justas Butkus <justas@butkus.lt>
 * @since      2013.02.22
 *
 * @package    AllInOneCalendar
 * @subpackage AllInOneCalendar.Utility.Render
 */
class Ai1ec_Render_Filter_Menu_Utility
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
		$options = $this->_get_options();
		if ( false === $options ) {
			return '';
		}
		return $this->_parent->get_view( 'filter-menu.php', $options );
	}

	/**
	 * _get_options method
	 *
	 * Get a list of options, used to render filter menu
	 *
	 * @return array Map of option keys to values
	 */
	protected function _get_options() {
		$option_names = array(
			'contribution_buttons' => true,
			'views_dropdown'       => true,
			'categories'           => false,
			'tags'                 => false,
			'authors'              => false,
			'save_view_btngroup'   => true,
			'show_dropdowns'       => true,
			'show_select2'         => true,
			'span_for_select2'     => true,
		);
		$options = array();
		foreach ( $option_names as $name => $mandatory ) {
			$options[$name] = $this->_parent->get( $name );
			if ( $mandatory && NULL === $options[$name] ) {
				return false;
			}
		}
		return $options;
	}

}
