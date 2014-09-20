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

get_header( '404' ); ?>

<article class="col-md-12 col-sm-12 page-header">
	
	<header class="entry-header">
		
		<h1 class="entry-title">My Bad</h1>
		

		

		
	</header><!-- .entry-header -->
</article>

<div class="col-sm-10 col-sm-offset-1">
	<div class="row">
		<!--
<div class="col-sm-4">
			<img src="<?php echo get_template_directory_uri();  ?>/img/404.jpg" alt="404" />
		</div>
-->
		<div class="col-sm-10 col-sm-offset-1">
			<div class="fancy-letter">
										
										<div class="letter-body">
											<div class="col-sm-4 pull-right">
												<img src="<?php echo get_template_directory_uri();  ?>/img/404.jpg" alt="404" />
											</div>
											<div class="greeting">
											Your Lordship,
											</div>
											<p>Please accept my humblest of apologies.</p>
											<p>I could not locate that which are seeking.	It is possible that the scribe has incorrectly transliterated the location. It is also possible that the jester has been about and he's been known to move and delete pages willy nilly.
											</p>
											
											<p>May I suggest one of the following courses of action?</p>
											
											<ul>
												<li>Instruct the replacement scribe to transcribe the location in the address bar (assuming he has finished grieving his predecessor).</li>
												<li>Begin a search of the castle grounds for that which you are seeking: <?php echo do_shortcode('[wpbsearch]')  ;?></li>
												<li>Return to the <a href="<?php bloginfo( 'url');?>">castle entrance</a>.</li>
												<li>Dispatch a <a href="contact">message to the typesetter enumerating your displeasure at this inconvenience and demanding satisfaction</a>.</li>
											</ul>
											
											
									<div class="closure">
										<p>Your Humble Servant,</p>
										<img src="<?php echo get_template_directory_uri();  ?>/img/sig-contrite-knight.svg" alt="The Contrite Knight" />
									</div>
									
									<p>
										<b>P.S.</b> - At this late moment, I recognize the impropriety of suggesting that your Lordship mistyped the address. I regret losing my head.
									</p>	
	
											
										</div>
									
									
										
										
									</div>

		</div>
	</div>
</div>

	

<?php get_footer(); ?>
