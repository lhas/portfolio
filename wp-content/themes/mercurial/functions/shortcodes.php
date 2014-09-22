<?php

/*-----------------------------------------------------------------------------------

	Theme Shortcodes

-----------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------*/
/*	Text Type Shortcodes
/*-----------------------------------------------------------------------------------*/
function coll_text_type($atts, $content = null)
{
    extract(shortcode_atts(array(
        'type' => 'one',
        'max_font_size' => '',
        'min_font_size' => ''
    ), $atts));

    $data = '';

    if (!empty($max_font_size)){
        $type .= ' resizable';
        $data = 'data-coll-font-size=\'{"max":' . $max_font_size . ',"min":'. $min_font_size .'}\'';
    }

    return '<div class="text type ' . $type . '" '. $data .'><span class="text">' . do_shortcode($content) . '</span></div>';
}

add_shortcode('text_type', 'coll_text_type');

/*-----------------------------------------------------------------------------------*/
/*	Smart Padding Shortcode
/*-----------------------------------------------------------------------------------*/
function coll_smart_padding($atts, $content = null)
{
    extract(shortcode_atts(array(
        'min' => '0',
        'max' => '20'
    ), $atts));

    return '<div class="smart-padding" data-min="' . $min . '" data-max="' . $max . '"></div>';
}

add_shortcode('smart_padding', 'coll_smart_padding');

/*-----------------------------------------------------------------------------------*/
/*	Portfolio Shortcode
/*-----------------------------------------------------------------------------------*/
function coll_portfolio($atts, $content = null)
{
    extract(shortcode_atts(array(
        'columns' => '3'
    ), $atts));

    $output = '';

    // start portfolio
    $output .= '<div class="portfolio">';
    // start filter
    $output .= '<ul class="filter">';
    $taxonomy = 'port-cat';
    $tax_terms = get_terms($taxonomy, 'orderby=none');
    // first item (all)
    $output .= '<li><a href="#" class="button link" data-filter="*">' . __('Todos', 'framework') . '</a></li>';
    foreach ($tax_terms as $tax_term) {
        $output .= '<li ><a href="#" class="button link"  data-filter=".' . $tax_term->slug . '">' . $tax_term->name . '</a></li>';
    }
    $output .= '</ul>'; // end filter

    // start items
    $output .= '<div class="items clearfix">';
    $loop = new WP_Query(array('post_type' => 'portfolio', 'posts_per_page' => -1));
    while ($loop->have_posts()) : $loop->the_post();
        global $post;
        // get thumbnail
        $thumb = get_post_meta(get_the_ID(), 'thumbnail', true);
        $cols = 'coll-' . $columns;
        // build
        $output .= "<article id='" . $post->post_name . "' class='" . join(" ", get_post_class($cols)) . "'>";
        $output .= '<div class="wrapper">';
        $output .= '<a class="thumb" href="' . get_post_meta(get_the_ID(), 'url', true) . '" target="_blank">';
        $output .= '<span class="x-preloader"></span>';
        $output .= '<img src="' . $thumb . '" alt=""/>';
        $output .= '</a>';
        $output .= '<div class="info">';
        $output .= '<a href="' . get_post_meta(get_the_ID(), 'url', true) . '" target="_blank">';
        $output .= '<h3 class="title">' . get_the_title(get_the_ID()) . '</h3>';
        $output .= '<span class="text">' . get_the_content() . '</span>';
        $output .= '</a>';
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</article>';
    endwhile;
    wp_reset_postdata();
    $output .= '</div>'; // end items

    $output .= '</div>'; // end portfolio
    return $output;
}

