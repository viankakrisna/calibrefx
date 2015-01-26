<?php

global $cfx_shortcodes;

$cfx_shortcodes['header_1'] = array( 
	'type'=>'heading', 
	'title'=>__('Columns', 'calibrefx')
);

$cfx_shortcodes['one_half'] = array( 
	'type'=>'checkbox', 
	'title'=>__('One Half (1/2)', 'calibrefx' ), 
	'attr'=>array(
		'last'=>array( 'type'=>'custom', 'title'=>__('Last Column', 'calibrefx'), 'desc' => __('Check this for the last column in a row. i.e. when the columns add up to 1.', 'calibrefx')),
		'centered_text'=>array('type'=>'custom', 'title'=>__('Centered Text', 'calibrefx')),
		'animation'=>array(
			'type'=>'select', 
			'half_width' => 'true',
			'title'  => __('Animation', 'calibrefx'),
			'values' => array(
			     "none" => "None",
			     "fade-in" => "Fade In",
		  		 "fade-in-from-left" => "Fade In From Left",
		  		 "fade-in-right" => "Fade In From Right",
		  		 "fade-in-from-bottom" => "Fade In From Bottom",
		  		 "grow-in" => "Grow In"
			)
		),
		'delay'=>array(
			'type'=>'text', 
			'second_half_width' => 'true',
			'title'=>__('Animation Delay', 'calibrefx'),
			'desc' => __('Enter delay (in milliseconds) if needed e.g. 150. This parameter comes in handy when creating the animate in "one by one" effect in horizontal columns. ', 'calibrefx'),
		)
	)
);


//Thirds
$cfx_shortcodes['one_third'] = array( 
	'type'=>'checkbox', 
	'title'=>__('One Third Column (1/3)', 'calibrefx' ), 
	'attr'=>array( 
		'last'=>array( 'type'=>'custom', 'title'=>__('Last Column', 'calibrefx'), 'desc' => __('Check this for the last column in a row. i.e. when the columns add up to 1.', 'calibrefx')),
		'centered_text'=>array('type'=>'custom', 'title'=>__('Centered Text', 'calibrefx')),
		'animation'=>array(
			'type'=>'select', 
			'half_width' => 'true',
			'title'  => __('Animation', 'calibrefx'),
			'values' => array(
			     "none" => "None",
			     "fade-in" => "Fade In",
		  		 "fade-in-from-left" => "Fade In From Left",
		  		 "fade-in-right" => "Fade In From Right",
		  		 "fade-in-from-bottom" => "Fade In From Bottom",
		  		 "grow-in" => "Grow In"
			)
		),
		'delay'=>array(
			'type'=>'text', 
			'second_half_width' => 'true',
			'title'=>__('Animation Delay', 'calibrefx'),
			'desc' => __('Enter delay (in milliseconds) if needed e.g. 150. This parameter comes in handy when creating the animate in "one by one" effect in horizontal columns. ', 'calibrefx'),
		)
	)
);

$cfx_shortcodes['two_thirds'] = array( 
	'type'=>'checkbox', 
	'title'=>__('Two Thirds Column (2/3)', 'calibrefx' ), 
	'attr'=>array(
		'last'=>array( 'type'=>'custom', 'title'=>__('Last Column', 'calibrefx'), 'desc' => __('Check this for the last column in a row. i.e. when the columns add up to 1.', 'calibrefx')),
		'centered_text'=>array('type'=>'custom', 'title'=>__('Centered Text', 'calibrefx')),
		'animation'=>array(
			'type'=>'select', 
			'half_width' => 'true',
			'title'  => __('Animation', 'calibrefx'),
			'values' => array(
			     "none" => "None",
			     "fade-in" => "Fade In",
		  		 "fade-in-from-left" => "Fade In From Left",
		  		 "fade-in-right" => "Fade In From Right",
		  		 "fade-in-from-bottom" => "Fade In From Bottom",
		  		 "grow-in" => "Grow In"
			)
		),
		'delay'=>array(
			'type'=>'text', 
			'second_half_width' => 'true',
			'title'=>__('Animation Delay', 'calibrefx'),
			'desc' => __('Enter delay (in milliseconds) if needed e.g. 150. This parameter comes in handy when creating the animate in "one by one" effect in horizontal columns. ', 'calibrefx'),
		)
	)
);


