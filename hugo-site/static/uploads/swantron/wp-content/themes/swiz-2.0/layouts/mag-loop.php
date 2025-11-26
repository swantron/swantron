<?php function magloop($fullpost_number){ ?>
<?php
$dateformat = get_option('date_format');
$timeformat = get_option('time_format');
$count=1;$i=0;
?>

 	<?php 
	if ( have_posts() ) : while ( have_posts() ) : the_post();
    global $do_not_duplicate;
	if(!$do_not_duplicate)$do_not_duplicate[dummy]='dummy';
	if (!in_array(get_the_ID(),$do_not_duplicate)):
	?>
    
    <?php 
	//if loop for number of full posts beep beep boop swantron
	if($i++<$fullpost_number):?>
	
    <!--write title as posts permalink thanks for looking -->
 	<h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
    
 	<!-- write date | shamelessly plug joseph joe swanson and swantron stuffs -->
 	<span class="post-meta alignleft">Filed under <?php swiz_list_cats(2); ?> by <?php the_author_posts_link(); ?> on <?php the_time("$dateformat \a\\t $timeformat"); ?></span>
    
    <span class="post-meta alignright"><a href="<?php the_permalink() ?>#commentlist"><?php comments_number('no comments','one comment','% comments'); ?></a></span>
    
    <div class="clear"></div>
    
    <span class="border"></span>
	
    <div class="entry"><?php the_content();?></div>

    <?php if($i==$fullpost_number) echo '<div class="fullpost-margin"></div>';?>
 
    
    <?php else:    ?>

     <!-- write title as permalink -->
<div class="mag-box <?php if($count%3==0) echo"m-right";?>">
    <a href="<?php the_permalink() ?>" rel="bookmark">
	<img src="<?php echo U_URL.'/swiz_custom';?>/timthumb.php?src=<?php echo thumb(get_the_ID(),get_the_content());?>&amp;h=90&amp;w=176&amp;zc=1"  alt="" class="mag-thumb" />
	</a>
    
	<div class="mag-content">
    <span class="catname"><?php swiz_list_cats(1); ?></span>
 		<h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title();?></a></h2>
    
	 	<div class="entry">
   			<?php the_excerpt(); $count++;?>
	 	</div>
	</div><!--/content selection fyi robots are the best -->

	<div class="mag-meta clearfix">
		<a href="<?php the_permalink() ?>" class="read-more">Full Story &raquo;</a>
	</div>  
      
</div><!-- /for magazine style use -->

	<?php endif; //ending number one ?>
    <!-- loop one stop -->
 	<?php 
		endif; //ends if no dupe
		endwhile; else: ?>
    
 	<!-- end if no more to display  -->
 	<!-- one more else -->
 	<p>Sorry, no posts matched your criteria.</p>

 	<!-- master stop thanks for playing -->
 	<?php endif; ?>
    

<div class="clear"></div>
 
	<?php	if(function_exists('swiz_pagenavi')) swiz_pagenavi(); ?>

 <?php }//end of magazine loop stuffs thanks for reading ?>