add_shortcode('portfolio', 'coll_portfolio');
/*-----------------------------------------------------------------------------------*/
/*	Info Columns Shortcode
/*-----------------------------------------------------------------------------------*/
function coll_infocolumns($atts, $content = null)
{
    extract(shortcode_atts(array(
        'id' => '',
        'columns' => '4'
    ), $atts));

    $term = get_term($id, 'ic-cat');
    $cols = 'coll-' . $columns;

    $output = '';

    // start portfolio
    $output .= '<div class="info-columns">';
    // start items
    $output .= '<div class="items clearfix">';
    $Qargs = array(
        'post_type' => 'infocolumns',
        'tax_query' => array(
            array(
                'taxonomy' => 'ic-cat', //(string) - Taxonomy.
                'field' => 'slug', //(string) - Select taxonomy term by ('id' or 'slug')
                'terms' => $term->slug, //(int/string/array) - Taxonomy term(s).
                'include_children' => true, //(bool) - Whether or not to include children for hierarchical taxonomies. Defaults to true.
                'operator' => 'IN' //(string) - Operator to test. Possible values are 'IN', 'NOT IN', 'AND'.
            )
        ),
        'posts_per_page' => -1
    );
    $loop = new WP_Query($Qargs);
    while ($loop->have_posts()) : $loop->the_post();
        global $post;
        // get thumbnail
        $show_title = get_post_meta(get_the_ID(), 'coll_ic_title', true);
        $show_text = get_post_meta(get_the_ID(), 'coll_ic_text', true);
        $img = get_post_meta(get_the_ID(), 'coll_ic_image', true);
        $link_url = get_post_meta(get_the_ID(), 'coll_ic_link_url', true);
        $link_text = get_post_meta(get_the_ID(), 'coll_ic_link_text', true);

        // build
        $output .= "<article id='" . $post->post_name . "' class='" . join(" ", get_post_class($cols)) . "'>";
        $output .= '<div class="wrapper">';
        if (!empty($img)) $output .= '<img class="thumb"src="' . $img . '" alt=""/>';
        if ($show_title) $output .= '<div class="title"> <h2 class="text  border bottom centered small thin">' . get_the_title() . '</h2></div>';
        if ($show_text) $output .= '<div class="description">' . coll_get_the_content(get_the_ID()) . '</div>';
        if (!empty($link_url)) $output .= '<a class="link" href="' . $link_url . '">' . $link_text . '</a>';
        $output .= '</div>';
        $output .= '</article>';
    endwhile;
    wp_reset_postdata();
    $output .= '</div>'; // end items

    $output .= '</div>'; // end portfolio
    return $output;
}

add_shortcode('infocolumns', 'coll_infocolumns');

/*-----------------------------------------------------------------------------------*/
/*	Team Shortcode
/*-----------------------------------------------------------------------------------*/
function coll_team($atts, $content = null)
{
    extract(shortcode_atts(array(
        'id' => '',
        'columns' => '4'
    ), $atts));

    $term = get_term($id, 'team-block');
    $cols = 'coll-' . $columns;

    $output = '';

    // start portfolio
    $output .= '<div class="team">';
    // start items
    $output .= '<div class="items clearfix">';
    $Qargs = array(
        'post_type' => 'team',
        'tax_query' => array(
            array(
                'taxonomy' => 'team-block', //(string) - Taxonomy.
                'field' => 'slug', //(string) - Select taxonomy term by ('id' or 'slug')
                'terms' => $term->slug, //(int/string/array) - Taxonomy term(s).
                'include_children' => true, //(bool) - Whether or not to include children for hierarchical taxonomies. Defaults to true.
                'operator' => 'IN' //(string) - Operator to test. Possible values are 'IN', 'NOT IN', 'AND'.
            )
        ),
        'posts_per_page' => -1
    );
    $loop = new WP_Query($Qargs);
    while ($loop->have_posts()) : $loop->the_post();
        global $post;
        // get thumbnail
        $img = get_post_meta(get_the_ID(), 'coll_member_image', true);
        $position = get_post_meta(get_the_ID(), 'coll_member_position', true);

        // build
        $output .= "<article id='" . $post->post_name . "' class='" . join(" ", get_post_class($cols)) . "'>";
        $output .= '<div class="wrapper">';
        if (!empty($img)) $output .= '<img class="thumb"src="' . $img . '" alt=""/>';
        $output .= '<div class="title"> <h2 class="text  border bottom centered small thin">' . get_the_title() . '</h2></div>';
        $output .= '<div class="position">' . $position . '</div>';
        $output .= '<div class="description">' . coll_get_the_content(get_the_ID()) . '</div>';
        $output .= '</div>';
        $output .= '</article>';
    endwhile;
    wp_reset_postdata();
    $output .= '</div>'; // end items

    $output .= '</div>'; // end portfolio
    return $output;
}

