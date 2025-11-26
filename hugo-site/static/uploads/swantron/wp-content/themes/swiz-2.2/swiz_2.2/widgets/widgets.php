<?php
//================================ Home Page Only Text Widget ============
class HomePageOnlyText extends WP_Widget {
    /** constructor */
    function HomePageOnlyText() {
        parent::WP_Widget(false, $name = 'SWIZ Home page only text');	
		

    }
	/** @see WP_Widget::widget */
    function widget($args, $instance) {	
	if(is_home()):
        extract( $args );
		$text= $instance['text'];
       	$title = apply_filters('widget_title', $instance['title']);
		echo $before_widget; if ( $title )
        echo $before_title . $title . $after_title; 
            
        
		echo $text;
     	
		echo $after_widget;
		endif;
        
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
        return $new_instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {				
		$text= esc_attr($instance['text']);
       	$title = apply_filters('widget_title', $instance['title']);
        ?>
            <p>
	 <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> </label>
     <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
                 <br />
            <textarea class="widefat" rows="16" cols="20"  name="<?php echo $this->get_field_name('text'); ?>" id="<?php echo $this->get_field_id('text'); ?>" style="margin-top:.5em;" ><?php echo $text; ?>
            </textarea>
            </p>
        <?php     }}

//================================ SUBSCRIBE WIDGET ======================

class SubscribeBox extends WP_Widget {
    /** constructor */
    function SubscribeBox() {
        parent::WP_Widget(false, $name = 'SWIZ E-mail subscription');	
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {		
        extract( $args );
		$feedId=get_option('swiz_feedburner_id');
        ?>
              <?php echo $before_widget; ?>
            <div class="subscribe-box">
			<a href="http://feeds.feedburner.com/<?php echo $feedId ?>" title="Subscribe to our RSS feed">
             <img src="http://feeds.feedburner.com/~fc/<?php echo $feedId ?>?bg=<?php echo get_option('swiz_chicklet_bg');?>&amp;fg=<?php echo get_option('swiz_chicklet');?>&amp;anim=0" class="alignright" alt="Feedburner counter"  style="margin:.3em 0 .2em 0"/></a>
			<h3 style="margin:0">Subscribe</h3>
    <form action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $feedId ?>', 'popupwindow', 'scrollbars=yes, width=550,height=520 ');return true">
            <input style="padding: 0.2em 0pt; width: 190px;" name="email" value="Enter your e-mail address" onfocus="if (this.value == 'Enter your e-mail address') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Enter your e-mail address';}" type="text" />
            <input value="<?php echo $feedId ?>" name="uri" type="hidden" />
            <input name="loc" value="en_US" type="hidden" />
            <input value="Subscribe" type="submit" class="subscribe-button" />
            </form>
        	<div class="clear"></div>
			</div>
              <?php echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
        return $new_instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {				
		
        ?>
            <p>
	<?php if(!get_option('swiz_feedburner_id')):?>
		<span style="color:#F00">You should enter your Feedburner ID in the SWIZ Options Page(General Settings) for this widget to fucntion properly.</span><br />
	<?php endif;?>
    	You can customize the colors of this widget and of the Feedburner chicklet in the SWIZ Color options page.       

            </p>
        <?php     }}?>
<?php 
// =============================== Tabs Widget ======================================

class swizTabs extends WP_Widget {
    /** constructor */
    function swizTabs() {
        parent::WP_Widget(false, $name = 'SWIZ Tabs');	
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {		
        extract( $args );
        
        ?>
               
                 <?php include(INCLUDES . '/tabs.php');?>
               
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
        return $new_instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {				
        
        ?>
         <p>You can customize the colors of this widget in the SWIZ Colors settings page.</p>    
        <?php 
    }

} // class swizTabs


// ======================================= AD's Widget =======================================
class swizAdsWidget extends WP_Widget {
    /** constructor */
    function swizAdsWidget() {
        parent::WP_Widget(false, $name = 'swiz 125*125 ads');	
    }
    /** @see WP_Widget::widget */
    function widget($args, $instance) {		
        extract( $args );
        $title = esc_attr($instance['title']);
		$one=esc_attr($instance['one']);
		$two=esc_attr($instance['two']);
		$three=esc_attr($instance['three']);
		$four=esc_attr($instance['four']);
		echo $before_widget; if ( $title )
        echo $before_title . $title . $after_title; 
            


        $title = apply_filters('widget_title', $instance['title']);
		ads_widget($one,$two,$three,$four);
     	
		echo $after_widget;
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
        return $new_instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {				
        $title = esc_attr($instance['title']);
		$one=esc_attr($instance['one']);
		$two=esc_attr($instance['two']);
		$three=esc_attr($instance['three']);
		$four=esc_attr($instance['four']);
		?>
        
		            <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
            
			Tick the banners which you want to show in this widget. The banners themselves can be defined in the SWIZ Ad Management settings page.<br />
            
            <label for="<?php echo $this->get_field_id('one'); ?>">
            <input type="checkbox" name="<?php echo $this->get_field_name('one'); ?>" value="true" <?php if($one=="true") echo "checked" ?> />
            <?php _e('First'); ?>
            
            </label>
            
            <label for="<?php echo $this->get_field_id('two'); ?>">
            <input type="checkbox" name="<?php echo $this->get_field_name('two'); ?>" value="true" <?php if($two=="true") echo "checked" ?> />
            <?php _e('Second'); ?>
            
            </label><br />
            
            <label for="<?php echo $this->get_field_id('three'); ?>">
            <input type="checkbox" name="<?php echo $this->get_field_name('three'); ?>" value="true" <?php if($three=="true") echo "checked" ?> />
            <?php _e('Third'); ?>
            
            </label>
            
            <label for="<?php echo $this->get_field_id('four'); ?>">
            <input type="checkbox" name="<?php echo $this->get_field_name('four'); ?>" value="true" <?php if($four=="true") echo "checked" ?> />
            <?php _e('Fourth'); ?>
            
            </label>
            

            </p>
			<?php
    }

}  

// =============================== Popular posts Widget ======================================
class swizPopularPosts extends WP_Widget {
    /** constructor */
    function swizPopularPosts() {
        parent::WP_Widget(false, $name = 'SWIZ Popular Posts');	
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {		
        extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		$number = esc_attr($instance['number']);
		$thumb_enable=esc_attr($instance['thumb_enable']);
		$excerpt_enable=esc_attr($instance['excerpt_enable']);
		echo $before_widget; if ( $title )
        echo $before_title . $title . $after_title; 
            


        $title = apply_filters('widget_title', $instance['title']);
		popular_widget($number,$thumb_enable,$excerpt_enable);
     	
		echo $after_widget;
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
        return $new_instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {				
        $title = esc_attr($instance['title']);
		$number = esc_attr($instance['number']);
		$thumb_enable=esc_attr($instance['thumb_enable']);
		$excerpt_enable=esc_attr($instance['excerpt_enable']);
		?>
        
		            <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
            
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of popular posts to show:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" /></label>
            
            <label for="<?php echo $this->get_field_id('thumb_enable'); ?>">
            <input type="checkbox" name="<?php echo $this->get_field_name('thumb_enable'); ?>" value="true" <?php if($thumb_enable=="true") echo "checked" ?> />
            <?php _e('Show thumbnails'); ?>
            
            </label><br />
            
             <label for="<?php echo $this->get_field_id('excerpt_enable'); ?>">
            <input type="checkbox" name="<?php echo $this->get_field_name('excerpt_enable'); ?>" value="true" 
            <?php if($excerpt_enable=="true") echo "checked" ?>
             />
            <?php _e('Show post excerpts on hover'); ?>
            </label>
            </p>
			<?php
    }

}  
?>