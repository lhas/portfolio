<?php

// Buttons shortcode config
$col_shortcodes['button'] = array(
    'params' => array(
        'url' => array(
            'std' => '',
            'type' => 'text',
            'label' => __('Button URL', 'framework'),
            'desc' => __('Add the button\'s url eg http://example.com', 'framework')
        ),
        'style' => array(
            'type' => 'select',
            'label' => __('Button\'s Style', 'framework'),
            'desc' => __('Select the button\'s style, ie the buttons colour', 'framework'),
            'options' => array(
                'white' => 'White',
                'black' => 'Black',
                'green' => 'Green',
                'blue' => 'Blue',
                'purple' => 'Purple',
                'red' => 'Red',
                'orange' => 'Orange',
                'gray' => 'Gray'
            )
        ),
        'content' => array(
            'std' => 'Button Text',
            'type' => 'text',
            'label' => __('Button\'s Text', 'framework'),
            'desc' => __('Add the button\'s text', 'framework'),
        )
    ),
    'shortcode' => '[button url="{{url}}" style="{{style}}"] {{content}} [/button]',
    'popup_title' => __('Insert Button Shortcode', 'framework')
);

// Alerts shortcode config
$col_shortcodes['alert'] = array(
    'params' => array(
        'style' => array(
            'type' => 'select',
            'label' => __('Alert\'s Style', 'framework'),
            'desc' => __('Select the slter\'s style, ie the alert colour', 'framework'),
            'options' => array(
                'blue' => 'Blue',
                'red' => 'Red',
                'yellow' => 'Yellow',
                'green' => 'Green'
            )
        ),
        'content' => array(
            'std' => 'Your Alert!',
            'type' => 'textarea',
            'label' => __('Alert\'s Text', 'framework'),
            'desc' => __('Add the alert\'s text', 'framework'),
        )

    ),
    'shortcode' => '[alert style="{{style}}"] {{content}} [/alert]',
    'popup_title' => __('Insert Alert Shortcode', 'framework')
);

// Toggle content shortcode config
$col_shortcodes['toggle'] = array(
    'params' => array(
        'title' => array(
            'type' => 'text',
            'label' => __('Toggle Content Title', 'framework'),
            'desc' => __('Add the title that will go above the toggle content', 'framework'),
            'std' => 'Title'
        ),
        'content' => array(
            'std' => 'Content',
            'type' => 'textarea',
            'label' => __('Toggle Content', 'framework'),
            'desc' => __('Add the toggle content.', 'framework'),
        )

    ),
    'shortcode' => '[toggle title="{{title}}"] {{content}} [/toggle]',
    'popup_title' => __('Insert Toggle Content Shortcode', 'framework')
);

// Tabs
$col_shortcodes['tabs'] = array(
    'params' => array(),
    'no_preview' => true,
    'shortcode' => '[tabs] {{child_shortcode}}  [/tabs]',
    'popup_title' => __('Insert Tabbed Shortcode', 'framework'),

    'child_shortcode' => array(
        'params' => array(
            'title' => array(
                'std' => '',
                'type' => 'text',
                'label' => __('Tab Title', 'framework'),
                'desc' => __('Title of the tab', 'framework'),
            ),
            'content' => array(
                'std' => '',
                'type' => 'textarea',
                'label' => __('Tab Content', 'framework'),
                'desc' => __('Add the tabs content', 'framework')
            )
        ),
        'shortcode' => '[tab title="{{title}}"] {{content}} [/tab]',
        'clone_button' => __('Add Tab', 'framework')
    )
);


// columns
$col_shortcodes['columns'] = array(
    'params' => array(),
    'shortcode' => ' {{child_shortcode}} ', // as there is no wrapper shortcode
    'popup_title' => __('Insert Columns Shortcode', 'framework'),
    'no_preview' => true,

    // child shortcode is clonable & sortable
    'child_shortcode' => array(
        'params' => array(
            'column' => array(
                'type' => 'select',
                'label' => __('Column Type', 'framework'),
                'desc' => __('Select the type, ie width of the column.', 'framework'),
                'options' => array(
                    'one_third' => 'One Third',
                    'one_third_last' => 'One Third Last',
                    'two_third' => 'Two Thirds',
                    'two_third_last' => 'Two Thirds Last',
                    'one_half' => 'One Half',
                    'one_half_last' => 'One Half Last',
                    'one_fourth' => 'One Fourth',
                    'one_fourth_last' => 'One Fourth Last',
                    'three_fourth' => 'Three Fourth',
                    'three_fourth_last' => 'Three Fourth Last',
                    'one_fifth' => 'One Fifth',
                    'one_fifth_last' => 'One Fifth Last',
                    'two_fifth' => 'Two Fifth',
                    'two_fifth_last' => 'Two Fifth Last',
                    'three_fifth' => 'Three Fifth',
                    'three_fifth_last' => 'Three Fifth Last',
                    'four_fifth' => 'Four Fifth',
                    'four_fifth_last' => 'Four Fifth Last',
                    'one_sixth' => 'One Sixth',
                    'one_sixth_last' => 'One Sixth Last',
                    'five_sixth' => 'Five Sixth',
                    'five_sixth_last' => 'Five Sixth Last'
                )
            ),
            'content' => array(
                'std' => '',
                'type' => 'textarea',
                'label' => __('Column Content', 'framework'),
                'desc' => __('Add the column content.', 'framework'),
            )
        ),
        'shortcode' => '[{{column}}] {{content}} [/{{column}}] ',
        'clone_button' => __('Add Column', 'framework')
    )
);

