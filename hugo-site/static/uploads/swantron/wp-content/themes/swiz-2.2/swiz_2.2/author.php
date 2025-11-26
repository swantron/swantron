<?php get_header();?>

<div id="content" class="grid_10">
<?php 


    if(isset($_GET['author_name'])) :
        $curauth = get_userdatabylogin($author_name);
    else :
        $curauth = get_userdata(intval($author));
    endif;
    ?>

    <h2 class="archive-title"><span class="normal">About</span> <?php echo $curauth->nickname; ?></h2>
    <p style="font-size:1.3em; line-height:1.8em">
    <span id="authorTempaAvatar"><?php echo get_avatar($curauth->user_email,90); ?></span>
	<?php echo $curauth->user_description; ?><br />
	<strong>Website:</strong> <a href="<?php echo $curauth->user_url; ?>"><?php echo $curauth->user_url; ?></a><br />
    

	<?php echo $curauth->nickname; ?> has penned <b><?php the_author_posts(); ?></b> awesome posts so far, feel free to peruse at your will.
    <br />
</p>
<div class="border"></div>
<br />
<?php	
	if(get_option('swiz_archives_magzine')=="magzine")
		magloop(0);
	else
		blogloop(get_option('swiz_archive_excerpts_enable'),get_option('swiz_thumbs_disable'),0);
?>  
</div><!--/content-->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