//Fourths
$cfx_shortcodes['one_fourth'] = array( 
	'type'=>'checkbox', 
	'title'=>__('One Fourth Column (1/4)', 'calibrefx' ), 
	'attr'=>array( 
		'last'=>array( 'type'=>'custom', 'title'=>__('Last Column', 'calibrefx'), 'desc' => __('Check this for the last column in a row. i.e. when the columns add up to 1.', 'calibrefx')),
		'centered_text'=>array('type'=>'custom', 'title'=>__('Centered Text', 'calibrefx')),
		'animation'=>array(
			'type'=>'select', 
			'half_width' => 'true',
			'title'  => __('Animation', 'calibrefx'),
			'values' => array(
			     "none" => "None",
			     "fade-in" => "Fade In",
		  		 "fade-in-from-left" => "Fade In From Left",
		  		 "fade-in-right" => "Fade In From Right",
		  		 "fade-in-from-bottom" => "Fade In From Bottom",
		  		 "grow-in" => "Grow In"
			)
		),
		'delay'=>array(
			'type'=>'text', 
			'second_half_width' => 'true',
			'title'=>__('Animation Delay', 'calibrefx'),
			'desc' => __('Enter delay (in milliseconds) if needed e.g. 150. This parameter comes in handy when creating the animate in "one by one" effect in horizontal columns. ', 'calibrefx'),
		)
	)
);

$cfx_shortcodes['three_fourths'] = array( 
	'type'=>'checkbox', 
	'title'=>__('Three Fourths Column (3/4)', 'calibrefx' ), 
	'attr'=>array( 
		'last'=>array( 'type'=>'custom', 'title'=>__('Last Column', 'calibrefx'), 'desc' => __('Check this for the last column in a row. i.e. when the columns add up to 1.', 'calibrefx')),
		'centered_text'=>array('type'=>'custom', 'title'=>__('Centered Text', 'calibrefx')),
		'animation'=>array(
			'type'=>'select', 
			'half_width' => 'true',
			'title'  => __('Animation', 'calibrefx'),
			'values' => array(
			     "none" => "None",
			     "fade-in" => "Fade In",
		  		 "fade-in-from-left" => "Fade In From Left",
		  		 "fade-in-right" => "Fade In From Right",
		  		 "fade-in-from-bottom" => "Fade In From Bottom",
		  		 "grow-in" => "Grow In"
			)
		),
		'delay'=>array(
			'type'=>'text', 
			'second_half_width' => 'true',
			'title'=>__('Animation Delay', 'calibrefx'),
			'desc' => __('Enter delay (in milliseconds) if needed e.g. 150. This parameter comes in handy when creating the animate in "one by one" effect in horizontal columns. ', 'calibrefx'),
		)
	)
);


//Sixths
$cfx_shortcodes['one_sixth'] = array( 
	'type'=>'checkbox', 
	'title'=>__('One Sixth Column (1/6)', 'calibrefx' ), 
	'attr'=>array( 
		'last'=>array( 'type'=>'custom', 'title'=>__('Last Column', 'calibrefx'), 'desc' => __('Check this for the last column in a row. i.e. when the columns add up to 1.', 'calibrefx')),
		'centered_text'=>array('type'=>'custom', 'title'=>__('Centered Text', 'calibrefx')),
		'animation'=>array(
			'type'=>'select', 
			'half_width' => 'true',
			'title'  => __('Animation', 'calibrefx'),
			'values' => array(
			     "none" => "None",
			     "fade-in" => "Fade In",
		  		 "fade-in-from-left" => "Fade In From Left",
		  		 "fade-in-right" => "Fade In From Right",
		  		 "fade-in-from-bottom" => "Fade In From Bottom",
		  		 "grow-in" => "Grow In"
			)
		),
		'delay'=>array(
			'type'=>'text', 
			'second_half_width' => 'true',
			'title'=>__('Animation Delay', 'calibrefx'),
			'desc' => __('Enter delay (in milliseconds) if needed e.g. 150. This parameter comes in handy when creating the animate in "one by one" effect in horizontal columns. ', 'calibrefx'),
		)
	)
);