/*
 *
 *    TEXT STYLES
 * /////////////////////////////////////////////////////////////////////*/
$col_shortcodes['textstyles'] = array(
    'params' => array(
        'type' => array(
            'type' => 'select',
            'label' => __('Text Type', 'framework'),
            'desc' => __('Select the text type', 'framework'),
            'options' => array(
                'one' => 'One',
                'two' => 'Two',
                'three' => 'Three',
                'four' => 'Four',
                'five' => 'Five',
                'six' => 'Six',
                'seven' => 'Seven',
                'eight' => 'Eight',
                'nine' => 'Nine'
            )
        ),
        'max-font-size' => array(
            'std' => '',
            'type' => 'text',
            'label' => __('Maximum Font Size', 'framework'),
            'desc' => __('Insert the maximum font size (large screens). Leave blank for the default value (from css)', 'framework'),
        ),
        'min-font-size' => array(
            'std' => '',
            'type' => 'text',
            'label' => __('Minimum Font Size', 'framework'),
            'desc' => __('Insert the minimum font size (mobile). Leave blank for the default value (from css)', 'framework'),
        ),
        'content' => array(
            'std' => 'Text',
            'type' => 'text',
            'label' => __('Text', 'framework'),
            'desc' => __('Add the text', 'framework'),
        )
    ),
    'shortcode' => '[text_type type="{{type}}" max_font_size="{{max-font-size}}" min_font_size="{{min-font-size}}"] {{content}} [/text_type]',
    'popup_title' => __('Insert Text Type Shortcode', 'framework')

);

/*
 *
 *    SMART APDDING
 * /////////////////////////////////////////////////////////////////////*/

$col_shortcodes['smartpadding'] = array(
    'params' => array(
        'min' => array(
            'std' => '10',
            'type' => 'text',
            'label' => __('Minimum', 'framework'),
            'desc' => __('Insert the padding for mobile', 'framework'),
        ),
        'max' => array(
            'std' => '20',
            'type' => 'text',
            'label' => __('Maximum', 'framework'),
            'desc' => __('Insert the padding for widescreen', 'framework'),
        )
    ),
    'shortcode' => '[smart_padding min="{{min}}" max="{{max}}"][/smart_padding]',
    'popup_title' => __('Insert Smart Padding Shortcode', 'framework')

);
/*
 *
 *    PORTFOLIO
 * /////////////////////////////////////////////////////////////////////*/

$col_shortcodes['portfolio'] = array(
    'no_preview' => true,
    'params' => array(
        'columns' => array(
            'type' => 'text',
            'label' => __('Columns', 'framework'),
            'desc' => __('Select the number of columns', 'framework'),
            'std' => '3'
        )
    ),
    'shortcode' => '[portfolio columns="{{columns}}"][/portfolio]',
    'popup_title' => __('Portfolio Shortcode', 'framework')

);
/*
 *
 *    INFO COLUMNS
 * /////////////////////////////////////////////////////////////////////*/
$ic_cat = array();
$tax_terms = get_terms('ic-cat', 'orderby=none');
foreach ($tax_terms as $tax_term) {
    $ic_cat[$tax_term->term_id] = $tax_term->slug;
}
$col_shortcodes['infocolumns'] = array(
    'no_preview' => true,
    'params' => array(
        'id' => array(
            'type' => 'select',
            'label' => __('Info Columns', 'framework'),
            'desc' => __('Select info columns block', 'framework'),
            'options' => $ic_cat,
            'std' => ''
        ),
        'columns' => array(
            'type' => 'text',
            'label' => __('Columns', 'framework'),
            'desc' => __('Select the number of columns', 'framework'),
            'std' => '4'
        )
    ),
    'shortcode' => '[infocolumns id="{{id}}" columns="{{columns}}"][/infocolumns]',
    'popup_title' => __('Select Info Columns', 'framework')

);


