<?php
/**
* This file is used to display your comments.
*
* @package Podcaster
* @since 1.0
* @author Theme Station
* @copyright Copyright (c) 2014, Theme Station
* @link http://www.themestation.co
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/


$options = get_option('podcaster-theme'); 
$pod_comm_display = isset( $options['pod-comments-display'] ) ? $options['pod-comments-display'] : '';
$pod_comm_format = isset( $options['pod-comments-setup'] ) ? $options['pod-comments-setup'] : '';

$aria_req = ( $req ? "aria-required='true'" : '' );
$required_text = sprintf( '' . __('Required fields are marked %s', 'thstlang'), '<span class="required">*</span>' );
?>

<?php if ( isset( $pod_comm_display ) && $pod_comm_display == true ) : ?>

	<?php
	$args = array(
		'id_form' => 'commentform',
		'id_submit' => 'submit',
		'title_reply' => __( 'Leave a Reply', 'thstlang' ),
		'title_reply_to' => __( 'Leave a Reply to %s', 'thstlang' ),
		'cancel_reply_link' => __( 'Cancel Reply', 'thstlang' ),
		'label_submit' => __( 'Post Comment', 'thstlang' ),
		'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun', 'thstlang' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
		'must_log_in' => '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'thstlang' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
		'logged_in_as' => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'thstlang' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
		'comment_notes_before' => '<p class="comment-notes">' . __( 'Your email address will not be published. ', 'thstlang' ) . ( $req ? $required_text : '' ) . '</p>',
		'comment_notes_after' => '',
		'fields' => apply_filters( 'comment_form_default_fields', array(
			'author' => '<p class="comment-form-author"><span><input placeholder="' . __('Name *', 'thstlang') . '" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" ' . $aria_req . ' /></span></p>',
			'email' => '<p class="comment-form-email"><span><input placeholder="' . __('Email *', 'thstlang') . '" id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" ' . $aria_req . ' /></span></p>',
			'url' => '<p class="comment-form-url"><span><input placeholder="' . __('URL', 'thstlang') . '" id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></span></p>' ) ) );


	 comment_form($args); ?>

	
	<div id="comments" class="clearfix">

	<?php if ( post_password_required() ) : ?>
		<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'thstlang'); ?></p>
	</div><!-- #comments -->
	<?php
			/* Stop the rest of comments.php from being processed,
			 * but don't kill the script entirely -- we still have
			 * to fully load the template.
			 */
			return;
		endif;
	?>

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h2 id="comments-title">
			<?php printf( _n( 'One comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', get_comments_number(), 'thstlang'),
				number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h2>
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-above">
			<h1 class="assistive-text"><?php _e( 'Comment navigation', 'thstlang' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'thstlang' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'thstlang' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>
		<?php if( isset( $pod_comm_format ) && $pod_comm_format == "comm" ) : ?>
			<ol class="commentlist">
				<?php wp_list_comments('type=comment&callback=mytheme_comment&avatar_size=40'); ?>
			</ol>
		<?php else : ?>
			<h4><?php echo __('Trackbacks & Pingbacks', 'thstlang'); ?></h4>
			<ol class="commentlist">
				<?php wp_list_comments('type=pings&callback=mytheme_comment&avatar_size=40'); ?>
			</ol>

			<h4><?php echo __('Comments', 'thstlang'); ?></h4>
			<ol class="commentlist">
				<?php wp_list_comments('type=comment&callback=mytheme_comment&avatar_size=40'); ?>
			</ol>
		<?php endif; ?>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below">
			<h1 class="assistive-text"><?php _e( 'Comment navigation', 'thstlang' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'thstlang' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'thstlang' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

	<?php
		/* If there are no comments and comments are closed, let's leave a little note, shall we?
		 * But we don't want the note on pages or post types that do not support comments.
		 */
		elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="nocomments"><?php _e( 'Comments are closed.', 'thstlang' ); ?></p>
	<?php endif; ?>
</div><!-- #comments -->
<?php else : ?>
	<div class="closed-comments">
		<?php if ( ! is_page() ) : ?>
		<?php echo __('Comments have been closed.', 'thstlang'); ?>
		<?php endif; ?>
	</div>
<?php endif; ?>