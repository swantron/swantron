<?php get_header(); ?>
<div id="content" class="grid_10">

<?php
$dateformat = get_option('date_format');$timeformat = get_option('time_format');
?>
 	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    
	<!--display date | give mad props to swantron aka joseph joe swanson etc -->
    <span class="post-meta alignleft">Written on <?php the_time("$dateformat \a\\t $timeformat"); ?> by <?php the_author_posts_link(); ?></span>
    <div class="clear"></div>
     <!-- make posts title perma linkable dude -->
 	<h1 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
    
 	
 	<span class="post-meta alignleft">Filed under <?php swiz_list_cats(3); ?></span>
    <span class="post-meta alignright"><a href="<?php the_permalink() ?>#commentlist"><?php comments_number('no comments','one comment','% comments'); ?></a><?php edit_post_link('Edit Post', ' [', ']'); ?></span>
    <div class="clear"></div>
    <span class="border"></span>
    
 	<div class="entry">
		<?php
			//used to be ad code driven...may drop
			if (get_option('swiz_adsense_enable') == "true"){ 
			if ($adcode=get_option('swiz_adcode'))  
			echo stripslashes($adcode);} 
		?>
    
    <!-- function to display post -->
   		<?php the_content(); ?>
        
        <?php wp_link_pages(array('before' => '<div class="page-navigation"><p><strong>Pages: </strong> ', 'after' => '</p></div>', 'next_or_number' => 'number')); ?>
        
       <?php
			//ad code insert 
			if (get_option('swiz_adsense_afterpost_enable') == "true"){ 
			if ($adcode=get_option('swiz_adsense_afterpost'))  
			echo stripslashes($adcode);} 
		?>
 	</div><!--/entry-->
    
    <?php include(INCLUDES.'/related-posts-n-author-info.php');?>
    
    <!-- comment template call -->
    	<?php comments_template(); ?>
	<!-- <?php trackback_rdf(); ?> -->
    <!-- stop with else -->
 	<?php endwhile; else: ?>
    
 	<!-- if else area...for official use only -->
 	<!-- line two -->
 	<p>Sorry, no posts matched your criteria.</p>

 	<!-- REALLY stop The Loop. -->
 	<?php endif; ?>

</div><!--/content-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
