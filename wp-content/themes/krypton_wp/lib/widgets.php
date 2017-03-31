<?php
defined('ABSPATH') or die();

/** DT_Carousel_Recent_Posts **/
class DT_Carousel_Recent_Posts extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'dt_widget_carousel_recent_posts', 'description' => __( "Display most recent Posts in Carousel.",'Krypton') );
		parent::__construct('dt-carousel-recent-posts', __('DT Carousel Recent Posts','Krypton'), $widget_ops);
		$this->alt_option_name = 'dt_widget_carousel_recent_posts';

		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	function widget($args, $instance) {
		global $krypton_Scripts;
		global $krypton_config;

		$cache = wp_cache_get('dt_widget_carousel_recent_posts', 'widget');

       	wp_enqueue_script( 'owl.carousel', get_template_directory_uri() . '/js/owl.carousel.js', array( 'jquery' ), '', false );
           

		if ( !is_array($cache) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts','Krypton');
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 12;
		if ( ! $number ) $number = 12;

		$numberpostperslide = ( ! empty( $instance['numberpostperslide'] ) ) ? absint( $instance['numberpostperslide'] ) : 3;
		if ( ! $numberpostperslide ) $numberpostperslide = 3;

		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
		$show_thumb = isset( $instance['show_thumb'] ) ? $instance['show_thumb'] : false;
		$show_author = isset( $instance['show_author'] ) ? $instance['show_author'] : false;
		$categories = isset( $instance['categories'] ) ? implode(',',$instance['categories']) : '';

		$r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'cat' => $categories ) ) );
		if ($r->have_posts()) :
