<ul id="sidebar">
<?php if ( !function_exists('dynamic_sidebar')
	|| !dynamic_sidebar() ) : ?>
<style type="text/css">
@import url(http://www.google.com/cse/api/branding.css);
</style>
<div class="cse-branding-right" style="background-color:#000000;color:#FFFFFF">
  <div class="cse-branding-form">
    <form action="http://www.google.com/cse" id="cse-search-box" target="_blank">
      <div>
        <input type="hidden" name="cx" value="partner-pub-8152798060510703:cm6eryw0bom" />
        <input type="hidden" name="ie" value="ISO-8859-1" />
        <input type="text" name="q" size="31" />
        <input type="submit" name="sa" value="Search" />
      </div>
    </form>
  </div>
  <div class="cse-branding-logo">
    <img src="http://www.google.com/images/poweredby_transparent/poweredby_000000.gif" alt="Google" />
  </div>
  <div class="cse-branding-text">
    Custom Search
  </div>
</div>
<script type="text/javascript"><!--
google_ad_client = "pub-8152798060510703";
/* 120x600, created 8/7/09 */
google_ad_slot = "3377702930";
google_ad_width = 120;
google_ad_height = 600;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>


		<?php wp_list_pages('title_li=<h2>Pages</h2>'); ?>

		<li><h2>Archives</h2>
			<ul>
				<?php wp_get_archives('type=monthly'); ?>
			</ul>
		</li>

		<li><h2>Categories</h2>
			<ul>
				<?php wp_list_cats('sort_column=name&optioncount=1&hierarchical=0'); ?>
			</ul>
		</li>
			
		<li><h2>Search</h2>
			<?php include (TEMPLATEPATH . '/searchform.php'); ?>
		</li>
		

<script type="text/javascript"><!--
google_ad_client = "pub-8152798060510703";
/* 120x600, created 8/7/09 */
google_ad_slot = "3377702930";
google_ad_width = 120;
google_ad_height = 600;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>

<!-- Begin Blogroll list -->
<li><h2>Links</h2>
                <div class="menuheader"><div></div><img id="br_img" src="<?php bloginfo('stylesheet_directory');?>/img/up_light.gif" alt=""/></a></div>
                <ul id='br_list'>
                <?php get_links(-1,'<li>','</li>',' ',false,'id',false,false,-1,false,true);; ?>

                </ul>
</li>
<!-- End Blogroll list -->



		<li><h2>Meta</h2>
			<ul>
				<?php wp_register(); ?>
				<li><?php wp_loginout(); ?></li>
				<li><a href="http://validator.w3.org/check/referer" title="This page validates as XHTML 1.0 Transitional">Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr></a></li>
				<li><a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a></li>
				<li><a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform.">WordPress</a></li>
				<?php wp_meta(); ?>
			</ul>
		</li>
<script type="text/javascript"><!--
google_ad_client = "pub-8152798060510703";
/* 728x90, created 7/15/09 */
google_ad_slot = "2781511449";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
		
<?php endif; ?>
</ul>


