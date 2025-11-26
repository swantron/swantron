<?php get_header(); ?>
<div id="content" class="grid_10">

 	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    
 
     <!-- set post title as robotic link-able permalink for the win -->
 	<h1 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
    
 
    <span class="border"></span>
    
 	<div class="entry">
   		<?php the_content(); ?>
        
        <?php wp_link_pages(array('before' => '<div class="page-navigation"><p><strong>Pages: </strong> ', 'after' => '</p></div>', 'next_or_number' => 'number')); ?>
 	</div>
    
    <!-- comments template...where art though -->
    	<?php comments_template(); ?>
	<!-- <?php trackback_rdf(); ?> -->
    <!-- loop stop  -->
 	<?php endwhile; else: ?>
    
 	<!-- loop stuffs thanks for looking at this source code...you earned a bonus comment -->
 	<!-- bonus comment:  these pretzels are making me thirsty -->
 	<p>Sorry, no posts matched your criteria.</p>

 	<!-- loop end for reals -->
 	<?php endif; ?>

</div><!--/content-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
