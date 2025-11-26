<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
<div>
<input type="text" value="<?php the_search_query(); ?>" name="s" id="s"/>
<input type="submit" id="searchsubmit" value="Search" />
<div style="clear:both; font-size: 0; height: 0;"></div>
</div>
</form>