/*
 *
 *    INFO COLUMNS
 * /////////////////////////////////////////////////////////////////////*/
$team_blocks = array();
$tax_terms = get_terms('team-block', 'orderby=none');
foreach ($tax_terms as $tax_term) {
    $team_blocks[$tax_term->term_id] = $tax_term->slug;
}
$col_shortcodes['team'] = array(
    'no_preview' => true,
    'params' => array(
        'id' => array(
            'type' => 'select',
            'label' => __('Team', 'framework'),
            'desc' => __('Select a team', 'framework'),
            'options' => $team_blocks,
            'std' => ''
        ),
        'columns' => array(
            'type' => 'text',
            'label' => __('Columns', 'framework'),
            'desc' => __('Select the number of columns', 'framework'),
            'std' => '4'
        )
    ),
    'shortcode' => '[team id="{{id}}" columns="{{columns}}"]',
    'popup_title' => __('Select Team', 'framework')

);
/*
 *
 *    SKILL
 * /////////////////////////////////////////////////////////////////////*/
$col_shortcodes['skill'] = array(
    'params' => array(
        'name' => array(
            'type' => 'text',
            'label' => __('Name', 'framework'),
            'desc' => __('Your skill name', 'framework'),
            'options' => $team_blocks,
            'std' => 'skill'
        ),
        'percentage' => array(
            'type' => 'text',
            'label' => __('Percentage', 'framework'),
            'desc' => __('The percentage of awesomeness', 'framework'),
            'std' => '50'
        ),
        'name_color' => array(
            'type' => 'text',
            'label' => __('Name Color', 'framework'),
            'desc' => __('Insert a the color code for the text. Leave black to use the default color', 'framework'),
            'std' => ''
        ),
        'percentage_color' => array(
            'type' => 'text',
            'label' => __('Percentage Number Color', 'framework'),
            'desc' => __('Insert a the color code for the percentage text. Leave black to use the default color', 'framework'),
            'std' => ''
        ),
        'percentage_bar_color' => array(
            'type' => 'text',
            'label' => __('Percentage Bar Color', 'framework'),
            'desc' => __('Insert a the color code for the percentage bar. Leave black to use the default color', 'framework'),
            'std' => ''
        ),
        'bg_bar_color' => array(
            'type' => 'text',
            'label' => __('Background Bar Color', 'framework'),
            'desc' => __('Insert a the color code for the background bar. Leave black to use the default color', 'framework'),
            'std' => ''
        )
    ),
    'shortcode' => '[skill name="{{name}}" percentage="{{percentage}}" name_color="{{name_color}}" percentage_color="{{percentage_color}}" percentage_bar_color="{{percentage_bar_color}}" bg_bar_color="{{bg_bar_color}}"]',
    'popup_title' => __('Insert Skill', 'framework')

);

/*
 *
 *    PRICE TABLE
 * /////////////////////////////////////////////////////////////////////*/
$price_table = array();
$tax_terms = get_terms('price-table', 'orderby=none');
foreach ($tax_terms as $tax_term) {
    $price_table[$tax_term->term_id] = $tax_term->slug;
}
$col_shortcodes['pricetable'] = array(
    'no_preview' => true,
    'params' => array(
        'id' => array(
            'type' => 'select',
            'label' => __('Price Table', 'framework'),
            'desc' => __('Select a price table', 'framework'),
            'options' => $price_table,
            'std' => ''
        ),
        'columns' => array(
            'type' => 'text',
            'label' => __('Columns', 'framework'),
            'desc' => __('Select the number of columns', 'framework'),
            'std' => '4'
        )
    ),
    'shortcode' => '[pricetable id="{{id}}" columns="{{columns}}"]',
    'popup_title' => __('Select Price Table', 'framework')

);

/*
 *
 *    CLIENTS
 * /////////////////////////////////////////////////////////////////////*/

$col_shortcodes['clients'] = array(
    'no_preview' => true,
    'params' => array(
        'columns' => array(
            'type' => 'text',
            'label' => __('Columns', 'framework'),
            'desc' => __('Select the number of columns', 'framework'),
            'std' => '3'
        )
    ),
    'shortcode' => '[clients columns="{{columns}}"]',
    'popup_title' => __('Clients Shortcode', 'framework')

);

/*
 *
 *    SLIDERS
 * /////////////////////////////////////////////////////////////////////*/