?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>

		<div id="<?php echo $this->get_field_id('dt'); ?>" class="owl-carousel">
		<?php
			$i = 0; 
			while ( $r->have_posts() ) : $r->the_post();
				$newslide = (($i % $numberpostperslide)==0) ? 1 : 0;

				if ($newslide==1) {
					if ($i!=0) {echo "</div>";}

					echo '<div class="owl-slide">';
				}
		?>
				<div class="row">
					<div class="mini-post">
						<?php 

						if ( $show_thumb ) : ?> 
						<?php 
							$thumb_id=get_post_thumbnail_id(get_the_ID());
							$featured_image = wp_get_attachment_image_src($thumb_id,'thumbnail',false); 
							$alt_image = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
							if (isset($featured_image[0])) {
								$imgurl = aq_resize($featured_image[0], 53, 53,true);
						?>											

							<a href="<?php the_permalink(); ?>" title="<?php get_the_title() ? the_title() : the_ID(); ?>"><img src="<?php echo $imgurl; ?>" alt="<?php print esc_attr($alt_image);?>" /></a>

						<?php 
							} else {//if (isset($featured_image[0]))
						?>											
						
						<?php	if ($krypton_config['dt-use-default-banner-single-page']==1) : 
								$imgurl = aq_resize($krypton_config['dt-banner-single-page']['url'], 53, 53,true);
								$thumb_id= array_key_exists('id', $krypton_config['dt-banner-single-page']) ? $krypton_config['dt-banner-single-page']['id']:0;
								$alt_image = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
						?>			
								<a href="<?php the_permalink(); ?>" title="<?php get_the_title() ? the_title() : the_ID(); ?>"><img src="<?php echo $imgurl; ?>" alt="<?php print esc_attr($alt_image);?>" /></a>
						<?php	endif; //if ($krypton_config['dt-use-default-banner-single-page']
							} //if (isset($featured_image[0]))
						?>											
						
						<?php endif; //if ( $show_thumb ) ?>

						<p class="post-title"><a href="<?php the_permalink(); ?>" class="post-title"><?php get_the_title() ? the_title() : the_ID(); ?></a></p>

						<?php if ( $show_author ) : ?>
							<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" class="author"><?php echo get_the_author(); ?></a>
						<?php endif; ?>

						<?php if ( $show_date ) : ?> 
							<?php if ( $show_author ) : ?> - <?php endif; ?>
							<span class="date"><?php echo get_the_date(); ?></span>
						<?php endif; ?>

						
					</div>
					<hr/>
				</div>	
		<?php 
				$i++;

				if ($number==$i) { break; }
			endwhile; 

			if ($i>0) {echo "</div>";}
		?>
			
		</div>

		<?php
			$widgetID = $this->get_field_id('dt');

            $script='$(document).ready(function() {
            	\'use strict\';
            	$("#'.$widgetID.'").owlCarousel({
	                items       : 1, //10 items above 1000px browser width
	                itemsDesktop    : [1000,1], //5 items between 1000px and 901px
	                itemsDesktopSmall : [900,1], // 3 items betweem 900px and 601px
	                itemsTablet : [600,1], //2 items between 600 and 0;
	                itemsMobile : false, // itemsMobile disabled - inherit from itemsTablet option
	                pagination  : true,
	                slideSpeed  : 400
	            });
        	});';

        	array_push($krypton_Scripts,$script);
		?>

		<?php echo $after_widget; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('widget_recent_posts', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['numberpostperslide'] = (int) $new_instance['numberpostperslide'];
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
		$instance['show_thumb'] = isset( $new_instance['show_thumb'] ) ? (bool) $new_instance['show_thumb'] : false;
		$instance['show_author'] = isset( $new_instance['show_author'] ) ? (bool) $new_instance['show_author'] : false;
		$instance['categories'] = isset( $new_instance['categories'] ) ? (array) $new_instance['categories'] : array();
				
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['dt_widget_carousel_recent_posts']) )
			delete_option('dt_widget_carousel_recent_posts');

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('widget_recent_posts', 'widget');
	}

	function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 12;
		$numberpostperslide = isset( $instance['numberpostperslide'] ) ? absint( $instance['numberpostperslide'] ) : 3;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
		$show_thumb = isset( $instance['show_thumb'] ) ? (bool) $instance['show_thumb'] : false;
		$show_author = isset( $instance['show_author'] ) ? (bool) $instance['show_author'] : false;
		$categories = isset( $instance['categories'] ) ? (array) $instance['categories'] : array();
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:','Krypton'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:','Krypton'); ?></label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

		<p><label for="<?php echo $this->get_field_id( 'numberpostperslide' ); ?>"><?php _e( 'Number of posts per slide:','Krypton'); ?></label>
		<input id="<?php echo $this->get_field_id( 'numberpostperslide' ); ?>" name="<?php echo $this->get_field_name( 'numberpostperslide' ); ?>" type="text" value="<?php echo $numberpostperslide; ?>" size="3" /></p>

		<p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date ?','Krypton'); ?></label></p>

		<p><input class="checkbox" type="checkbox" <?php checked( $show_thumb ); ?> id="<?php echo $this->get_field_id( 'show_thumb' ); ?>" name="<?php echo $this->get_field_name( 'show_thumb' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_thumb' ); ?>"><?php _e( 'Display thumbnail ?','Krypton'); ?></label></p>

		<p><input class="checkbox" type="checkbox" <?php checked( $show_author ); ?> id="<?php echo $this->get_field_id( 'show_author' ); ?>" name="<?php echo $this->get_field_name( 'show_author' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_author' ); ?>"><?php _e( 'Display Author Name ?','Krypton'); ?></label></p>

		<p><label for="<?php echo $this->get_field_id( 'categories' ); ?>"><?php _e( 'Categories','Krypton'); ?> :</label>
			<ul>
<?php
		$args = array(
			'hierarchical' => 1,
			'orderby' => 'ID',
			'order'	=> 'asc'
		  );
		$arr_categories = get_categories($args);
		  foreach($arr_categories as $category) { 
?>
			<li><input class="checkbox" type="checkbox" <?php checked( in_array($category->cat_ID,$categories) ); ?> name="<?php echo $this->get_field_name( 'categories' ); ?>[]" value="<?php echo $category->cat_ID; ?>" /> <?php echo $category->name; ?> </li>
<?php
		} 
