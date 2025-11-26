<?php
/*
Template Name: Debugging
*/
?>
<?php get_header(); ?>
<div id="content" class="grid_16">

 <?php
	  $categories=  get_categories(); 
	  print_r($categories);
			?>
</div><!--/content-->
<?php get_footer(); ?>