$cfx_shortcodes['five_sixths'] = array( 
	'type'=>'checkbox', 
	'title'=>__('Five Sixths Column (5/6)', 'calibrefx' ), 
	'attr'=>array( 
		'last'=>array( 'type'=>'custom', 'title'=>__('Last Column', 'calibrefx'), 'desc' => __('Check this for the last column in a row. i.e. when the columns add up to 1.', 'calibrefx')),
		'centered_text'=>array('type'=>'custom', 'title'=>__('Centered Text', 'calibrefx')),
		'animation'=>array(
			'type'=>'select', 
			'half_width' => 'true',
			'title'  => __('Animation', 'calibrefx'),
			'values' => array(
			     "none" => "None",
			     "fade-in" => "Fade In",
		  		 "fade-in-from-left" => "Fade In From Left",
		  		 "fade-in-right" => "Fade In From Right",
		  		 "fade-in-from-bottom" => "Fade In From Bottom",
		  		 "grow-in" => "Grow In"
			)
		),
		'delay'=>array(
			'type'=>'text', 
			'second_half_width' => 'true',
			'title'=>__('Animation Delay', 'calibrefx'),
			'desc' => __('Enter delay (in milliseconds) if needed e.g. 150. This parameter comes in handy when creating the animate in "one by one" effect in horizontal columns. ', 'calibrefx'),
		)
	)
);

$cfx_shortcodes['one_whole'] = array( 
	'type'=>'checkbox', 
	'title'=>__('One Whole Column (1/1)', 'calibrefx' ), 
	'attr'=>array( 
		'animation'=>array(
			'type'=>'select', 
			'half_width' => 'true',
			'title'  => __('Animation', 'calibrefx'),
			'values' => array(
			     "none" => "None",
			     "fade-in" => "Fade In",
		  		 "fade-in-from-left" => "Fade In From Left",
		  		 "fade-in-right" => "Fade In From Right",
		  		 "fade-in-from-bottom" => "Fade In From Bottom",
		  		 "grow-in" => "Grow In"
			)
		),
		'delay'=>array(
			'type'=>'text', 
			'second_half_width' => 'true',
			'title'=>__('Animation Delay', 'calibrefx'),
			'desc' => __('Enter delay (in milliseconds) if needed e.g. 150. This parameter comes in handy when creating the animate in "one by one" effect in horizontal columns. ', 'calibrefx'),
		)
	)
);

#-----------------------------------------------------------------
# Elements 
#-----------------------------------------------------------------

$cfx_shortcodes['header_6'] = array( 
	'type'=>'heading', 
	'title'=>__('Stuff', 'calibrefx' )
);

//Full Width Section
$cfx_shortcodes['full_width_section'] = array( 
	'type'=>'custom', 
	'title'=>__('Full Width Section', 'calibrefx' ), 
	'attr'=>array( 
	    'color' =>array('type'=>'custom', 'title'  => __('Background Color', 'calibrefx')),
		'image'=>array('type'=>'custom', 'title'  => __('Background Image', 'calibrefx')),
		'bg_pos'=>array(
			'type'=>'select', 
			'title'  => __('Background Position', 'calibrefx'),
			'values' => array(
			     "left top" => "Left Top",
		  		 "left center" => "Left Center",
		  		 "left bottom" => "Left Bottom",
		  		 "center top" => "Center Top",
		  		 "center center" => "Center Center",
		  		 "center bottom" => "Center Bottom",
		  		 "right top" => "Right Top",
		  		 "right center" => "Right Center",
		  		 "right bottom" => "Right Bottom"
			)
		),
		'bg_repeat'=>array(
			'type'=>'select', 
			'title'  => __('Background Repeat', 'calibrefx'),
			'values' => array(
			     "no-repeat" => "No-Repeat",
		  		 "repeat" => "Repeat"
			)
		),
		'parallax_bg'=>array('type'=>'checkbox', 'title'=>__('Parallax Background', 'calibrefx')),
		'text_color'=>array('type'=>'custom', 'title'  => __('Text Color', 'calibrefx')),
		
		'top_padding'=>array(
			'type'=>'text', 
			'title'=>__('Top Padding', 'calibrefx'),
			'desc' => __('Don\'nt include "px" in your string. e.g. 50.', 'calibrefx'),
		),
		'bottom_padding'=>array(
			'type'=>'text', 
			'title'=>__('Bottom Padding', 'calibrefx'),
			'desc' => __('Don\'nt include "px" in your string. e.g. 50.', 'calibrefx'),
		),
		
	)
);

do_action( 'calibrefx_shortcodes' );