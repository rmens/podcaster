<?php 

/*-----------------------------------------------------------------------------------

	Plugin Name: Recent Posts Widget
	Plugin URI: http://www.themestation.co
	Description: Displays highlighted posts (by category)
	Version: 1.0
	Author: Theme Station
	Author URI: http://www.themestation.co

-----------------------------------------------------------------------------------*/

// Add webadelic_recent_blog_widgets function to widgets_init, this will load the widget.
add_action( 'widgets_init', 'thst_recent_blog_widgets' );


// Register the widget.
function thst_recent_blog_widgets() {
	register_widget( 'Thst_Recent_Blog_Widget' );
}

// Extend WP_Widget with our widget.
class thst_recent_blog_widget extends WP_Widget {



	/*Widget Setup-----------------------------------------------------------------------------------*/
	/*The following lines register the widget with Wordpress*/

	function Thst_Recent_Blog_Widget() {
	
		// Widget setup
		$widget_ops = array( 'classname' => 'thst_recent_blog_widget', 'description' => __('This widget displays a tab with your popular, most recent and most commented posts.', 'thstlang') );

		// Widget UI
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'thst_recent_blog_widget' );

		// Widget name and description
		parent::__construct(
			'thst_recent_blog_widget',
			__('Podcaster - Recent Posts Widget', 'thstlang'),
			$widget_ops, 
			$control_ops
		);
	}



	/*Display The Widget To The Front End-------------------------------------------------------------*/
	/*The following lines display the content of the widget to the user*/
	
	function widget( $args, $instance ) {
		extract( $args );
		
		//Widget title, entered in the widget settings
		$title = apply_filters('widget_title', $instance['title'] );

		/* Custom Options */
		
		// Our options from the widget settings.
		$number = $instance['number'];

		// Before widget - as defined in your specific theme.
		echo $before_widget;

		/* Display The Widget */
		
		// Output the widget title if the user entered one in the widget options.
		//if ( $title )
			//echo $before_title . $title . $after_title;
			
			$query = new WP_Query();

			//Send our widget options to the query
			$query->query( array(
				'post_type' => 'post',
			    'posts_per_page' => $number,
			    'ignore_sticky_posts' => 1
			 ));

			$query_comm = new WP_Query();

			//Send our widget options to the query
			$query_comm->query( array(
				'post_type' => 'post',
			    'posts_per_page' => $number,
			    'orderby' => 'comment_count',
			    'ignore_sticky_posts' => 1
			 ));

			$query_view = new WP_Query();

			//Send our widget options to the query
			$query_view->query( array(
				'post_type' => 'post',
			    'posts_per_page' => $number,
			    'meta_key' => 'post_views_count',
			    'orderby'=> 'meta_value',
			    'order' => 'desc',
			    'ignore_sticky_posts' => 1
			 ));

			?>
			<div class="acco_loading">&nbsp;</div>
						
			<div class="recent_tabs">
				<ul class="clearfix">
					<li><a class="pop_link" href="#popular"><?php echo __('Popular', 'thstlang') ?></a></li>
					<li><a class="rec_link" href="#recent"><?php echo __('Recent', 'thstlang') ?></a></li>
					<li><a class="com_link" href="#commented"><?php echo __('Commented', 'thstlang') ?></a></li>
				</ul>

				<div id="popular">
					<?php if ($query_view->have_posts()) : while ($query_view->have_posts()) : $query_view->the_post(); ?>
					<article>
						<?php 
							if( has_post_thumbnail() ) { 
								the_post_thumbnail( 'thumbnail' );
							} else { 
								echo '<img alt="pic_thumb" src="' . get_template_directory_uri() . '/widgets/img/widget-icons-plh_tr.png" />'; 
							} 
						?>
						<div class="text">
							<h4><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
							<p class="date"><?php the_time( get_option( 'date_format' ) ) ?></p>
						</div><!--text-->
						<div class="clear"></div>
					</article>
					<?php endwhile; endif; wp_reset_postdata(); ?>
				</div>

				<div id="recent">
					<?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
					<article>
						<?php 
							if( has_post_thumbnail() ) { 
								the_post_thumbnail( 'thumbnail' );
							} else { 
								echo '<img alt="pic_thumb" src="' . get_template_directory_uri() . '/widgets/img/widget-icons-plh_tr.png" />'; 
							} 
						?>
						<div class="text">
							<h4><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
							<p class="date"><?php the_time( get_option( 'date_format' ) ) ?></p>
						</div><!--text-->
						<div class="clear"></div>
					</article>
				<?php endwhile; endif; wp_reset_postdata(); ?>
				</div>

				<div id="commented">
					<?php if ($query_comm->have_posts()) : while ($query_comm->have_posts()) : $query_comm->the_post(); ?>
					<article>
						<?php 
							if( has_post_thumbnail() ) { 
								the_post_thumbnail( 'thumbnail' );
							} else { 
								echo '<img alt="pic_thumb" src="' . get_template_directory_uri() . '/widgets/img/widget-icons-plh_tr.png" />'; 
							} 
						?>
						<div class="text">
							<h4><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
							<p class="date"><?php the_time( get_option( 'date_format' ) ) ?></p>
						</div><!--text-->
						<div class="clear"></div>
					</article>
					<?php endwhile; endif; wp_reset_postdata(); ?>
				</div>
			</div><!--#acco-->				
			

		
		<?php /* After widget - as defined in your specific theme. */
		echo $after_widget;
	}



	/*Update The Widget With New Options---------------------------------------------------------------*/
	/*The following lines take care of checking, updating and saving the widget*/
	
	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = strip_tags( $new_instance['number'] );

		return $instance;
	}



	/*Widget Settings-----------------------------------------------------------------------------------*/
	/*The following lines display the widget form on the widget options page*/
	 
	function form( $instance ) {

		/* Default Widget Settings */
			
		$defaults = array(
			'title' => 'Recent Posts',
			'number' => '4'
		);
			
		$instance = wp_parse_args( (array) $instance, $defaults ); 
			
	?>

		<!-- Widget Title -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'thstlang') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
					
		<!-- Widget Article Count -->
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e('Post Count:', 'thstlang') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo $instance['number']; ?>" />
		</p>

	<?php 
	} 

} ?>