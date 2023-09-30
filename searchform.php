<?php 
/**
 * This file is used to display your search form.
 *
 * @package Podcaster
 * @since 1.0
 */
?>

<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
    <div class="search-container">
		<label class="screen-reader-text" for="s"><?php echo __('Search for:', 'podcaster'); ?></label>
        <input type="text" value="" name="s" id="s" />
        <button type="submit" id="searchsubmit"></button>
    </div>
</form>