?>
			<ul>
		</p>

<?php
	}
}
/** /DT_Carousel_Recent_Posts **/

/** DT_Tabs **/
class DT_Tabs extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'dt_widget_tabs', 'description' => __( "Display popular posts, recent posts, and recent comments in Tabulation.",'Krypton') );
		parent::__construct('dt-tabs', __('DT Tabs','Krypton'), $widget_ops);
		$this->alt_option_name = 'dt_widget_tabs';

		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	function widget($args, $instance) {
		global $krypton_Scripts;
		global $krypton_config;

		$cache = wp_cache_get('dt_widget_tabs', 'widget');

		if ( !is_array($cache) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		extract($args);

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts','Krypton');
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 3;
		if ( ! $number ) $number = 3;
?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>

		<!-- Nav tabs -->
		<ul class="nav nav-tabs nav-justified">
		  <li class="active"><a href="#home_<?php echo $this->get_field_id('dt'); ?>" data-toggle="tab">Popular</a></li>
		  <li><a href="#recent_<?php echo $this->get_field_id('dt'); ?>" data-toggle="tab">Recent</a></li>
		  <li><a href="#comments_<?php echo $this->get_field_id('dt'); ?>" data-toggle="tab">Comments</a></li>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
		  	<div class="tab-pane fade in active" id="home_<?php echo $this->get_field_id('dt'); ?>">
<?php
				$r = new WP_Query(array( 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'meta_key' => 'post_views_count', 'orderby' => 'meta_value', 'order' => 'DESC' ) );
				if ($r->have_posts()) :
					$i = 0;
					while ( $r->have_posts() ) : $r->the_post();
						if ($i>0) {echo '<hr>';}
?>
				<div class="row">
					<div class="col-xs-3 image-info">

						<?php 
							$thumb_id=get_post_thumbnail_id(get_the_ID());
							$featured_image = wp_get_attachment_image_src($thumb_id,'thumbnail',false); 
							$alt_image = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
							if (isset($featured_image[0])) {
								//$imgurl = aq_resize($featured_image[0], $thumb_width, $thumb_height,true);
								$imgurl = $featured_image[0];
						?>											

							<a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url($imgurl); ?>" class="widget-post-thumb img-responsive" alt="<?php print esc_attr($alt_image);?>" /></a>

						<?php 
							} else {//if (isset($featured_image[0]))
						?>											
						
						<?php	if ($krypton_config['dt-use-default-banner-single-page']==1) : 
									$imgurl = aq_resize($krypton_config['dt-banner-single-page']['url'], 46, 46,true);
									$thumb_id= array_key_exists('id', $krypton_config['dt-banner-single-page']) ? $krypton_config['dt-banner-single-page']['id']:0;
									$alt_image = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
						?>			
								<a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url($imgurl); ?>"  class="widget-post-thumb img-responsive" alt="<?php print esc_attr($alt_image);?>" /></a>
						<?php	endif; //if ($krypton_config['dt-use-default-banner-single-page']
							} //if (isset($featured_image[0]))
						?>											

					</div>
					<div class="col-xs-9 post-info">
						<a href="<?php the_permalink(); ?>" class="widget-post-title"><?php get_the_title() ? the_title() : the_ID(); ?></a>
						<div class="meta-info">
							<div class="float-left">
								<i class="icon-clock-circled"></i> <?php echo get_the_date('j M Y'); ?>
							</div>
							<div class="float-right">
								<i class="icon-comment"></i> <?php echo get_comments_number(); ?> Comments
							</div>
						</div>
					</div>
				</div>
<?php
						$i++;
					endwhile; 
				// Reset the global $the_post as this query will have stomped on it
				wp_reset_postdata();

				endif; //if ($r->have_posts())
?>
		  	</div>
		  	<div class="tab-pane fade" id="recent_<?php echo $this->get_field_id('dt'); ?>">
<?php
				$r = new WP_Query(array( 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'orderby' => 'date', 'order' => 'DESC' ) );
				if ($r->have_posts()) :
					$i = 0;
					while ( $r->have_posts() ) : $r->the_post();
						if ($i>0) {echo '<hr>';}
?>
				<div class="row">
					<div class="col-xs-3 image-info">
						<?php 

							$thumb_id=get_post_thumbnail_id(get_the_ID());
							$featured_image = wp_get_attachment_image_src($thumb_id,'thumbnail',false); 
							$alt_image = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);

							if (isset($featured_image[0])) {
								//$imgurl = aq_resize($featured_image[0], $thumb_width, $thumb_height,true);
								$imgurl = $featured_image[0];
						?>											

							<a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url($imgurl); ?>" class="widget-post-thumb img-responsive" alt="<?php print esc_attr($alt_image);?>" /></a>

						<?php 
							} else {//if (isset($featured_image[0]))
						?>											
						
						<?php	if ($krypton_config['dt-use-default-banner-single-page']==1) : 
									$imgurl = aq_resize($krypton_config['dt-banner-single-page']['url'], 46, 46,true);
									$thumb_id= array_key_exists('id', $krypton_config['dt-banner-single-page']) ? $krypton_config['dt-banner-single-page']['id']:0;
									$alt_image = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);

						?>			
								<a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url($imgurl); ?>" class="widget-post-thumb img-responsive" alt="<?php print esc_attr($alt_image);?>" /></a>
						<?php	endif; //if ($krypton_config['dt-use-default-banner-single-page']
							} //if (isset($featured_image[0]))
						?>											
					</div>
					<div class="col-xs-9 post-info">
						<a href="<?php the_permalink(); ?>" class="widget-post-title"><?php get_the_title() ? the_title() : the_ID(); ?></a>
						<div class="meta-info">
							<div class="float-left">
								<i class="icon-clock"></i> <?php echo get_the_date('j M Y'); ?>
							</div>
							<div class="float-right">
								<i class="icon-comment"></i> <?php echo get_comments_number(); ?> Comments
							</div>
						</div>
					</div>
				</div>
