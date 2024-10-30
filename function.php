<?php 
/*
Plugin Name: Bytecoder news Ticker
Plugin URI: http://bytecoder.info
Description: This plugin will enable post as a ticker in your wordpress theme. You can embed post ticker using shortcode in everywhere you want, 
even in theme files. 
Author: Sayfur Rahman
Version: 1.0
Author URI: http://sayfur-rahman.info
*/

function news_defalut_jquery() {
	wp_enqueue_script('jquery');
}
add_action('init', 'news_defalut_jquery');

function news_main_script() {
   wp_enqueue_script( 'news-js', plugins_url( '/js/jquery.easy-ticker.min.js', __FILE__ ), array('jquery'), 1.0, false);
   wp_enqueue_style( 'news-css', plugins_url( '/css/style.css', __FILE__ ));
}

add_action('init','news_main_script');

function news_ticker_shortcode($atts){
	extract( shortcode_atts( array(
		'id' => 'post',
		'category' => '',
		'count' => '-1',
		'show' => '1',
		'color' => '#000',
		'text' => 'Latest News',
		'transition' => '2000',
		'mousehover' => '1',
		'category_slug' => 'category_ID',
	), $atts, 'projects' ) );
	
    $q = new WP_Query(
        array('posts_per_page' => $count, 'post_type' => 'post', $category_slug => $category)
        );		
		
		
	$list = '<script type="text/javascript" language="javascript">
					jQuery(document).ready(function(){

					jQuery("#newsticker'.$id.'").easyTicker({
						visible: '.$show.',
						interval: '.$transition.',
						mousePause: '.$mousehover.',
					});
				});
			</script>
				<div class="post_text">
				<strong style="background-color:'.$color.'">'.$text.'</strong>
				</div>
				<div id="newsticker'.$id.'" class="news-ticker">
				<ul>';
	while($q->have_posts()) : $q->the_post();
		$idd = get_the_ID();
		$list.= '
			<li>
				<a href="'.get_permalink().'">'.get_the_title().'</a>
			</li>
		';        
	endwhile;
	$list.= '</ul></div>';
	wp_reset_query();
	return $list;
}

add_shortcode('news_ticker', 'news_ticker_shortcode');	


?>