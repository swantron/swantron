<?php get_header();?>


<div id="content" class="grid_10">
<?php if(get_option('swiz_featured_enable')=="true") 	include(INCLUDES . '/featured-slider.php'); ?>

<?php 
	/*check for posts to be displayed per swiz options	*/
	  if(get_option('swiz_popular_enable')=="true"&&get_option('swiz_magzine')!="magzine"):
		$grid="grid_6 alpha";
	  else:
	  	$grid="grid_10 alpha";
	  endif;
?>

<div class="<?php echo $grid;?>">
<?php
	if(get_option('swiz_magzine')=="magzine")
		magloop(get_option('swiz_full_posts_number'));
	else
		blogloop(get_option('swiz_excerpts_enable'),get_option('swiz_thumbs_disable'),get_option('swiz_full_posts_number'));
?>
</div>

<!--popular posts section-->
<?php if(get_option('swiz_popular_enable')=="true"&&get_option('swiz_magzine')!="magzine"):?>
<div class="grid_4 omega">
<?php 	include(INCLUDES . '/popular-posts-home.php'); ?>
</div>
<?php endif;?>

</div><!--/content-->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
