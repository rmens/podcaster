<?php 
/**
 * This file is used to display your search form.
 *
 * @package Podcaster
 * @since 1.0
 * @author Theme Station 
 * @copyright Copyright (c) 2014, Theme Station
 * @link http://www.themestation.co
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
?>

<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
    <div class="search-container">
		<label class="screen-reader-text" for="s">Search for:</label>
        <input type="text" value="" name="s" id="s" />
        <input type="submit" id="searchsubmit" value="&#xF097;" class="batch" />
    </div>
</form>