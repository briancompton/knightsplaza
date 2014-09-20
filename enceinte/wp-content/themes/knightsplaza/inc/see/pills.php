<div class="eatery-pills">
							<?php // echo $number_tags; ?>
							<span class="label label-success"><?php echo "Open Now"; ?></span>
							<span class="label label-success"><?php echo "Deal$"; ?></span>
							<?php if( get_field( 'tags' ) ) { 
								$i = $number_tags;
								while ( $i > 0 ) { 
									--$i;
								?>
									<span class="label label-info"><?php echo $tags[ $i ]; ?></span>
								<?php
								
								};
								}
						  ?>
						</div>