<?php
						$i++;
					endwhile; 
				// Reset the global $the_post as this query will have stomped on it
				wp_reset_postdata();

				endif; //if ($r->have_posts())
?>
		  	</div>
		  	<div class="tab-pane fade" id="comments_<?php echo $this->get_field_id('dt'); ?>">
<?php
				$args = array(
					'status' => 'approve',
					'number' => $number
				);
				$comments = get_comments($args);
				$i = 0;
				foreach($comments as $comment) :
					if ($i>0) {echo '<hr>';}
?>
				<div class="row">
					<div class="col-xs-3 image-info">
						<?php 
							$avatar_url = get_avatar_url($comment->user_id,array('size'=>50 )); 
							if (isset($avatar_url)) {
						?>
						<a href="<?php echo get_permalink($comment->comment_post_ID); ?>"><img src="<?php echo esc_url($avatar_url); ?>" alt="<?php print esc_attr($comment->comment_author);?>" class="widget-post-thumb img-responsive" /></a>
						<?php 
							} //if (isset($avatar_url))
						?>
					</div>
					<div class="col-xs-9 post-info">
						<a href="<?php echo get_permalink($comment->comment_post_ID); ?>" class="widget-post-title">
							<?php echo $comment->comment_author; ?>
						</a>
						<p class="comment"><?php echo $comment->comment_content; ?></p>
					</div>
				</div>
<?php
					$i++;
				endforeach;
?>
		  	</div>
		</div>					
		
		<?php echo $after_widget; ?>
<?php

	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
				

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['dt_widget_tabs']) )
			delete_option('dt_widget_tabs');

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('dt_widget_tabs', 'widget');
	}

	function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 3;
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:','Krypton'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts/comments to show:','Krypton'); ?></label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

<?php
	}
}
/** /DT_Tabs **/

