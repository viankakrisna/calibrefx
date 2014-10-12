<?php

global $calibrefx, $fonts;

$fonts = apply_filters( 'calibrefx_webfont', array(
    'Arial' => array(
                'font-family' => 'Arial, Helvetica, sans-serif;',
                'google-font' => false,
            ),
    'Helvetica' => array(
                'font-family' => 'Helvetica, Arial, sans-serif;',
                'google-font' => false,
            ),
    'Calibri' => array(
                'font-family' => 'Calibri, Candara, Segoe, "Segoe UI", Optima, Arial, sans-serif;',
                'google-font' => false,
            ),
    'Verdana' => array(
                'font-family' => 'Verdana, Geneva, sans-serif;',
                'google-font' => false,
            ),
    'Trebuchet' => array(
                'font-family' => '"Trebuchet MS", Arial, Helvetica, sans-serif;',
                'google-font' => false,
            ),
    'Georgia' => array(
                'font-family' => 'Georgia, "Times New Roman", Times, serif;',
                'google-font' => false,
            ),
    'Times' => array(
                'font-family' => '"Times New Roman", Times, serif;',
                'google-font' => false,
            ),
    'Tahoma' => array(
                'font-family' => 'Tahoma, Geneva, sans-serif;',
                'google-font' => false,
            ),
    'Palatino Linotype' => array(
                'font-family' => '"Palatino Linotype", "Book Antiqua", Palatino, serif;',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
    'Droid Sans' => array(
                'font-family' => '"Droid Sans", sans-serif;',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
    'Droid Serif' => array(
                'font-family' => '"Droid Serif", Georgia, "Times New Roman", sans-serif;',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
    'Open Sans' => array(
                'font-family' => '"Open Sans", Verdana, Geneva, sans-serif;',
                'google-font' => true,
                'google-font-style' => '400,600,700',
            ),
    'Ubuntu' => array(
                'font-family' => '"Ubuntu", sans-serif;',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
    'Ubuntu Mono' => array(
                'font-family' => '"Ubuntu Mono", sans-serif',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
    'Abel' => array(
                'font-family' => '"Abel", sans-serif;',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
    'Lato' => array(
                'font-family' => '"Lato", sans-serif;',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
    'Raleway' => array(
                'font-family' => '"Raleway", sans-serif;',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
    'Noticia Text' => array(
                'font-family' => '"Noticia Text", serif;',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
    'PT Sans' => array(
                'font-family' => '"PT Sans", sans-serif;',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
    'PT Sans Caption' => array(
                'font-family' => '"PT Sans Caption", sans-serif;',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
    'PT Serif' => array(
                'font-family' => '"PT Serif", sans-serif;',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
    'Signika' => array(
                'font-family' => '"Signika", sans-serif',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
    'Signika Negative' => array(
                'font-family' => '"Signika Negative", sans-serif',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
    'Istok Web' => array(
                'font-family' => '"Istok Web", sans-serif',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
    'Titillium Web' => array(
                'font-family' => '"Titillium Web", sans-serif',
                'google-font' => true,
                'google-font-style' => '400,600,700',
            ),
    'Grand Hotel' => array(
                'font-family' => '"Grand Hotel", cursive',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
    'Lora' => array(
                'font-family' => '"Lora", serif',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
    'Montserrat' => array(
                'font-family' => '"Montserrat", sans-serif',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
    'Roboto' => array(
                'font-family' => '"Roboto", sans-serif',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
    'Source Sans Pro' => array(
                'font-family' => '"Source Sans Pro", sans-serif',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
));

add_action( 'calibrefx_meta',  'webfont_load_fonts', 80);
add_action( 'wp_enqueue_scripts',  'webfont_styles');

if( is_admin() ){
    add_action( 'admin_init', 'webfont_load_colorpicker');
    add_action( 'calibrefx_theme_settings_meta_box', 'webfont_meta_boxes' );
    add_filter( 'calibrefx_theme_settings_defaults', 'webfont_theme_settings_default', 10, 1 );
    add_action( 'admin_init',  'webfont_admin_styles');
}

/********************
 * FUNCTIONS BELOW  *
 ********************/

function webfont_load_fonts() {
    global $fonts;

    $body_font = calibrefx_get_option('custom_font_family');
    $header_font = calibrefx_get_option('custom_header_font_family');
    $font_loaded = array();

    if(isset($fonts[$body_font]['google-font']) && $fonts[$body_font]['google-font']){
        $font_style = $fonts[$body_font]['google-font-style'];
        $font_name = str_replace(' ', '+', $body_font);
        $font_loaded[] = $font_name.':'.$font_style;
    }

    if(isset($fonts[$header_font]['google-font']) && $fonts[$header_font]['google-font']){
        $font_style = $fonts[$header_font]['google-font-style'];
        $font_name = str_replace(' ', '+', $header_font);
        $font_loaded[] = $font_name.':'.$font_style;
    }

    $font_loaded = implode('|', $font_loaded);
    if($font_loaded)
        echo '<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family='.$font_loaded.'" media="screen">';
}

function webfont_admin_styles(){
    wp_enqueue_style('webfont-style', CALIBREFX_URL . '/modules/custom-fonts/css/webfont.admin.css' );
}

function webfont_styles(){
    global $calibrefx, $fonts;

    wp_enqueue_style('webfont-style', CALIBREFX_URL . '/modules/custom-fonts/css/webfont.css' );
    
    $body_font = calibrefx_get_option('custom_font_family');
    $header_font = calibrefx_get_option('custom_header_font_family');
    $custom_font_size = calibrefx_get_option('custom_font_size');
    $custom_font_color = calibrefx_get_option('custom_font_color');
    $custom_permalink_color = calibrefx_get_option('custom_permalink_color');
    $custom_permalink_hover_color = calibrefx_get_option('custom_permalink_hover_color');

    if(!empty($custom_font_size)) 
        $fontsize = 'font-size: '.$custom_font_size.'px;';
    else
        $fontsize = 'font-size: inherit';

    if(!empty($custom_font_color)) 
        $fontcolor = 'color: '.$custom_font_color.';';
    else
        $fontcolor = 'color: inherit;';

    if(!empty($custom_permalink_color)) 
        $linkcolor = 'color: '.$custom_permalink_color.';';
    else
        $linkcolor = 'color: inherit;';

    if(!empty($custom_permalink_hover_color)) 
        $linkhovercolor = 'color: '.$custom_permalink_hover_color.';';
    else
        $linkhovercolor = 'color: inherit';

    if(!empty($body_font)){
        $fontfamily = $fonts[$body_font]['font-family'];
        if(!$fontfamily){
          $fontfamily = 'Helvetica, Arial, sans-serif;';
        }
        $fontfamily = 'font-family: ' . $fontfamily;
    }

    if(!empty($header_font)){
        $headerfontfamily = $fonts[$header_font]['font-family'];
        if(!$headerfontfamily){
          $headerfontfamily = 'Helvetica, Arial, sans-serif;';
        }
        $headerfontfamily = 'font-family: ' . $headerfontfamily;
    }

    $custom_css = "body{
    {$fontsize}
    {$fontcolor}
    {$fontfamily}
}
p, li, input, textarea, select, button{
    {$fontfamily}
}
h1, h2, h3, h4, h5, h6{
    {$headerfontfamily}
}
a, a:visited{
    {$linkcolor}
}
.post h2.entry-title a, .page h2.entry-title a, .page h1.entry-title a{
    {$linkcolor}
}
a:hover{
    {$linkhovercolor}
}
.post h2.entry-title a:hover, .page h2.entry-title a:hover, .page h1.entry-title a:hover{
    {$linkhovercolor}
}";

    wp_add_inline_style( 'webfont-style', $custom_css );
}

function webfont_load_colorpicker() {
    wp_enqueue_script('webfont-js', CALIBREFX_URL . '/modules/custom-fonts/js/webfont.js', array('jquery', 'wp-color-picker'), false, true);
}

function webfont_meta_boxes(){
    global $calibrefx;

    $calibrefx_target_form = apply_filters( 'calibrefx_target_form', 'options.php' );

    calibrefx_add_meta_section( 'design', __( 'Design Settings', 'calibrefx' ), $calibrefx_target_form, 5);
    calibrefx_add_meta_box('design', 'basic', 'webfont-typography', __('Typography Settings', 'calibrefx'), 'webfont_typography', $calibrefx->theme_settings->pagehook, 'main', 'low');
}

function webfont_typography(){
    global $fonts;
    $font_color = esc_attr(calibrefx_get_option('custom_font_color'));
    $permalink_color = esc_attr(calibrefx_get_option('custom_permalink_color'));
    $permalink_hover_color = esc_attr(calibrefx_get_option('custom_permalink_hover_color'));
?>
    <div class="section-row">
        <div class="section-col">
            
            <div class="section-line">
                <p><strong>Header Text Typography</strong></p>
                <div class="custom-font-style-wrapper">
                    <?php  $header_font_family = esc_attr(calibrefx_get_option('custom_header_font_family')); ?>
                    <select name="calibrefx-settings[custom_header_font_family]" id="calibrefx-settings[custom_header_font_family]">
                        <?php 
                            foreach ($fonts as $font => $value) {
                                $selected = ($header_font_family == $font)? ' selected="selected"' : '';
                                echo '<option value="' . $font . '"'.$selected.'>'.$font.'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
           
        </div>
        <div class="section-col last">
            <div class="section-desc">
                <p class="description">This setting is for all the header (h1, h2, etc.) text. Sizes will vary according to the css file</p>
            </div>
        </div>   
    </div>

    <div class="section-row">
        <div class="section-col">
            
            <div class="section-line">
                <p><strong>Body Text Typography</strong></p>
                <div class="custom-font-style-wrapper">
                    <select name="calibrefx-settings[custom_font_size]; ?>" id="calibrefx-settings[custom_font_size]; ?>">
                    <?php
                        $font_size = esc_attr(calibrefx_get_option('custom_font_size'));

                        for($i =9;$i<=24;$i++){
                            if($font_size == $i){
                                echo '<option value="'.$i.'" selected="selected">'.$i.'px</option>';
                            }else{
                                echo '<option value="'.$i.'">'.$i.'px</option>';
                            }
                        }
                    ?>
                    </select>
                    <?php  $font_family = calibrefx_get_option('custom_font_family'); ?>
                    <select name="calibrefx-settings[custom_font_family]; ?>" id="calibrefx-settings[custom_font_family]; ?>">
                        <?php 
                            foreach ($fonts as $font => $value) {
                                $selected = ($font_family == $font)? ' selected="selected"' : '';
                                echo '<option value="' . $font . '"'.$selected.'>'.$font.'</option>';
                            }

                        ?>
                    </select>
                    <input type="text" name="calibrefx-settings[custom_font_color]" id="custom_font_color" data-default-color="#0000ff" class="wp-color-picker-field" value="<?php echo $font_color; ?>" />
                </div>
            </div>
           
        </div>
        <div class="section-col last">
            <div class="section-desc">
                <p class="description">Please set this option if you want to use your custom styling for body text paragraph</p>
            </div>
        </div>   
    </div>

    <div class="section-row">
        <div class="section-col">
            
            <div class="section-line">
                <p><strong>Permalinks Color</strong></p>
                <div class="custom-font-style-wrapper">
                    <input type="text" name="calibrefx-settings[custom_permalink_color]" id="custom_permalink_color" data-default-color="#0000ff" class="wp-color-picker-field" value="<?php echo $permalink_color; ?>"/>
                </div>
            </div>
           
        </div>
        <div class="section-col last">
            <div class="section-desc">
                <p class="description">define your permalinks color here, please leave it blank by removing the color code, if you want to use pre-defined color.</p>
            </div>
        </div>   
    </div>

     <div class="section-row">
        <div class="section-col">
            
            <div class="section-line last">
                <p><strong>Permalinks Hover Color</strong></p>
                <div class="custom-font-style-wrapper">
                    <input type="text" name="calibrefx-settings[custom_permalink_hover_color]" id="custom_permalink_hover_color" data-default-color="#0000ff" class="wp-color-picker-field" value="<?php echo $permalink_hover_color; ?>" />
                    
                </div>
            </div>
           
        </div>
        <div class="section-col last">
            <div class="section-desc">
                <p class="description">define your permalinks hover color here, please leave it blank by removing thecolor code, if you want to use pre-defined color.</p>
            </div>
        </div>   
    </div>
<?php 
}

function webfont_theme_settings_default($default_arr = array()){
    $webfont_default = array(
        'custom_header_font_family' => 'Open Sans',
        'custom_font_size' => '14',
        'custom_font_family' => 'Open Sans',
        'custom_font_color' => '#404040',
        'custom_permalink_color' => '#08c',
        'custom_permalink_hover_color' => '#005580'
    );

    return array_merge($default_arr, $webfont_default);
}
