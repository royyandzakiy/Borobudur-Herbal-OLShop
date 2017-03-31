<?php
defined('ABSPATH') or die();

 if ( have_comments() ) : ?> 
     	<div class="row section-comment">
          <div class="col-sm-12">
            <ul class="media-list">
<?php wp_list_comments( array( 'callback' => 'dt_comment' ) ); ?>
			</ul>
		  </div>
		</div>

		<div class="row">
			<div class="paging-nav col-xs-12">
				<span class="float-left">
					<span class="paging-text paging-inline">
						<?php previous_comments_link('<span class="btn-arrow paging-inline"><i class="icon-left-open-big"></i></span> '.__('Previous Comments','Krypton')); ?>
					</span>
				</span>
				<span class="float-right">
					<span class="paging-text paging-inline">				
						<?php next_comments_link(__('Next Comments','Krypton').' <span class="btn-arrow paging-inline"><i class="icon-right-open-big"></i></span>'); ?>
					</span> 
				</span>
			</div>
		</div>

<?php endif; ?>

<?php if ( ! comments_open()) : ?>
<?php 	do_action( 'comment_form_comments_closed' ); ?>
		<div class="row">
			<div class="col-sm-2"></div>
			<div class="col-sm-10">
				<div class="comment-count"><?php _e( 'Comments are closed.' , 'Krypton' ); ?></div>
				<hr>
			</div>	
		</div>
<?php else : ?>
	<?php dt_comment_form(); ?>

<?php endif; ?>