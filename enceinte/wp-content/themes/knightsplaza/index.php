<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package kp
 */

get_header(); ?>

		<div class="row">
		 <div class="col-md-12">
		 	<div class="row enceinte">
				
				<div class="col-md-2 tower hidden-xs hidden-sm">
					<div class="row">
					
						<div class="col-md-12 logo">
							<div class="row">
								<div class="col-md-12">
									<a href="http://ucf.edu" title="University of Central Florida">
										<span aria-hidden="true" class="kp-kplogo-upper"></span>
										<span aria-hidden="true" class="kp-kplogo-lower"></span>
									</a>
								</div>
							</div>					
						</div><!-- .logo -->
						
						<div class="col-md-12 proclamation">
							<?php  get_sidebar( 'proclamation' ); ?>
						</div><!-- .proclamation -->
					
					</div><!-- .row -->
				</div><!-- .tower -->
			
					<div class="col-md-10 col-sm-12 col-xs-12 castle pull-right">
			
						<div class="col-md-12 hero hidden-xs">
							<div class="row">
								<img src="<?php echo get_template_directory_uri(); ?>/img/hero-placeholder.jpg" alt="hero-placeholder" width="1000" height="340" />
							</div><!-- /row -->
							
							
							<div class="col-sm-2 visible-sm pull-left logo-sm">
								<a href="http://ucf.edu" title="University of Central Florida">
									<span aria-hidden="true" class="kp-kplogo-upper"></span>
									<span aria-hidden="true" class="kp-kplogo-lower"></span>
								</a>
							</div>
							
							<div class="col-md-6 pull-right nav-utility">
								<header id="masthead" class="site-header" role="banner">
							
									<nav id="site-navigation" class="main-navigation" role="navigation">
										<h1 class="menu-toggle"><?php _e( 'Menu', 'kp' ); ?></h1>
										<div class="screen-reader-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'kp' ); ?>"><?php _e( 'Skip to content', 'kp' ); ?></a></div>
							
										<?php wp_nav_menu( array( 'theme_location' => 'nav-upper', 'items_wrap' => '<ul id="%1$s" class="%2$s pull-right">%3$s<li class="ss-icon search search-top">Search</li></ul>' ) ); ?>
									</nav><!-- #site-navigation -->
							
								<div class="col-md-10 search-box">
									
									<form action="">
										<div class="col-md-12">
									    <div class="input-group">
									      <input type="text" class="form-control" id="search-terms" placeholder="Search...">
									      <span class="input-group-btn">
									        <button class="btn btn-default" type="button" id="search-button">Go!</button>
									      </span>
									    </div><!-- /input-group -->
									  </div><!-- /.col-lg-12 -->
									</form>
									
								</div><!-- /search-box -->
								
							</header><!-- #masthead -->	
							</div><!-- .nav-utility -->
						</div><!-- .hero -->
					
						<div class="col-md-12 col-sm-12 nav-mid">
							<nav class="navbar navbar-default" role="navigation">
							  <div class="navbar-header">
							    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
							      <span class="sr-only">Toggle navigation</span>
							      <span class="icon-bar"></span>
							      <span class="icon-bar"></span>
							      <span class="icon-bar"></span>
							    </button>
							    <a class="navbar-brand" href="http://www.knightsplaza.com">
							    	<span aria-hidden="true" class="kp-kplogo-upper"></span>
										<span aria-hidden="true" class="kp-kplogo-lower"></span>
									</a>
							  </div><!-- navbar-header -->
								<div class="collapse navbar-collapse">
								<?php // wp_nav_menu( array( 'theme_location' => 'nav-mid', 'menu_class' => 'navbar-mid', 'link_before' => '<i class="ss-symbolicons-block ss-utensils"></i>' ) ); ?>
								<?php $walker = new Menu_With_Description; ?>
				        <?php wp_nav_menu( 
						    				array( 	'theme_location' => 'nav-mid',
																'menu_class' => 'navbar-mid',
																'walker' => $walker
						    				) ); 
						    ?>
							</div><!-- navbar-collapse -->
							</nav>
						</div><!-- .nav-mid -->
					
						<div class="col-md-12 content-box">
							<?php require_once( 'inc/content-home.php' ); ?>
						</div><!-- .content-box -->
						
				
						<?php get_footer(); ?>