$sliders = array();
$tax_terms = get_terms('slider', 'orderby=none');
foreach ($tax_terms as $tax_term) {
    $sliders[$tax_term->term_id] = $tax_term->slug;
}
$opt = array(
    '' => 'off',
    'on' => 'on'
);
$col_shortcodes['sliders'] = array(
    'no_preview' => true,
    'params' => array(
        'id' => array(
            'type' => 'select',
            'label' => __('Slider', 'framework'),
            'desc' => __('Select a Slider', 'framework'),
            'options' => $sliders,
            'std' => ''
        ),
        'background' => array(
            'type' => 'select',
            'label' => __('Background', 'framework'),
            'desc' => __('Select "on" if you want the slider to have a background', 'framework'),
            'options' => $opt,
            'std' => ''
        ),
        'captions' => array(
            'type' => 'select',
            'label' => __('Captions', 'framework'),
            'desc' => __('Select "on" if you want the slider display the title and description of the slide', 'framework'),
            'options' => $opt,
            'std' => ''
        ),
        'arrows' => array(
            'type' => 'select',
            'label' => __('Arrows', 'framework'),
            'desc' => __('Select "on" if you want the slider to display the navigation arrows', 'framework'),
            'options' => $opt,
            'std' => ''
        ),
        'bullets' => array(
            'type' => 'select',
            'label' => __('Bullets', 'framework'),
            'desc' => __('Select "on" if you want the slider to display the navigation bullets', 'framework'),
            'options' => $opt,
            'std' => ''
        )

    ),
    'shortcode' => '[slider id="{{id}}" background="{{background}}" captions="{{captions}}" arrows="{{arrows}}" bullets="{{bullets}}"]',
    'popup_title' => __('Slider Shortcode', 'framework')

);

/*
 *
 *   CONTACT
 * /////////////////////////////////////////////////////////////////////*/
$col_shortcodes['contact'] = array(
    'no_preview' => true,
    'params' => array(),
    'shortcode' => '[coll_contact]',
    'popup_title' => __('Contact Shortcode', 'framework')

);
/*
 *
 *    SOCIAL ICONS
 * /////////////////////////////////////////////////////////////////////*/
$opt1 = array(
    'large' => 'large',
    'small' => 'small'
);
$opt2 = array(
    'facebook' => 'facebook',
    'twitter' => 'twitter',
    'gplus' => 'google plus',
    'dribbble' => 'dribbble',
    'flickr' => 'flickr',
    'youtube' => 'youtube',
    'vimeo' => 'vimeo',
    'linkedin' => 'linkedin',
    'pinterest' => 'pinterest',
    'behance' => 'behance',
    'soundcloud' => 'soundcloud',
    'skype' => 'skype',
    'instagram' => 'instagram',
    'github' => 'github',

);
$col_shortcodes['social'] = array(
    'params' => array(
        'type' => array(
            'type' => 'select',
            'label' => __('Type', 'framework'),
            'desc' => __('Select the size of the social icons', 'framework'),
            'options' => $opt1,
            'std' => ''
        )
    ),
    'no_preview' => true,
    'shortcode' => '[coll_social type="{{type}}"] {{child_shortcode}}  [/coll_social]',
    'popup_title' => __('Insert Social Icons Shortcode', 'framework'),

    'child_shortcode' => array(
        'params' => array(
            'type' => array(
                'type' => 'select',
                'label' => __('Type', 'framework'),
                'desc' => __('Select the social service', 'framework'),
                'options' => $opt2,
                'std' => ''
            ),
            'url' => array(
                'std' => '',
                'type' => 'text',
                'label' => __('Url', 'framework'),
                'desc' => __('Insert the social URL', 'framework')
            )
        ),
        'shortcode' => '[coll_icon type="{{type}}" url="{{url}}"]',
        'clone_button' => __('Add Icon', 'framework')
    )
);


/*
 *
 *    TWITTER
 * /////////////////////////////////////////////////////////////////////*/
$opt = array(
    'solo' => 'solo',
    'list' => 'list'
);
$col_shortcodes['twitter'] = array(
    'no_preview' => true,
    'params' => array(
        'username' => array(
            'type' => 'text',
            'label' => __('Username', 'framework'),
            'desc' => __('Insert your twitter username', 'framework'),
            'std' => ''
        ),
        'postcount' => array(
            'type' => 'text',
            'label' => __('Number of Tweets', 'framework'),
            'desc' => __('Insert the number of tweets (only for list)', 'framework'),
            'std' => ''
        ),
        'text' => array(
            'type' => 'text',
            'label' => __('Follow Link Text', 'framework'),
            'desc' => __('Insert the text for the follow link. Leave blank to remove the link', 'framework'),
            'std' => ''
        )
    ),
    'shortcode' => '[twitter usr="{{username}}" nr="{{postcount}}" text="{{text}}"]',
    'popup_title' => __('Twitter Shortcode', 'framework')

);
?>