/** DT_Featured_Posts **/
class DT_Featured_Posts extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'dt_widget_featured_posts', 'description' => __( "Display recent posts",'Krypton') );
		parent::__construct('dt-featured-posts', __('DT Recent Posts','Krypton'), $widget_ops);
		$this->alt_option_name = 'dt_featured_post';

		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	function widget($args, $instance) {
		global $krypton_Scripts;
		global $krypton_config;

		$cache = wp_cache_get('dt_widget_featured_posts', 'widget');

		if ( !is_array($cache) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		extract($args);

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts','Krypton');
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 4;
		if ( ! $number ) $number = 4;
?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>

<?php
				$r = new WP_Query(array( 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'orderby' => 'date', 'order' => 'DESC' ) );
				if ($r->have_posts()) :
					$i = 0;
					while ( $r->have_posts() ) : $r->the_post();
?>
						<div class="row featured-row">
							<div class="col-xs-3 featured-blog-image">
						<?php 
							$thumb_id=get_post_thumbnail_id(get_the_ID());
							$featured_image = wp_get_attachment_image_src($thumb_id,'thumbnail',false); 
							$alt_image = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
							if (isset($featured_image[0])) {
						?>											
								<a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url($featured_image[0]); ?>"  alt="<?php esc_attr($alt_image); ?>" /></a>

						<?php 
							} else {//if (isset($featured_image[0]))
						?>											
						
						<?php	if ($krypton_config['dt-use-default-banner-single-page']==1) : 
									$imgurl = aq_resize($krypton_config['dt-banner-single-page']['url'], 76, 76,true);
									$thumb_id= array_key_exists('id', $krypton_config['dt-banner-single-page'] ) ? $krypton_config['dt-banner-single-page']:0;
									$alt_image = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
						?>			
								<a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url($imgurl); ?>" alt="<?php esc_attr($alt_image); ?>" /></a>
						<?php	endif; //if ($krypton_config['dt-use-default-banner-single-page']
							} //if (isset($featured_image[0]))
						?>											
							</div>
							<div class="col-xs-6 col-md-9 col-lg-6 col-sm-9">
								<a href="<?php the_permalink(); ?>" class="featured-blog-title"><?php get_the_title() ? the_title() : the_ID(); ?></a>
							</div>
							<div class="col-xs-3">
								<div class="featured-blog-meta"><i class="icon-comment"></i> <?php echo get_comments_number(); ?></div>
								<div class="featured-blog-meta"><i class="icon-eye-5"></i> <?php echo dt_get_post_views_number(get_the_ID()); ?></div>
							</div>
						</div>

<?php
					endwhile; 
					// Reset the global $the_post as this query will have stomped on it
					wp_reset_postdata();

				endif; //if ($r->have_posts())
?>
		<?php echo $after_widget; ?>
<?php

	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
				
		//$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['dt_widget_featured_posts']) )
			delete_option('dt_widget_featured_posts');

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('dt_widget_featured_posts', 'widget');
	}

	function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 4;
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:','Krypton'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:','Krypton'); ?></label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
<?php
	}
}
/** /DT_Featured_Posts **/

/** DT_Image_Gallery **/
class DT_Image_Gallery extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'dt_image_gallery', 'description' => __('Display shortcode gallery in widget.','Krypton'));
		$control_ops = array('width' => 400, 'height' => 350);
		parent::__construct('dt_image_gallery', __('DT Image Gallery','Krypton'), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );

		$text=preg_replace('/\[gallery/', '[gallery is_widget="yes"', $text);

		echo $before_widget;
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } ?>
			<div class="dt_gallery_widget_text"><?php echo do_shortcode($text); ?></div>
		<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
		$instance['filter'] = isset($new_instance['filter']);
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
		$title = strip_tags($instance['title']);
		$text = esc_textarea($instance['text']);
?>
		<a class="widget-action" onclick="setTimeout(function(){location.reload();},1000);" href="#available-widgets"></a>

		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','Krypton'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

<?php 	wp_editor( $text, $this->get_field_id('text'), array( 'media_buttons' => true, 'textarea_name' => $this->get_field_name('text'), 'tinymce' => false, 'teeny' => false, 'quicktags' => true ) ); ?>
<?php
	}

}
/** /DT_Image_Gallery **/


