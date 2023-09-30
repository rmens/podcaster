<?php
/**
* This file is used to display your comments.
*
* @package Podcaster
* @since 1.0
*/

$pod_comm_display = pod_theme_option('pod-comments-display', true);
$pod_comm_format = pod_theme_option('pod-comments-setup', 'comm');
$pod_comm_closed_txt = pod_theme_option('pod-blog-comments-closed-text', 'Comments are closed.');

$aria_req = ( $req ? "aria-required='true'" : '' );
$required_text = sprintf( '' . __('Required fields are marked %s', 'podcaster'), '<span class="required">*</span>' );

?>

<?php if ( isset( $pod_comm_display ) && $pod_comm_display == true ) : ?>

	<?php
	$args = array(
		'id_form' 					=> 'commentform',
		'id_submit' 				=> 'submit',
		'title_reply' 				=> __( 'Leave a Reply', 'podcaster' ),
		'title_reply_to' 			=> __( 'Leave a Reply to %s', 'podcaster' ),
		'cancel_reply_link' 		=> __( 'Cancel Reply', 'podcaster' ),
		'label_submit' 				=> __( 'Post Comment', 'podcaster' ),
		'comment_field'				=> '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun', 'podcaster' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
		'must_log_in' 				=> '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'podcaster' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
		'logged_in_as' 				=> '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'podcaster' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
		'comment_notes_before' 		=> '<p class="comment-notes">' . __( 'Your email address will not be published. ', 'podcaster' ) . ( $req ? $required_text : '' ) . '</p>',
		'comment_notes_after' 		=> '',
		'fields' 					=> apply_filters( 
			'comment_form_default_fields', array(
				'author' 		=> '<div class="comment-inputs"><div><p class="comment-form-author"><label for="author">' . __('Name *', 'podcaster') . '</label><span><input placeholder="' . __('Name *', 'podcaster') . '" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" ' . $aria_req . ' /></span></p></div>',
				'email' 		=> '<div><p class="comment-form-email"><label for="email">' . __('Email *', 'podcaster') . '</label><span><input placeholder="' . __('Email *', 'podcaster') . '" id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" ' . $aria_req . ' /></span></p></div>',
				'url' 			=> '<div><p class="comment-form-url"><label for="url">' . __('URL', 'podcaster') . '</label><span><input placeholder="' . __('URL', 'podcaster') . '" id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></span></p></div></div>' ) ) );


	 comment_form($args); ?>

	<?php if ( have_comments() ) { ?>
		<div id="comments" class="clearfix">

			<?php if ( post_password_required() ) { ?>
				<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'podcaster'); ?></p>
			</div><!-- #comments -->
			<?php
					/* Stop the rest of comments.php from being processed,
					 * but don't kill the script entirely -- we still have
					 * to fully load the template.
					 */
					return;
				}
			?>

				
			<h2 id="comments-title">
				<?php printf( _n( 'One comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', get_comments_number(), 'podcaster'),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
				?>
			</h2>


			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) { // are there comments to navigate through ?>
			<nav id="comment-nav-above">
				<h1 class="assistive-text"><?php _e( 'Comment navigation', 'podcaster' ); ?></h1>
				<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'podcaster' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'podcaster' ) ); ?></div>
			</nav>
			<?php } // Check for comment navigation. ?>


			<?php if( isset( $pod_comm_format ) && $pod_comm_format == "comm" ) { ?>
				<ol class="commentlist">
					<?php wp_list_comments('type=comment&callback=mytheme_comment&avatar_size=40'); ?>
				</ol>
			<?php } else { ?>
				<h4><?php echo __('Trackbacks & Pingbacks', 'podcaster'); ?></h4>
				<ol class="commentlist">
					<?php wp_list_comments('type=pings&callback=mytheme_comment&avatar_size=40'); ?>
				</ol>

				<h4><?php echo __('Comments', 'podcaster'); ?></h4>
				<ol class="commentlist">
					<?php wp_list_comments('type=comment&callback=mytheme_comment&avatar_size=40'); ?>
				</ol>
			<?php } // Load appropriate comment template depending on theme option settings. ?>


			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) { // are there comments to navigate through ?>
			<nav id="comment-nav-below">
				<h1 class="assistive-text"><?php _e( 'Comment navigation', 'podcaster' ); ?></h1>
				<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'podcaster' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'podcaster' ) ); ?></div>
			</nav>
			<?php } // Check for comment navigation ?>

		</div><!-- #comments -->		
	<?php
		/* If there are no comments and comments are closed, let's leave a little note, shall we?
		 * But we don't want the note on pages or post types that do not support comments.
		 */
		} elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) {
	?>
		<?php if( $pod_comm_closed_txt != '' ) { ?>
			<div class="closed-comments">
				<p class="nocomments"><?php echo esc_html( $pod_comm_closed_txt ); ?></p>
			</div>
		<?php } ?>
		
	<?php } ?>
	
<?php else : ?>
	<?php if( $pod_comm_closed_txt != '' ) { ?>
		<div class="closed-comments">
			<?php if ( ! is_page() ) : ?>
			<?php echo esc_html( $pod_comm_closed_txt ); ?>
			<?php endif; ?>
		</div>
	<?php } ?>
	
<?php endif; ?>