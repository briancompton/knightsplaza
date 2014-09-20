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


	<?php while ( have_posts() ) : the_post(); ?>
					
		<?php get_template_part( 'content', 'page' ); ?>
		
		

	<?php endwhile; // end of the loop. ?>
	
	<?php
$args = array( 'post_type' => 'faqs', 'meta_key' => 'sort_order', 'orderby' => 'meta_value', 'order' => 'asc' );
$loop = new WP_Query( $args );
?>
<?php while ( $loop->have_posts() ) : $loop->the_post(); // start the loop ?>			

<?php 

$repeater = get_field( 'sort_order' ); 

//sort($repeater);

/*
foreach( $repeater as $key => $row )
{
    $column_id[ $key ] = $row['sort_order'];
}
*/

/*
array_multisort($ar[0], SORT_ASC, SORT_STRING,
                $ar[1], SORT_NUMERIC, SORT_DESC);
var_dump($ar);	
*/
	
?>		
				
					<div class="faq-holder" id="sort-<?php the_field('sort_order'); ?>">				
					<?php // check for rows (parent repeater)
						if( get_field('faq_categories') ): ?>
							<div class="faq-category-title"><?php the_title(); ?></div>
							<div class="faq-category">
								<ul class="the-faqs">
								<?php // loop through rows (parent repeater)
									while( has_sub_field('faq_categories') ): ?>
									<div class="faq-qna">
										<li class="faq-question"><?php the_sub_field('question'); ?></li>
										<li class="faq-answer"><?php the_sub_field('answer'); ?></li>
									</div>
									<?php endwhile; // while( has_sub_field('faq_categories') ): ?>
								</ul>
							</div> <!-- /.faq-category -->
					<?php endif; // if( get_field('faq_categories') ): ?>
				 </div><!-- /.faq-holder -->
				<?php endwhile; // end of the loop. ?>

	
	

<?php get_footer(); ?>
