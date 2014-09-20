<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package kp
 */
?>

				</div><!-- .content-box -->

				<?php if( !is_home() ) : ?>	
					<div class="col-sm-12 footer-upper">
						<div class="row">
							<?php require_once( 'inc/footer-upper.php'); ?>
						</div><!-- /.row -->
					</div>
				<?php endif; ?>
					
					
					<div class="col-md-12 footer-lower">
						<div class="row">
							<div class="col-md-4 col-sm-4">
								<div class="box box-3">
								<div class="bar-title">UCF Links</div>
								<?php wp_nav_menu( array( 'theme_location' => 'footer-lower-ucf',
																					'container_class' => 'menu-footer-container col-md-12',
																					'menu_class' => 'nav navbar-nav kp-icons ucf',
																					'link_before' => '<span class="',
																					'link_after' => '" aria-hidden="true"></span>'
																	 ) ); ?>
								</div><!-- /box -->
							</div><!-- /col-md-4 -->
							
							<div class="col-md-4 col-sm-4">
								<div class="box box-3">
								<div class="bar-title">Get Social</div>
								<?php wp_nav_menu( array( 'theme_location' => 'footer-lower-smedia',
																					'container_class' => 'menu-footer-container col-md-12',
																					'menu_class' => 'nav navbar-nav kp-icons',
																					'link_before' => '<span class="',
																					'link_after' => '" aria-hidden="true"></span>'
																	 ) ); ?>
								</div><!-- /box -->
							</div><!-- /col-md-4 -->
														
							<div class="col-md-4 col-sm-4">
								<div class="box box-3">
									<a href="contact" alt="Contact Knights Plaza">
										<div class="bar-title">Contact</div>
									</a>
									<?php wp_nav_menu( array( 'theme_location' => 'footer-lower-contact',
																						'container_class' => 'menu-footer-container col-md-12',
																						'menu_class' => 'nav navbar-nav kp-icons',
																						'link_before' => '<span class="kp-',
																						'link_after' => '" aria-hidden="true"></span>'
																		 ) ); ?>
								</div><!-- /box -->
							</div><!-- /col-md-4 -->
							
						</div><!-- /row -->
						
						<div class="row">
							<div class="col-md-12 copyright">
								&copy; <?php echo date('Y');?> <a href="http://ucf.edu">University of Central Florida</a>.
							</div><!-- .copyright -->
	
							<footer id="colophon" class="site-footer" role="contentinfo"></footer><!-- #colophon -->		
						</div><!-- .row -->
								
					</div><!-- .footer-lower -->
	
				<?php wp_footer(); ?>

					</div><!-- .col-md-10 .castle -->
	
				</div><!-- .row .enceinte -->
			</div><!-- col-md-12 col-lg-10 -->
		</div><!-- .row -->
		
	</div><!-- #page -->
</div><!-- .container -->

					  <!-- Modal -->
  <div class="modal fade" id="connectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="bar-title modal-title">Connect with Knights Plaza</h4>
        </div>
        <div class="modal-body">
        	<div class="modal-holder">
	        	<div class="icon-holder kp-mobile-device"></div>
	        	<div class="copy-holder">
		        	<h2>Text Updates</h2>
							<p>Special offers and event updates before anyone.</p>		
	        	</div>
        	</div>
			
					<div class="modal-holder">
						<div class="icon-holder kp-newsletter"></div>
						<div class="copy-holder">
							<h2>Email News</h2>
							<p>Once a semester newsletter with offers and news.</p>
						</div>
					</div>
        
        
					<div class="modal-holder connect-form-holder">
	        	<h2>Sign Me Up</h2>

						<div class="iamb-form connect-form">
							<form id="connect-footer" role="form" action="#">
								<div class="form-group">									
									<label class="radio-inline">
									  <input type="radio" name="subType" id="sub1" value="both" checked=""> Texts & Emails
									</label>
									<label class="radio-inline">
									  <input type="radio" name="subType" id="sub2" value="texts"> Texts Only
									</label>
									<label class="radio-inline">
									  <input type="radio" name="subType" id="sub3" value="email"> Emails Only
									</label>
								</div>
							
								<div class="form-group">
							    <label for="name">Your Name</label>
							    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Your Name">
							  </div>
							  <div class="form-group">
							    <label for="email">Your Email Address</label>
							    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Your Email">
							  </div>
							  <div class="form-group">
							    <label for="textNum">Your Phone Number</label>
							    <input type="textNum" class="form-control" id="textNum" name="textNum" placeholder="Enter Your Phone Number">
							    <span class="help-block">Standard Text Messaging and other charges may apply per your service plan.</span>
							  </div>
	
							  <button id="form-connect-footer" type="submit" class="btn btn-default">Submit</button>
							  <div id="resultConnect"></div>
								
								
								
							</form>
						</div>

					</div>
					
        </div>
        <div class="modal-footer">
         
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->


<!-- Bug Tracker Modal -->

				  <!-- Modal -->
  <div class="modal fade" id="bugModal" tabindex="-1" role="dialog" aria-labelledby="bugModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="bar-title modal-title"><span class="bug-modal kp-bug"></span> Report a Bug</h4>
        </div>
        <div class="modal-body">
        	<div class="modal-holder">
						<?php require_once( 'inc/vamonos_pest.php' ); ?>
					</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="submitBug">Submit Report</button>
          <div id="resultBug"></div>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->


<!-- What's This Modal -->

				  <!-- Modal -->
  <div class="modal fade" id="info-sessionModal" tabindex="-1" role="dialog" aria-labelledby="bugModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="bar-title modal-title">What's This?</h4>
        </div>
        <div class="modal-body">
        	<div class="modal-holder">
						<p>Session information is automatically collected data to help us identify the environment in which the reported bug was created. If you do not want this information shared with us, click the "Cancel" button.</p>
					</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

<!-- Location Modal -->
  <div class="modal fade" id="locationModal" tabindex="-1" role="dialog" aria-labelledby="locationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="bar-title modal-title">What's This?</h4>
        </div>
        <div class="modal-body">
        	<div class="modal-holder">
						<p>Session information is automatically collected data to help us identify the environment in which the reported bug was created. If you do not want this information shared with us, click the "Cancel" button.</p>
					</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->


</body>
</html>