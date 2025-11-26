<?php get_header();?>

<div id="content" class="grid_10">


<h2 class="archive-title">Search results for "<?php the_search_query(); ?>"</h2>

<?php 

	include(TEMPLATEPATH.'/searchform.php');	
	if(get_option('swiz_archives_magzine')=="magzine")
		magloop(0);
	else
		blogloop(get_option('swiz_archive_excerpts_enable'),get_option('swiz_thumbs_disable'),0);
	include(TEMPLATEPATH.'/searchform.php');		
?>
</div><!--/content-->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
