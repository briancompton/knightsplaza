<?php

/**
 * Interface defining renderable element engine
 *
 * @author     Justas Butkus <justas@butkus.lt>
 * @since      2013.02.22
 *
 * @package    AllInOneCalendar
 * @subpackage AllInOneCalendar.Utility.Render
 */
interface Ai1ec_Render_Renderable_Entity_Utility
{

	/**
	 * Constructor
	 *
	 * Method accepting reference to parent renderer
	 *
	 * @param Ai1ec_Render_Entity_Utility $parent Renderer utility
	 *
	 * @return void Constructor does not return
	 */
	public function __construct( Ai1ec_Render_Entity_Utility $parent );

	/**
	 * get_snippet method
	 *
	 * Method uses link to parent rendering utility, to extract view
	 * variables, and return rendered HTML, for use in views.
	 *
	 * @return string Rendered HTML snippet
	 */
	public function get_snippet();

}
