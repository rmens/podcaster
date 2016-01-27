<?php 

/*-----------------------------------------------------------------------------------

	Plugin Name: Recent Comments Widget
	Plugin URI: http://www.themestation.net
	Description: Displays recent comments posts from a standard post type.
	Version: 1.0
	Author: David Martin
	Author URI: http://www.themestation.net

-----------------------------------------------------------------------------------*/

// Add aero_recent_comments_widgets function to widgets_init, this will load the widget.
add_action( 'widgets_init', 'thst_recent_comments_widgets' );


// Register the widget.
function thst_recent_comments_widgets() {
	register_widget( 'Thst_Recent_Comments_Widget' );
}

// Extend WP_Widget with our widget.
class thst_recent_comments_widget extends WP_Widget {



	/*Widget Setup-----------------------------------------------------------------------------------*/
	/*The following lines register the widget with Wordpress*/

	function Thst_Recent_Comments_Widget() {
	
		// Widget setup
		$widget_ops = array( 'classname' => 'thst_recent_comments_widget', 'description' => __('This widget displays your most recent comments.', 'thstlang') );

		// Widget UI
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'thst_recent_comments_widget' );

		// Widget name and description
		parent::__construct(
			'thst_recent_comments_widget',
			__('Podcaster - Recent Comments Widget', 'thstlang'),
			$widget_ops, 
			$control_ops
		);
	}



	/*Display The Widget To The Front End-------------------------------------------------------------*/
	/*The following lines display the content of the widget to the user*/
	
	function widget( $args, $instance ) {
		extract( $args );

		global $comments, $comment;

		
		//Widget title, entered in the widget settings
		$title = apply_filters('widget_title', $instance['title'] );

		/* Custom Options */
		
		// Our options from the widget settings.
		$number = $instance['number'];

		// Before widget - as defined in your specific theme.
		//echo $before_widget;


		/* Display The Widget */
		
			$output = '';
		    $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Recent Comments', 'thstlang' ) : $instance['title'], $instance, $this->id_base );

		    if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
		        $number = 5;

		    $category_name = empty( $instance['category_name'] ) ? '' : $instance['category_name'];

		    $comments = get_comments( apply_filters( 'widget_comments_args', array( 'number' => $number, 'status' => 'approve', 'post_status' => 'publish' ) ) );
		    $output .= $before_widget;
		    if ( $title )
		        $output .= $before_title . $title . $after_title;

		    $output .= '<ul id="thst-recentcomments">';


		    if ( $comments ) {
			    foreach ( (array) $comments as $comment) {
			    $comm_post_id = $comment->comment_post_ID;
			    if ( $category_name ) {
			        if (!in_category( "{$category_name}", $comm_post_id )) {
			            continue;
			        }
			    }
			    $string = _x( 
				'%1$s %2$s - %3$s %4$s',                // string to translate
				'recent comments 1 = gravatar, 2 = comment_author_link, 3 = comment_link, 4  = comment_date ', // context for translators
				'thstlang'                                  // text domain
				);

				$visible = sprintf( $string, 
					get_avatar( $comment, 48 ), 
					'<div class="text">' . get_comment_author_link() , 
					'<a href="' . esc_url( get_comment_link($comment->comment_ID) ) . '">' . get_the_title($comment->comment_post_ID) . '</a>', 
					'<p class="date">' . get_comment_date( get_option( 'date_format' ) ) . '</p></div>');

				$output .= '<li class="recentcomments">' . $visible . '</li>';

			    }
			}


		    $output .= '</ul>';
		    $output .= $after_widget;

		    echo $output;


		
		/* After widget - as defined in your specific theme. */
		//echo $after_widget;
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
			'title' => __('Recent Comments', 'thstlang'),
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
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo $instance['number']; ?>" style="width:25%;" />
		</p>

	<?php 
	} 

} ?>