add_shortcode('team', 'coll_team');

/*-----------------------------------------------------------------------------------*/
/*	Skill Shortcode
/*-----------------------------------------------------------------------------------*/
function coll_skill($atts, $content = null)
{
    extract(shortcode_atts(array(
        'name' => 'skill',
        'percentage' => '50',
        'name_color' => '',
        'percentage_color' => '',
        'percentage_bar_color' => '',
        'bg_bar_color' => ''
    ), $atts));

    $color1 = '';
    $color2 = '';
    $color3 = '';
    $color4 = '';

    if ((!empty($name_color))) $color1 = 'style="color:' . $name_color . ';"';
    if ((!empty($percentage_color))) $color2 = 'style="color:' . $percentage_color . ';"';
    if ((!empty($percentage_bar_color))) $color3 = 'background-color:' . $percentage_bar_color . ';';
    if ((!empty($bg_bar_color))) $color4 = 'style="background-color:' . $bg_bar_color . ';"';

    $output = '';

    $output .= '<div class="skill">';
    $output .= '<div class="title"><h3 class="text"  ' . $color1 . '>' . $name . '</h3></div>';
    $output .= '<div class="bar" ' . $color4 . '>';
    $output .= '<div class="percent" style="width:' . $percentage . '%;' . $color3 . '"><span class="number" ' . $color2 . '>' . $percentage . '%</span></div>';
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

add_shortcode('skill', 'coll_skill');


/*-----------------------------------------------------------------------------------*/
/*	Prices Shortcode
/*-----------------------------------------------------------------------------------*/
function coll_prices($atts, $content = null)
{
    extract(shortcode_atts(array(
        'id' => '',
        'columns' => '4'
    ), $atts));

    $term = get_term($id, 'price-table');
    $cols = 'coll-' . $columns;

    $output = '';

    // start portfolio
    $output .= '<div class="price-table">';
    // start items
    $output .= '<div class="items clearfix">';
    $Qargs = array(
        'post_type' => 'pricetables',
        'tax_query' => array(
            array(
                'taxonomy' => 'price-table', //(string) - Taxonomy.
                'field' => 'slug', //(string) - Select taxonomy term by ('id' or 'slug')
                'terms' => $term->slug, //(int/string/array) - Taxonomy term(s).
                'include_children' => true, //(bool) - Whether or not to include children for hierarchical taxonomies. Defaults to true.
                'operator' => 'IN' //(string) - Operator to test. Possible values are 'IN', 'NOT IN', 'AND'.
            )
        ),
        'posts_per_page' => -1
    );
    $loop = new WP_Query($Qargs);
    while ($loop->have_posts()) : $loop->the_post();
        global $post;
        // get thumbnail
        $bgcolor = get_post_meta(get_the_ID(), 'coll_background_color', true);
        $price = get_post_meta(get_the_ID(), 'coll_price', true);
        $link_url = get_post_meta(get_the_ID(), 'coll_link_url', true);
        $link_text = get_post_meta(get_the_ID(), 'coll_link_text', true);
        $stand_out = get_post_meta(get_the_ID(), 'coll_stand_out', true);

        // build
        $output .= "<div id='" . $post->post_name . "' class='" . join(" ", get_post_class($cols)) . "'>";
        $output .= '<div class="wrapper ' . $stand_out . '" style="background-color:' . $bgcolor . ';">';
        $output .= '<div class="title"><h3 class="text">' . get_the_title() . '</h3></div>';
        $output .= '<div class="price"><span class="text">' . $price . '</span></div>';
        $output .= '<div class="description">' . coll_get_the_content(get_the_ID()) . '</div>';
        if (!empty($link_url)) $output .= '<a class="link" href="' . $link_url . '">' . $link_text . '</a>';


        $output .= '</div>';
        $output .= '</div>';
    endwhile;
    wp_reset_postdata();
    $output .= '</div>'; // end items

    $output .= '</div>'; // end portfolio
    return $output;
}

add_shortcode('pricetable', 'coll_prices');


/*-----------------------------------------------------------------------------------*/
/*	Clients Shortcode
/*-----------------------------------------------------------------------------------*/
function coll_clients($atts, $content = null)
{
    extract(shortcode_atts(array(
        'columns' => '4'
    ), $atts));

    $cols = 'coll-' . $columns;

    $output = '';

    // start portfolio
    $output .= '<div class="clients">';
    // start items
    $output .= '<div class="items clearfix">';
    $loop = new WP_Query(array('post_type' => 'clients', 'posts_per_page' => -1));
    while ($loop->have_posts()) : $loop->the_post();
        global $post;
        // get thumbnail
        $thumb = get_post_meta(get_the_ID(), 'coll_image', true);
        $link_url = get_post_meta(get_the_ID(), 'coll_link_url', true);
        // build
        $output .= "<div class='" . join(" ", get_post_class($cols)) . "'>";
        $output .= '<div class="wrapper">';
        if (!empty($link_url)) {
            $output .= '<a class="thumb" href="' . $link_url . '"><img src="' . $thumb . '" alt=""/></a>';
        } else {
            $output .= '<img src="' . $thumb . '" alt=""/>';
        }


        $output .= '</div>';
        $output .= '</div>';
    endwhile;
    wp_reset_postdata();
    $output .= '</div>'; // end items

    $output .= '</div>'; // end portfolio
    return $output;
}

add_shortcode('clients', 'coll_clients');

/*-----------------------------------------------------------------------------------*/
/*	Sliders Shortcode
/*-----------------------------------------------------------------------------------*/
function coll_sliders($atts, $content = null)
{
    extract(shortcode_atts(array(
        'id' => '',
        'background' => '',
        'arrows' => '',
        'bullets' => '',
        'captions' => ''
    ), $atts));


    $rnd = rand();
    $term = get_term($id, 'slider');
    $showBg = $background ? '' : ' no-bg';
    $showArrows = $arrows ? '' : ' no-arrows';
    $showBullets = $bullets ? '' : ' no-bullets';
    $showCaptions = $captions ? '' : ' no-captions';

    $output = '';

    // start portfolio
    $output .= '<div id="slider-' . $rnd . '" class="flexslider' . $showBg . $showArrows . $showBullets . $showCaptions . '">';
    // js
    $output .= '<script type="text/javascript" charset="utf-8">
                jQuery(document).ready(function ($) {
                    $(window).load(function() {
                        $("#slider-' . $rnd . '").flexslider({
                            after: function(){
                                $(window).trigger("contentResized");
                            }
                        });

                    });
                });
                </script>';


    // start items
    $output .= '<ul class="slides">';
    $Qargs = array(
        'post_type' => 'sliders',
        'tax_query' => array(
            array(
                'taxonomy' => 'slider', //(string) - Taxonomy.
                'field' => 'slug', //(string) - Select taxonomy term by ('id' or 'slug')
                'terms' => $term->slug, //(int/string/array) - Taxonomy term(s).
                'include_children' => true, //(bool) - Whether or not to include children for hierarchical taxonomies. Defaults to true.
                'operator' => 'IN' //(string) - Operator to test. Possible values are 'IN', 'NOT IN', 'AND'.
            )
        ),
        'posts_per_page' => -1
    );
    $loop = new WP_Query($Qargs);
    while ($loop->have_posts()) : $loop->the_post();
        global $post;
        // get thumbnail
        $thumb = get_post_meta(get_the_ID(), 'coll_image', true);
        $link = get_post_meta(get_the_ID(), 'coll_url', true);


        // build
        $output .= "<li>";
        if (!empty($link)) {
            $output .= '<a href="' . $link . '"><img src="' . $thumb . '" alt=""/></a>';
        } else {
            $output .= '<img src="' . $thumb . '" alt=""/>';
        }
        $output .= '<div class="flex-caption">';
        $output .= '<div class="title"><h2 class="text">' . get_the_title() . '</h2></div>';
        $output .= '<div class="description">' . coll_get_the_content(get_the_ID()) . '</div>';
        $output .= '</div>';

        $output .= "</li>";
    endwhile;
    wp_reset_postdata();
    $output .= '</ul>'; // end items
    $output .= '</div>'; // end slider

    return $output;
}

add_shortcode('slider', 'coll_sliders');


/*-----------------------------------------------------------------------------------*/
/*	CONTACT Shortcode
/*-----------------------------------------------------------------------------------*/
$cs_dir = get_template_directory_uri() . '/functions/';

function coll_shortcode_contact($atts, $content = null)
{

    // gives access to the plugin's base directory
    global $cs_dir;

    extract(shortcode_atts(array(
        'to' => get_bloginfo('admin_email')
    ), $atts));

    $content .= '
		<script type="text/javascript">
			var $j = jQuery.noConflict();
			$j(window).load(function(){
				$j("#contact-form").submit(function() {
				  // validate and process form here
					var str = $j(this).serialize();
					   $j.ajax({
					   type: "POST",
					   url: "' . $cs_dir . 'sendmail.php",
					   data: str,
					   success: function(msg){
							$j("#note").ajaxComplete(function(event, request, settings)
							{
								if(msg == "OK") // Message Sent? Show the Thank You message and hide the form
								{
									result = "Sua mensagem foi enviada. Obrigado!";
									$j("#fields").hide();
								}
								else
								{
									result = msg;
								}
								$j(this).html(result);
							});
						}
					 });
					return false;
				});
			});
		</script>';
    $content .= '<div id="post-a-comment" class="clear">';
    $content .= '<div id="fields">';
//    $content .= '<h4>Send A Message</h4>';
    $content .= '<form id="contact-form" action="">';
    $content .= '<input name="to_email" type="hidden" id="to_email" value="' . $to . '" />';
    $content .= '<p>';
    $content .= '<input class="field" name="name" type="text" id="name" placeholder="' . __('NOME', 'framework') . '"/>';
//    $content .= '<label class="error" for="name">Name *</label>';
    $content .= '</p>';
    $content .= '<p>';
    $content .= '<input class="field" name="email" type="text" id="email" placeholder="' . __('E-MAIL', 'framework') . '"/>';
//    $content .= '<label for="email">E-mail address *</label>';
    $content .= '</p>';
    $content .= '<p><textarea class="field" rows="15" cols="" name="message" placeholder="' . _x('MENSAGEM', 'noun', 'framework') . '"></textarea></p>';
    $content .= '<p><input type="submit" value="enviar" class="button" id="contact-submit" /></p>';
    $content .= '</form>';
    $content .= '</div><!--end fields-->';
    $content .= '<div id="note"></div> <!--notification area used by jQuery/Ajax -->';
    $content .= '</div>';
    return $content;
}

add_shortcode('coll_contact', 'coll_shortcode_contact');


/*-----------------------------------------------------------------------------------*/
/*	Social Shortcodes
/*-----------------------------------------------------------------------------------*/

if (!function_exists('coll_social_icons')) {
    function coll_social_icons($atts, $content = null)
    {
        $defaults = array(
            'type' => 'small'
        );
        extract(shortcode_atts($defaults, $atts));


        $output = '';
        $output .= '<ul class="social icons ' . $type . ' clearfix">';
        $output .= do_shortcode($content);
        $output .= '</ul>';


        return $output;
    }

    add_shortcode('coll_social', 'coll_social_icons');
}

if (!function_exists('coll_social_icon')) {
    function coll_social_icon($atts, $content = null)
    {
        $defaults = array(
            'type' => 'facebook',
            'url' => '#',
        );
        extract(shortcode_atts($defaults, $atts));

        return '<li class="' . $type . '"><a href="' . $url . '"><span class="social-icon"></span></a></li>';
    }

    add_shortcode('coll_icon', 'coll_social_icon');
}

/*-----------------------------------------------------------------------------------*/
/*	Twitter Shortcode
/*-----------------------------------------------------------------------------------*/
function coll_twitter($atts, $content = null)
{
    $defaults = array(
        'usr' => 'aplusk',
        'nr' => '1',
        'text' => ''
    );
    extract(shortcode_atts($defaults, $atts));


    $id = rand(0, 999);
    $output = '';

    $output .= '<div class="twitter list">';
    $output .= '<script type="text/javascript">
                jQuery(document).ready(function($){
                    $.getJSON("http://api.twitter.com/1/statuses/user_timeline/' . $usr . '.json?count=' . $nr . '&callback=?", function(tweets){
                        $("#twitter_update_list_' . $id . '").html(format_tweets(tweets));
                    });
                });
                </script>';
    $output .= '<ul id="twitter_update_list_' . $id . '" class="tweets"><li><p></p></li></ul>';
    if ($text) $output .= '<a class="button follow" href="http://twitter.com/' . $usr . '">' . $text . '</a>';


    $output .= '</div>';

    return $output;
}

add_shortcode('twitter', 'coll_twitter');

/*-----------------------------------------------------------------------------------*/
/*	Column Shortcodes
/*-----------------------------------------------------------------------------------*/

function col_one_third($atts, $content = null)
{
    return '<div class="one_third">' . do_shortcode($content) . '</div>';
}

add_shortcode('one_third', 'col_one_third');

function col_one_third_last($atts, $content = null)
{
    return '<div class="one_third column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

add_shortcode('one_third_last', 'col_one_third_last');

function col_two_third($atts, $content = null)
{
    return '<div class="two_third">' . do_shortcode($content) . '</div>';
}

add_shortcode('two_third', 'col_two_third');

function col_two_third_last($atts, $content = null)
{
    return '<div class="two_third column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

add_shortcode('two_third_last', 'col_two_third_last');

function col_one_half($atts, $content = null)
{
    return '<div class="one_half">' . do_shortcode($content) . '</div>';
}

add_shortcode('one_half', 'col_one_half');

function col_one_half_last($atts, $content = null)
{
    return '<div class="one_half column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

add_shortcode('one_half_last', 'col_one_half_last');

function col_one_fourth($atts, $content = null)
{
    return '<div class="one_fourth">' . do_shortcode($content) . '</div>';
}

add_shortcode('one_fourth', 'col_one_fourth');

function col_one_fourth_last($atts, $content = null)
{
    return '<div class="one_fourth column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

add_shortcode('one_fourth_last', 'col_one_fourth_last');

function col_three_fourth($atts, $content = null)
{
    return '<div class="three_fourth">' . do_shortcode($content) . '</div>';
}

add_shortcode('three_fourth', 'col_three_fourth');

function col_three_fourth_last($atts, $content = null)
{
    return '<div class="three_fourth column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

add_shortcode('three_fourth_last', 'col_three_fourth_last');

function col_one_fifth($atts, $content = null)
{
    return '<div class="one_fifth">' . do_shortcode($content) . '</div>';
}

add_shortcode('one_fifth', 'col_one_fifth');

function col_one_fifth_last($atts, $content = null)
{
    return '<div class="one_fifth column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

add_shortcode('one_fifth_last', 'col_one_fifth_last');

function col_two_fifth($atts, $content = null)
{
    return '<div class="two_fifth">' . do_shortcode($content) . '</div>';
}

add_shortcode('two_fifth', 'col_two_fifth');

function col_two_fifth_last($atts, $content = null)
{
    return '<div class="two_fifth column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

add_shortcode('two_fifth_last', 'col_two_fifth_last');

function col_three_fifth($atts, $content = null)
{
    return '<div class="three_fifth">' . do_shortcode($content) . '</div>';
}

add_shortcode('three_fifth', 'col_three_fifth');

function col_three_fifth_last($atts, $content = null)
{
    return '<div class="three_fifth column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

add_shortcode('three_fifth_last', 'col_three_fifth_last');

function col_four_fifth($atts, $content = null)
{
    return '<div class="four_fifth">' . do_shortcode($content) . '</div>';
}

add_shortcode('four_fifth', 'col_four_fifth');

function col_four_fifth_last($atts, $content = null)
{
    return '<div class="four_fifth column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

add_shortcode('four_fifth_last', 'col_four_fifth_last');

function col_one_sixth($atts, $content = null)
{
    return '<div class="one_sixth">' . do_shortcode($content) . '</div>';
}

add_shortcode('one_sixth', 'col_one_sixth');

function col_one_sixth_last($atts, $content = null)
{
    return '<div class="one_sixth column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

add_shortcode('one_sixth_last', 'col_one_sixth_last');

function col_five_sixth($atts, $content = null)
{
    return '<div class="five_sixth">' . do_shortcode($content) . '</div>';
}

add_shortcode('five_sixth', 'col_five_sixth');

function col_five_sixth_last($atts, $content = null)
{
    return '<div class="five_sixth column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

add_shortcode('five_sixth_last', 'col_five_sixth_last');

function col_divider($atts, $content = null)
{
    return '<div class="divider">' . do_shortcode($content) . '</div>';
}

add_shortcode('divider', 'col_divider');
/*-----------------------------------------------------------------------------------*/
/*	Buttons
/*-----------------------------------------------------------------------------------*/


function col_button($atts, $content = null)
{

    extract(shortcode_atts(array(
        'url' => '#',
        'target' => '_self',
        'style' => 'white'
    ), $atts));

    return '<a class="button ' . $style . '" href="' . $url . '">' . do_shortcode($content) . '</a>';
}

add_shortcode('button', 'col_button');


/*-----------------------------------------------------------------------------------*/
/*	Alerts
/*-----------------------------------------------------------------------------------*/


function col_alert($atts, $content = null)
{

    extract(shortcode_atts(array(
        'style' => 'blue'
    ), $atts));

    return '<div class="alert ' . $style . '">' . do_shortcode($content) . '</div>';
}

add_shortcode('alert', 'col_alert');


/*-----------------------------------------------------------------------------------*/
/*	Toggle Shortcodes
/*-----------------------------------------------------------------------------------*/

function col_toggle($atts, $content = null)
{

    extract(shortcode_atts(array(
        'title' => 'Title goes here',
        'state' => 'open'
    ), $atts));

    $out = '';

    $out .= "<div data-id='" . $state . "' class=\"toggle\"><h4>" . $title . "</h4><div class=\"toggle-inner\">" . do_shortcode($content) . "</div></div>";

    return $out;

}

add_shortcode('toggle', 'col_toggle');


/*-----------------------------------------------------------------------------------*/
/*	Tabs Shortcodes
/*-----------------------------------------------------------------------------------*/

if (!function_exists('col_tabs')) {
    function col_tabs($atts, $content = null)
    {
        $defaults = array();
        extract(shortcode_atts($defaults, $atts));

        // Extract the tab titles for use in the tab widget.
        preg_match_all('/tab title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE);

        $tab_titles = array();
        if (isset($matches[1])) {
            $tab_titles = $matches[1];
        }

        $output = '';

        if (count($tab_titles)) {
            $output .= '<div id="tabs-' . rand(1, 100) . '" class="tabs"><div class="tab-inner">';
            $output .= '<ul class="nav clearfix">';

            foreach ($tab_titles as $tab) {
                $output .= '<li><a href="#tab-' . sanitize_title($tab[0]) . '">' . $tab[0] . '</a></li>';
            }

            $output .= '</ul>';
            $output .= do_shortcode($content);
            $output .= '</div></div>';
        } else {
            $output .= do_shortcode($content);
        }

        return $output;
    }

    add_shortcode('tabs', 'col_tabs');
}

if (!function_exists('col_tab')) {
    function col_tab($atts, $content = null)
    {
        $defaults = array('title' => 'Tab');
        extract(shortcode_atts($defaults, $atts));

        return '<div id="tab-' . sanitize_title($title) . '" class="tab">' . do_shortcode($content) . '</div>';
    }

    add_shortcode('tab', 'col_tab');
}
/*-----------------------------------------------------------------------------------*/
/*	Tabs Shortcodes
/*-----------------------------------------------------------------------------------*/
if (!function_exists('coll_divider')) {
    function coll_divider($atts, $content = null)
    {
        $defaults = array();
        extract(shortcode_atts($defaults, $atts));

        return '<hr class="cuba">';
    }

    add_shortcode('divider', 'coll_divider');
}
////move wpautop filter to AFTER shortcode is processed
//remove_filter('the_content', 'wpautop');
//add_filter('the_content', 'wpautop', 99);
//add_filter('the_content', 'shortcode_unautop', 100);
?>