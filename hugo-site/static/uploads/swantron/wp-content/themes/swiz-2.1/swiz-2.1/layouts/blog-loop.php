<?php function blogloop($excerpt,$thumb_disable,$fullpost_number){ ?>	<?php
$dateformat = get_option('date_format');
$timeformat = get_option('time_format');
$i=0;
?>
 	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <?php global $do_not_duplicate;?>
    <?php 
	if(!$do_not_duplicate)$do_not_duplicate[dummy]='dummy';
	if (!in_array(get_the_ID(),$do_not_duplicate)):?>
    
     <!-- permalink to title  -->
 	<h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
    
 	<!-- display date | display link to swantron aka joseph aka joe swansons other posts -->
 	<span class="post-meta alignleft">Filed under <?php swiz_list_cats(2); ?> by <?php the_author_posts_link(); ?> on <?php the_time("$dateformat \a\\t $timeformat"); ?></span>
    <span class="post-meta alignright"><a href="<?php the_permalink() ?>#commentlist"><?php comments_number('no comments','one comment','% comments'); ?></a></span>
    <div class="clear"></div>
    <span class="border"></span>
    
 	<div class="entry">
    
    <?php 
		  if($i<$fullpost_number): {the_content();
		  $i++; //full post tracker
		  if($i+1==$fullpost_number) echo '<div class="fullpost-margin"></div>';}
		  else:	
	?>
    
   		<?php //either display full or selection depending on selection
		if($excerpt=="true"):?>
        	<?php if($thumb_disable!="true"): ?>
			<a href="<?php the_permalink() ?>" rel="bookmark"><img src="<?php echo U_URL.'/swiz_custom';?>/timthumb.php?src=<?php echo thumb(get_the_ID(),get_the_content());?>&amp;h=90&amp;w=176&amp;zc=1" alt="" class="mag-thumb" /></a>
            
            <?php endif; //thumbnail ender deal?>
			
			<?php the_excerpt(); ?>
			<a href="<?php the_permalink() ?>" class="read-more">Full Story &raquo;</a>
			<?php else:
			the_content();
			endif; //if checking end
			endif; //another if check end
			?>
        
 	</div>
    <div class="clear"></div>
    <!-- loop stopper  -->
 	<?php endif;endwhile; else: ?>
    
 	<!-- first if tests if there were any posts to -->
 	<!-- display..  if not -->
 	<p style="font-size:1.3em; line-height:1.8em">Sorry, no posts matched your criteria.</p>
    
	
 	<!-- final stop -->
 	<?php endif; ?>
    
    <div class="clear"></div>
 
	<?php	if(function_exists('swiz_pagenavi')) swiz_pagenavi(); ?>

 <?php }//blogloop end ?>