/** DT Portfolio **/
class DT_Portfolio_Posts extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'dt_widget_portfolio', 'description' => __( "Display most recent portfolio.",'Krypton') );
		parent::__construct('dt-portfolio', __('DT Recent Portfolio','Krypton'), $widget_ops);

		$this->alt_option_name = 'dt_widget_portfolio';

		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	function widget($args, $instance) {
		global $krypton_Scripts;
		global $krypton_config;

		$cache = wp_cache_get('dt_widget_portfolio', 'widget');


		if ( !is_array($cache) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}


		ob_start();
		extract($args);

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts','Krypton');
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 12;
		if ( ! $number ) $number = 12;

		$categories = isset( $instance['categories'] ) ? $instance['categories']: '';


		$queryargs = apply_filters( 'widget_posts_args',
				array(
	                'post_type' => 'port',
					'no_found_rows' => false,
					'meta_key'    => '_thumbnail_id',
					'posts_per_page'=>$number
				));

		if($categories){
			$queryargs['tax_query']=array(
							array(
								'taxonomy' => 'portcat',
								'field' => 'id',
								'terms' =>  $categories 
							)
						);
		}

	
		$r = new WP_Query( $queryargs );	

		if ($r->have_posts()) :

?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>

		<div class="row">
		<?php
			$i = 1; 
			while ( $r->have_posts() ) : $r->the_post();

				$thumb_id=get_post_thumbnail_id(get_the_ID());

				$featured_image = wp_get_attachment_image_src($thumb_id,'small',false); 
				$alt_image = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);

				if($i=='1'){
					$imgurl = aq_resize($featured_image[0], 320, 320,true);

				}else{

					$imgurl = aq_resize($featured_image[0], 100, 100,true);
				}

		?>
			<?php if($featured_image):?>
				<?php if($i=='1'):?>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
				<?php else:?>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
				<?php endif;?>
					    <a href="<?php print get_permalink(get_the_ID());?>" class="thumbnail">
					      <img src="<?php print esc_url(($imgurl)?$imgurl:$featured_image[0]);?>" alt="<?php print esc_attr($alt_image);?>" />
					    </a>
				</div>
		<?php 
				$i++;
  			endif; //if($featured_image)

			endwhile; 
		?>
			
		</div>

		<?php echo $after_widget; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('dt_widget_portfolio', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['categories'] = isset( $new_instance['categories'] ) ? (array) $new_instance['categories'] : array();
				
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['dt_widget_portfolio']) )
			delete_option('dt_widget_portfolio');

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('dt_widget_portfolio', 'widget');
	}

	function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 12;
		$categories = isset( $instance['categories'] ) ? (array) $instance['categories'] : array();
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:','Krypton'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of portfolio to show:','Krypton'); ?></label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

		<p><label for="<?php echo $this->get_field_id( 'categories' ); ?>"><?php _e( 'Categories','Krypton'); ?> :</label>
		<ul>
<?php
		$args = array(
			'hierarchical' => 1,
			'taxonomy' => 'portcat',
			'orderby' => 'ID',
			'order'	=> 'asc'
		  );
		$arr_categories = get_categories($args);
		  foreach($arr_categories as $category) { 
?>
			<li><input class="checkbox" type="checkbox" <?php checked( in_array($category->cat_ID,$categories) ); ?> name="<?php echo $this->get_field_name( 'categories' ); ?>[]" value="<?php echo $category->cat_ID; ?>" /> <?php echo $category->name; ?> </li>
<?php
		} 
?>
			<ul>
		</p>

<?php
	}
}
/** /DT Portfolio **/

function dt_widgets_init(){
	 register_widget('DT_Carousel_Recent_Posts');

	 register_widget('DT_Tabs');

	 register_widget('DT_Featured_Posts');

	 register_widget('DT_Image_Gallery');

	 register_widget('DT_Portfolio_Posts');
}

// widget init
add_action('widgets_init', 'dt_widgets_init',1);

?>
