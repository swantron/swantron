<!--End of main-container started in header.php-->
</div><!--/main-container-->

<div id="footer-container">
<div id="footer" class="grid_960 clearfix">	

    <div class="grid_4 footer-widgets alpha">
	<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer-1') ) ?>
	</div><!--End of footer-1 -->
    
	<div class="grid_4 footer-widgets">
	<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer-2') ) ?>
	</div><!--End of footer-2 -->

	<div class="grid_4 footer-widgets">
	<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer-3') ) ?>
	</div><!--End of footer-3 -->

	<div class="grid_4 footer-widgets omega">
	<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer-4') ) ?>
	</div><!--End of footer-4 -->

</div><!--/footer-->
<div class="clear"></div>
</div><!--/footer-container-->




<div id="copyright">
<p><strong><a href="<?php bloginfo('url'); ?>/"><?php bloginfo('name'); ?></a></strong> is produced by Joseph Swanson. <a href="<?php bloginfo('url'); ?>/feed/">Entries (RSS)</a> and <a href="<?php bloginfo('url'); ?>/comments/feed/">Comments (RSS)</a> | <strong>swiz</strong> by <strong>Joseph Swanson</strong></a> a product of <a href="http://swantron.com"><strong>swantron.com</strong></a></p>
</div><!--/copyright -->
<?php wp_footer(); ?>
<?php if ($footer_code=get_option('swiz_footer_scripts')) { echo stripslashes($footer_code);}?> 

<!-- <?php echo get_num_queries(); ?> queries. <?php timer_stop(1); ?> seconds. -->
</body>
</html>
