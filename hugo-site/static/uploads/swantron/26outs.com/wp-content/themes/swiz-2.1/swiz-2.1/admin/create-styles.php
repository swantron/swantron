<?php
function create_style_sheet(){
	if($_POST['colour-options']=="update"){
		define('CB', ADMIN . '/css-base');

		$final=U_DIR. '/swiz_custom/custom-style.css';//This is where our style sheet will be saved.
		$fp=fopen($final,'w');
		
		//Includes the CSS that controls the layout.
		switch (get_option('swiz_layout')) {
    	case "LeftSidebar":
        		$base=CB . '/left-sb.css';
        		break;
    	case "RightSidebar":
        		$base=CB . '/right-sb.css';
        		break;
		default:
				$base=CB . '/right-sb.css';
		}
		$filehandle=fopen($base,'r');	//Reads the necessary file into fh.
		$data.= fread($filehandle, filesize($base)); //Writes the data in fh to data.
		
		//Includes the style sheet that controls header width.
		switch (get_option('swiz_header')) {
    	case "full":
        		$base=CB . '/nav-full.css';
        		break;
    	case "960":
        		$base=CB . '/nav-960.css';
        		break;
		default:
				$base=CB . '/nav-full.css';
		}
		$filehandle=fopen($base,'r');	
		$data.= fread($filehandle, filesize($base));
		
		//Now we work on adding the colours to our layout.
		if(get_option('swiz_customcolors_enable') != "true"){
		/* If custom colours are not enabled then there are 2 caes to consider,
		
				1.Full Width Header.
				2.960px Wide Header.
				
		   We will use a SWITCH for that. Yeah too many switches, but they make the 
		   code easy to follow.
		*/
			switch (get_option('swiz_header')) {
    		case "full":
        		$base=CB . '/nav-full-colors.css';
        		break;
    		case "960":
        		$base=CB . '/nav-960-colors.css';
        		break;
			}
			$filehandle=fopen($base,'r');	
			$data.= fread($filehandle, filesize($base));
		}
	
		else{
			
			$data.='body{background:#'.get_option('swiz_body_bg').' url("'.get_option('swiz_body_bg_image').'") '.get_option('swiz_body_bg_image_repeat').';color:#'.get_option('swiz_body').';}'."\n";
			
			$data.='#main-container{background:#'.get_option('swiz_page_bg').';}'."\n";
			$data.='#popular-posts-home{background:#'.get_option('swiz_popular_bg').';}'."\n";
			$data.='a{color:#'.get_option('swiz_link').';}'."\n";
			$data.='a:hover{color:#'.get_option('swiz_link_hover').';}'."\n";
			
			$data.='#header-container{background:#'.get_option('swiz_header_bg').' url("'.get_option('swiz_header_bg_image').'") '.get_option('swiz_header_bg_image_repeat').';}'."\n";
			
			$data.='h2.blogname a{color:#'.get_option('swiz_blogname').';}'."\n";
			$data.='h2.blog-title{color:#'.get_option('swiz_blogtagline').';}'."\n";
			$data.='#nav-ad-container{background:#'.get_option('swiz_navad_bg').';}'."\n";
			$data.='#nav1-container,#nav2-container{background:#'.get_option('swiz_nav_bg').';}'."\n";
			$data.='#nav1-container,#nav2-container{border-color:#'.get_option('swiz_nav_border').';}'."\n";
			$data.='ul.navigation li a,.navigation ul{background:#'.get_option('swiz_nav_link_bg').'}'."\n";
			$data.='.navigation li a,#rss-links,#rss-links a,ul.navigation li:hover a{color:#'.get_option('swiz_nav_link').'}'."\n";
			$data.='ul.navigation li a:hover,ul.navigation li:hover a:hover{background:#'.get_option('swiz_nav_link_hover_bg').';color:#'.get_option('swiz_nav_link_hover').'}'."\n";
	
	
			//Slider Colours
			$data.='#jFlowSlide{background:#'.get_option('swiz_slider_bg').'}'."\n";
			$data.='.slide-details h2.title a{color:#'.get_option('swiz_slider_post_title_color').'}'."\n";
			$data.='.slide-details {color:#'.get_option('swiz_slider_text_color').'}'."\n";
			$data.='#myController{background:#'.get_option('swiz_slider_nav_bg').'}'."\n"; 
			$data.='#myController span{color:#'.get_option('swiz_slider_nav_text_color').';}'."\n";
			$data.='#myController span:hover,#myController span.jFlowSelected{background:#'.get_option('swiz_slider_nav_text_hover_bg').';}'."\n";
			
			//Tabbed interface colours
			$data.='.ui-tabs{background:#'.get_option('swiz_tabber_bg').';border-color:#'.get_option('swiz_tabber_border').';}'."\n";
			$data.='.tabmenu{background:#'.get_option('swiz_tabber_nav_bg').'}'."\n";
			$data.='.ui-tabs .ui-tabs-nav li a{color:#'.get_option('swiz_tabber_nav_color').'}'."\n";
			$data.='.ui-tabs .ui-tabs-nav li a:hover,.ui-tabs .ui-tabs-nav li.ui-tabs-selected{background:#'.get_option('swiz_tabber_bg').';color:#'.get_option('swiz_tabber_nav_hover_color').'}'."\n";
			
			$data.='.ui-tabs .ui-tabs-nav li.ui-tabs-selected a, .ui-tabs .ui-tabs-nav li.ui-state-disabled a, .ui-tabs .ui-tabs-nav li.ui-state-processing a{color:#'.get_option('swiz_tabber_nav_hover_color').'}'."\n";
			
			$data.='.tab-content{color:#'.get_option('swiz_tabber_color').'}'."\n";
			$data.='.tab-content a{color:#'.get_option('swiz_tabber_link_color').'}'."\n";
			$data.='.tab-content a:hover{color:#'.get_option('swiz_tabber_link_hover_color').'}'."\n";
			
			//Sidebar colours
		 	$data.='h4.widget-title,h4.widget-title a{background:#'.get_option('swiz_sb_widget_title_bg').';color:#'.get_option('swiz_sb_widget_title_color').'}'."\n";
			$data.='.widget{background:#'.get_option('swiz_sb_widget_bg').';color:#'.get_option('swiz_sb_widget_color').';border-color:#'.get_option('swiz_sb_widget_title_bg').';}'."\n";
			$data.='.widget a{color:#'.get_option('swiz_sb_widget_link').';}'."\n";
			$data.='.widget a:hover{color:#'.get_option('swiz_sb_widget_link_hover').';}'."\n";
			$data.='.widget ul li:hover{background:#'.get_option('swiz_sb_widget_list_hover_bg').';}'."\n";
			$data.='.widget ul li{border-color:#'.get_option('swiz_sb_widget_list_border_color').';}'."\n";

			//ADS widget
			$data.='img.banner125{background:#'.get_option('swiz_sb_widget_title_bg').';}'."\n";
			
			//Subscribe Widget
			$data.='.widget_subscribebox{border-color:#'.get_option('swiz_subscribebox_border').';background:#'.get_option('swiz_subscribebox_bg').' url("'.get_bloginfo('template_url').'/images/subscribe-bg.png") no-repeat 100% 0;color:#'.get_option('swiz_subscribebox').';}'."\n";
			

			//Footer colours
			$data.='#footer{background:#'.get_option('swiz_footer_bg').';}'."\n";
		 	$data.='#footer h4.widget-title,#footer h4.widget-title a{background:#'.get_option('swiz_f_widget_title_bg').';color:#'.get_option('swiz_f_widget_title_color').'}'."\n";
			$data.='#footer .widget{background:#'.get_option('swiz_f_widget_bg').';color:#'.get_option('swiz_f_widget_color').';border-color:#'.get_option('swiz_f_widget_title_bg').';}'."\n";
			$data.='#footer .widget a{color:#'.get_option('swiz_f_widget_link').';}'."\n";
			$data.='#footer .widget a:hover{color:#'.get_option('swiz_f_widget_link_hover').';}'."\n";
			$data.='#footer .widget ul li{background:none;}'."\n";
			$data.='#footer .widget ul li:hover{background:#'.get_option('swiz_f_widget_list_hover').';}'."\n";
			$data.='#footer .widget ul li{border-color:#'.get_option('swiz_f_widget_list_border_color').';}'."\n";
			
			//ADS widget
			$data.='#footer img.banner125{background:none;}'."\n";
			
			//Single Post colours
			$data.='.post-title a{color:#'.get_option('swiz_post_title').';}'."\n";
			$data.='.post-title a:hover{color:#'.get_option('swiz_post_title_hover').';}'."\n";
			$data.='.entry blockquote{background:#'.get_option('swiz_blockquote_bg').';border-color:#'.get_option('swiz_blockquote_border').';color:#'.get_option('swiz_blockquote').';}'."\n";
			$data.='.post-meta{color:#'.get_option('swiz_post_meta').';}'."\n";
			
			//Page Nav styling, Colours Inherited from navigation bar.
			$data.='.wp-pagenavi a,
					.wp-pagenavi .current,
					.wp-pagenavi .pages{background:#'.get_option('swiz_nav_link_bg').';color:#'.get_option('swiz_nav_link').'}'."\n";
			
			
			//Comments Template Colours
			$data.='li.comment{background:#'.get_option('swiz_comment_bg').';border-color:#'.get_option('swiz_comment_border').';color:#'.get_option('swiz_comment').';}'."\n";
			$data.='li.comment .avatar{background:#'.get_option('swiz_comment_border').';}'."\n";
			
				//Author Comment
			$data.='li.comment .bypostauthor{background:#'.get_option('swiz_author_comment_bg').';border-color:#'.get_option('swiz_author_comment_border').'}'."\n";
				//reply button
			$data.='div.reply a,
			#commentform #submit,
			a#cancel-comment-reply-link,
			span.post-a-comment a{background:#'.get_option('swiz_reply_button_bg').';color:#'.get_option('swiz_reply_button').';}'."\n";
			$data.='div.reply a:hover,
			#commentform #submit:hover{background:#'.get_option('swiz_reply_button_hover_bg').';}'."\n";
			
			//Comment form colors, Inherited from the comment colours.
			$data.='h3#comment-form-title{background:#'.get_option('swiz_comment_border').';color:#'.get_option('swiz_comment').';}'."\n";
			$data.='#commentform{background:#'.get_option('swiz_comment_bg').';color:#'.get_option('swiz_comment').';}'."\n";
			
			
			
			
			//Author Info and related posts box.
			$data.='#rp-wrapper{background:#'.get_option('swiz_rp_bg').';color:#'.get_option('swiz_rp').';}'."\n";
			$data.='#rp-wrapper a{color:#'.get_option('swiz_rp_link').';}'."\n";
			$data.='#rp-wrapper a:hover{color:#'.get_option('swiz_rp_link_hover').';}'."\n";
			$data.='#author-info,.post-nav{background:#'.get_option('swiz_rp_author_bg').';color:#'.get_option('swiz_rp').';}'."\n";
			
			
			//MagazineBox Colours
			$data.='.mag-box{border-color:#'.get_option('swiz_magbox_border').';}'."\n";
			$data.='.mag-meta{background:#'.get_option('swiz_magmeta_bg').';}'."\n";
			$data.='.mag-meta a{color:#'.get_option('swiz_mag_fullstory').';}'."\n";
			$data.='a.read-more{background:#'.get_option('swiz_mag_fullstory_bg').';}'."\n";
			$data.='a.read-more:hover{background:#'.get_option('swiz_mag_fullstory_hover_bg').';}'."\n";
		}
			//Fonts	
			//Primary (body)
			$data.='body{font-family:'.get_option('swiz_fontfamily').';font-size:'.get_option('swiz_fontsize').'}'."\n";

			//SideBar
			$data.='.widget{font-size:'.get_option('swiz_sb_fontsize').'}'."\n";
			//Footer
			$data.='#footer .widget{font-size:'.get_option('swiz_footer_fontsize').'}'."\n";
			
			//Rounded Corners
			if(get_option('swiz_rc_nav_disable')=="true")
			$data.=	'#nav1-container,#nav2-container {	-moz-border-radius:0;-webkit-border-radius: 0;}';
			
			if(get_option('swiz_rc_sb_disable')=="true")
			$data.=	'.widget{	-moz-border-radius:0;-webkit-border-radius: 0;}';
			
			//Background Images
			if(get_option('swiz_body_bg_image'))
			$data.='body{background: url("'.get_option('swiz_body_bg_image').'") '.get_option('swiz_body_bg_image_repeat').';}'."\n";
			
			if(get_option('swiz_header_bg_image'))
			$data.='#header-container{background: url("'.get_option('swiz_header_bg_image').'")'.get_option('swiz_header_bg_image_repeat').';}'."\n";
			
			//Custom CSS
			if(get_option('swiz_customCSS_enable')=="true"&&get_option('swiz_customCSS'))
			$data.=get_option('swiz_customCSS')."\n";
			
fwrite($fp,$data);
			
}}
?>