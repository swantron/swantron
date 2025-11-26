<?php get_header();?>

<div id="content" class="grid_10">
<?php 

	
	if(get_option('swiz_archives_magzine')=="magzine")
		magloop(0);
	else
		blogloop(get_option('swiz_archive_excerpts_enable'),get_option('swiz_thumbs_disable'),0);
?>
</div><!--/content-->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
