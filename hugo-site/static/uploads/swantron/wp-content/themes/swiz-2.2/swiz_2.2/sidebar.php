<div id="sb-container">
<div class="wide-sidebar">

<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('wrt') ): else : ?>
	<div id="categories-2" class="block widget widget_categories">
		<h4 class="widget-title">Categories</h4>
		<ul>
			<?php wp_list_categories('show_count=0&use_desc_for_title=1&hierarchical=0&title_li=' . __('') . ''); ?>
		</ul>
	</div><?php endif; ?>
</div> 

<div id="sb1"><?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('nrl') )?></div>
<div id="sb2"><?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('nrr') )?></div>

<div class="clear"></div>
<div class="wide-sidebar"><?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('wrb') )?></div>

</div>