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
add_action( 'widgets_init', 'thst_highlight_category_widgets' );


// Register the widget.
function thst_highlight_category_widgets() {
	register_widget( 'Thst_Highlight_Category_Widget' );
}

// Extend WP_Widget with our widget.
class thst_highlight_category_widget extends WP_Widget {



	/*Widget Setup-----------------------------------------------------------------------------------*/
	/*The following lines register the widget with Wordpress*/

	function Thst_Highlight_Category_Widget() {
	
		// Widget setup
		$widget_ops = array( 'classname' => 'thst_highlight_category_widget', 'description' => __('This widget displays posts that you want to highlight. Select a category to display.', 'thstlang') );

		// Widget UI
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'thst_highlight_category_widget' );

		// Widget name and description
		parent::__construct(
			'thst_highlight_category_widget',
			__('Podcaster - Highlight Category Widget', 'thstlang'),
			$widget_ops, 
			$control_ops
		);
	}



	/*Display The Widget To The Front End-------------------------------------------------------------*/
	/*The following lines display the content of the widget to the user*/
	
	function widget( $args, $instance ) {
		extract( $args );
		
		// Widget title, entered in the widget settings
		$title = apply_filters('widget_title', $instance['title'] );

		/* Custom Options */
		
		// Our options from the widget settings.
		$select = $instance['kwtax'];

		// Before widget - as defined in your specific theme.
		echo $before_widget;

		/* Display The Widget */
		
		// Output the widget title if the user entered one in the widget options.
		//if ( $title )
			//echo $before_title . $title . $after_title;

			global $post;
			$args = array( 'numberposts' => 5, 'category' => $select );
			$myposts = get_posts( $args ); ?>
			<ul>
			<?php foreach( $myposts as $post ) : setup_postdata($post); ?>
				<li>
					<?php if ( has_post_thumbnail() ) { ?>
						<?php the_post_thumbnail('highlight'); ?>
						<div class="text arrow">
							<a class="h_title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							<span class="h_author">by <?php the_author(); ?></span>
							<span class="h_date"> &bull; <?php the_time( get_option( 'date_format' ) ); ?></span>
						</div>
					<?php } else { ?>
						<div class="text">
							<a class="h_title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							<span class="h_author">by <?php the_author(); ?></span>
							<span class="h_date"> &bull; <?php the_time( get_option( 'date_format' ) ); ?></span>
						</div>
					<?php } ?>
			    </li>
			        
			<?php endforeach; ?>
			</ul>			

		
		<?php /* After widget - as defined in your specific theme. */
		echo $after_widget;
	}



	/*Update The Widget With New Options---------------------------------------------------------------*/
	/*The following lines take care of checking, updating and saving the widget*/
	
	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['kwtax'] = strip_tags( $new_instance['kwtax'] );

		return $instance;
	}



	/*Widget Settings-----------------------------------------------------------------------------------*/
	/*The following lines display the widget form on the widget options page*/
	 
	function form( $instance ) {

		/* Default Widget Settings */
			
		$defaults = array(
			'title' => 'Highlight Category'
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
            <select id="<?php echo $this->get_field_id('kwtax'); ?>" name="<?php echo $this->get_field_name('kwtax'); ?>" class="widefat" style="width:100%;">
                <?php foreach(get_terms('category','parent=0&hide_empty=0') as $term) { ?>
                <option <?php if( isset($instance['kwtax']) ) { selected( $instance['kwtax'], $term->term_id ); } ?> value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
                <?php } ?>      
            </select>
        </p>

	<?php 
	} 

} ?>