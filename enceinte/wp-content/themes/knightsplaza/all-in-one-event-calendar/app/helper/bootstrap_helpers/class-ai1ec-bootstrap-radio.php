<?php

/**
 *
 *  @author Timely Network Inc
 *        
 *        
 */

class Ai1ec_Bootstrap_Radio extends Ai1ec_Html_Element {
	
	private $label;
	private  $name;
	private $args;
	
	public function __construct( $label, $name, $id, array $args = array() ) {
		$this->label = $label;
		$this->name = $name;
		$this->id = $id;
		$this->args = $args;
		parent::__construct();
	}
	
	/**
	 *
	 * @see Ai1ec_Renderable::render()
	 *
	 */
	public function render() {
		$label = Ai1ec_Helper_Factory::create_generic_html_tag( 'label' );
		$label->set_attribute( 'for', $this->id );
		$label->add_class( 'radio' );
		$label->set_text(  $this->label );
		$label->set_prepend_text( false );
		$radio = Ai1ec_Helper_Factory::create_input_instance();
		$radio->set_type( 'radio' );
		$radio->set_id( $this->id );
		$radio->set_value( $this->id );
		$radio->set_name( $this->name );
		if( isset( $this->args['checked'] ) ) {
			$radio->set_attribute( 'checked', 'checked' );
		}
		$label->add_renderable_children( $radio );
		$label->render();
	}
}