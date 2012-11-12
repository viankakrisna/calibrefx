<?php

/**
 * CalibreFx
 *
 * WordPress Themes Framework by CalibreWorks Team
 *
 * @package		CalibreFx
 * @author		CalibreWorks Team
 * @copyright           Copyright (c) 2012, Suntech Inti Perkasa.
 * @license		Commercial
 * @link		http://www.calibrefx.com
 * @since		Version 1.0
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 *
 * This File will handle theme-settings and provide default settings
 *
 * @package CalibreFx
 */

/**
 * Calibrefx Seo Setting Class
 *
 * @package		Calibrefx
 * @subpackage          Library
 * @author		CalibreWorks Team
 * @since		Version 1.0
 * @link		http://calibrefx.com
 */

class CFX_Seo_Settings extends CFX_Admin {

    /**
     * Constructor - Initializes
     */
    function __construct() {
        $this->page_id = 'calibrefx-seo';
        $this->default_settings = apply_filters('calibrefx_seo_settings_defaults', array(
            'enable_seo' => 1,
            'doc_canonical_url' => 1,
            'doc_enable_rewrite_title' => 1,
            'post_rewrite_title' => '%post_title% &raquo; %site_title%',
            'page_rewrite_title' => '%page_title% &raquo; %site_title%',
            'author_rewrite_title' => '%author_name% Profile &raquo; %site_title%',
            'category_rewrite_title' => '%category_title% &raquo; %site_title%',
            'archive_rewrite_title' => 'Archive: %date% &raquo; %site_title%',
            'tag_rewrite_title' => 'Tags: %tag% &raquo; %site_title%',
            'taxonomy_rewrite_title' => '%taxonomy%',
            'search_rewrite_title' => '%search% &raquo; %site_title%',
            '404_rewrite_title' => 'Nothing found for %request_words% &raquo; %site_title%',
            'post_description' => '%description%',
            'page_description' => '%description%',
            'author_description' => 'Profile Author: %author_name% in %site_title%',
            'search_description' => 'Search Result %search% in %site_title%',
            'category_description' => 'Page Category %category_title% for %site_title%',
            'archive_description' => 'Website Archive %date% for %site_title%',
            'tag_description' => 'Website Tag %tag% for %site_title%',
            'taxonomy_description' => '%taxonomy% &raquo; %site_title%',
            '404_description' => 'Nothing found for %request_words%',
            'post_keywords' => '%keywords%',
            'page_keywords' => '%keywords%',
            'author_keywords' => '%author_name%',
            'search_keywords' => '%search%, article %search%, review %search%',
            'category_keywords' => '%category_title%, %category_title% articles, %category_title% list',
            'archive_keywords' => '%site_title% archive, %site_title% %date% archive ',
            'tag_keywords' => '%tag%, article %tag%, review %tag%',
            'taxonomy_keywords' => '%taxonomy%, article %taxonomy%, review %taxonomy%',
            '404_keywords' => '%request_words% 404, %request_words% not found, %request_words% not available',
            'home_title' => '',
            'home_meta_description' => '',
            'home_meta_keywords' => '',
            'home_noindex' => 0,
            'home_nofollow' => 0,
            'home_noarchive' => 0,
            'category_noindex' => 0,
            'tag_noindex' => 0,
            'author_noindex' => 0,
            'date_noindex' => 0,
            'search_noindex' => 0,
            'category_noarchive' => 0,
            'tag_noarchive' => 0,
            'author_noarchive' => 0,
            'date_noarchive' => 0,
            'search_noarchive' => 0,
            'site_noarchive' => 0,
            'site_noodp' => 1,
            'site_noydir' => 1,
            'archive_canonical' => 1)
        );

        //we need to initialize the model
        $CFX = & calibrefx_get_instance();
        $CFX->load->model('seo_settings_m');
        $this->_model = & $CFX->seo_settings_m;

        $this->initialize();
    }
    
    /**
     * Register Our Security Filters
     *
     * $return void
     */
    public function security_filters(){
        $CFX = & calibrefx_get_instance();
        
//        $CFX->security->add_sanitize_filter(
//                'one_zero', 
//                $this->settings_field,
//                array(
//                    'enable_seo',
//                    'doc_canonical_url',
//                    'doc_enable_rewrite_title',
//                    'home_noindex',
//                    'home_nofollow',
//                    'home_noarchive',
//                    'category_noindex',
//                    'tag_noindex',
//                    'author_noindex',
//                    'date_noindex',
//                    'search_noindex',
//                    'category_noarchive',
//                    'tag_noarchive',
//                    'author_noarchive',
//                    'date_noarchive',
//                    'search_noarchive',
//                    'site_noarchive',
//                    'site_noodp',
//                    'site_noydir',
//                    'archive_canonical')
//        );
//        
//        $CFX->security->add_sanitize_filter(
//                'safe_text', 
//                $this->settings_field,
//                array(
//                    'post_description',
//                    'page_description',
//                    'author_description',
//                    'search_description',
//                    'category_description',
//                    'archive_description',
//                    'tag_description',
//                    '404_description',
//                    'post_keywords',
//                    'page_keywords',
//                    'author_keywords',
//                    'search_keywords',
//                    'category_keywords',
//                    'archive_keywords',
//                    'tag_keywords',
//                    '404_keywords',
//                    'home_title',
//                    'home_meta_description',
//                    'home_meta_keywords')
//        );
    }

    public function meta_sections() {
        global $calibrefx_current_section;

        calibrefx_clear_meta_section();

        calibrefx_add_meta_section('document', __('Document Settings', 'calibrefx'));
        calibrefx_add_meta_section('robot', __('Robots', 'calibrefx'));
        calibrefx_add_meta_section('archive', __('Archive', 'calibrefx'));

        $calibrefx_current_section = 'document';
        if (!empty($_GET['section'])) {
            $calibrefx_current_section = sanitize_text_field($_GET['section']);
        }
    }

    public function meta_boxes() {
        calibrefx_add_meta_box('document', 'professor', 'calibrefx-seo-settings', __('SEO Settings', 'calibrefx'), array(&$this,'seo_settings_box'), $this->pagehook, 'main', 'high');
        calibrefx_add_meta_box('document', 'professor', 'calibrefx-seo-settings-home-settings', __('Home Settings', 'calibrefx'), array(&$this,'home_box'), $this->pagehook, 'main', 'high');
        calibrefx_add_meta_box('document', 'professor', 'calibrefx-seo-settings-document-title-settings', __('Document Title Settings', 'calibrefx'), array(&$this,'document_title_box'), $this->pagehook, 'side', 'high');
        calibrefx_add_meta_box('document', 'professor', 'calibrefx-seo-settings-document-description-settings', __('Document Description Settings', 'calibrefx'), array(&$this,'document_description_box'), $this->pagehook, 'main', 'high');
        calibrefx_add_meta_box('document', 'professor', 'calibrefx-seo-settings-document-keyword-settings', __('Document Keyword Settings', 'calibrefx'), array(&$this,'document_description_box'), $this->pagehook, 'side', 'high');

        calibrefx_add_meta_box('robot', 'professor', 'calibrefx-seo-settings-robot-meta-settings', __('Robot Meta Settings', 'calibrefx'), array(&$this,'robot_box'), $this->pagehook, 'main');

        calibrefx_add_meta_box('archive', 'professor', 'calibrefx-seo-settings-archive-settings', __('Archive Settings', 'calibrefx'), array(&$this,'archive_box'), $this->pagehook, 'main');
    }

    //Meta Boxes Sections
    
    /**
     * Show seo settings box
     */
    function seo_settings_box() { ?>
        <p>
            <input type="checkbox" name="<?php echo $this->settings_field; ?>[enable_seo]" id="<?php echo $this->settings_field; ?>[enable_seo]" value="1" <?php checked(1, calibrefx_get_option('enable_seo', $this->_model)); ?> /> <label for="<?php echo $this->settings_field; ?>[enable_seo]"><?php _e("Enable SEO Feature?", 'calibrefx'); ?></label><br/>
            <span class="description">
                You can disable the SEO feature if you want to use another SEO plugin by uncheck the checkbox below. 
            </span>
        </p>
        <p>
            <input type="checkbox" name="<?php echo $this->settings_field; ?>[doc_canonical_url]" id="<?php echo $this->settings_field; ?>[doc_canonical_url]" value="1" <?php checked(1, calibrefx_get_option('doc_canonical_url', $this->_model)); ?> /> <label for="<?php echo $this->settings_field; ?>[doc_canonical_url]"><?php _e("Enable Canonical URL?", 'calibrefx'); ?></label><br/>
            <span class="description">This option will automatically generate Canonical URLS for your entire WordPress installation. This will help to prevent duplicate content penalties by Search Engine.</span>
        </p>
        <?php
    }
    
    /**
     * Show document setting box
     */
    function document_title_box() {
        ?>
        <span class="description">
            Document Title will defined your page headline (title) which is the single most important SEO tag in your document source. It will tell search engines the information contained in the document. The doctitle changes from page to page, but these options will help you control what it looks by default.
        </span>
        <p>
            <input type="checkbox" name="<?php echo $this->settings_field; ?>[doc_enable_rewrite_title]" id="<?php echo $this->settings_field; ?>[doc_enable_rewrite_title]" value="1" <?php checked(1, calibrefx_get_option('doc_enable_rewrite_title', $this->_model)); ?> /> <label for="<?php echo $this->settings_field; ?>[doc_enable_rewrite_title]"><?php _e("Enable Rewrite Title?", 'calibrefx'); ?></label><br/>
            <span class="description">This option will automatically generate title for your entire site. If disable it will use the default title from WordPress.</span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[post_rewrite_title]"><?php _e('Post Rewrite Title:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php echo $this->_model->get('post_rewrite_title'); ?>" id="<?php echo $this->settings_field; ?>[post_rewrite_title]" name="<?php echo $this->settings_field; ?>[post_rewrite_title]">
            <span class="description">This option will automatically generate title for entire post (can be override from the post editor).</span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[page_rewrite_title]"><?php _e('Page Rewrite Title:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php echo $this->_model->get('page_rewrite_title'); ?>" id="<?php echo $this->settings_field; ?>[page_rewrite_title]" name="<?php echo $this->settings_field; ?>[page_rewrite_title]">
            <span class="description">This option will automatically generate title for entire page (can be override from the post editor).</span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[category_rewrite_title]"><?php _e('Category Rewrite Title:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php echo $this->_model->get('category_rewrite_title'); ?>" id="<?php echo $this->settings_field; ?>[category_rewrite_title]" name="<?php echo $this->settings_field; ?>[category_rewrite_title]">
            <span class="description">This option will automatically generate title for entire category page.</span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[archive_rewrite_title]"><?php _e('Archive Rewrite Title:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php echo $this->_model->get('archive_rewrite_title'); ?>" id="<?php echo $this->settings_field; ?>[archive_rewrite_title]" name="<?php echo $this->settings_field; ?>[archive_rewrite_title]">
            <span class="description">This option will automatically generate title for entire archive page (ex: date page).</span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[author_rewrite_title]"><?php _e('Author Rewrite Title:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php echo $this->_model->get('author_rewrite_title'); ?>" id="<?php echo $this->settings_field; ?>[author_rewrite_title]" name="<?php echo $this->settings_field; ?>[author_rewrite_title]">
            <span class="description">This option will automatically generate title for author page (can be override from the user profile).</span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[tag_rewrite_title]"><?php _e('Tag Rewrite Title:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php echo $this->_model->get('tag_rewrite_title'); ?>" id="<?php echo $this->settings_field; ?>[tag_rewrite_title]" name="<?php echo $this->settings_field; ?>[tag_rewrite_title]">
            <span class="description">This option will automatically generate title for entire tag page.</span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[taxonomy_rewrite_title]"><?php _e('Taxonomy Rewrite Title:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php echo $this->_model->get('taxonomy_rewrite_title'); ?>" id="<?php echo $this->settings_field; ?>[taxonomy_rewrite_title]" name="<?php echo $this->settings_field; ?>[taxonomy_rewrite_title]">
            <span class="description">This option will automatically generate title for entire custom taxonomy page.</span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[search_rewrite_title]"><?php _e('Search Rewrite Title:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php echo $this->_model->get('search_rewrite_title'); ?>" id="<?php echo $this->settings_field; ?>[search_rewrite_title]" name="<?php echo $this->settings_field; ?>[search_rewrite_title]">
            <span class="description">This option will automatically generate title for Search page result.</span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[404_rewrite_title]"><?php _e('404 Rewrite Title:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php echo $this->_model->get('404_rewrite_title'); ?>" id="<?php echo $this->settings_field; ?>[404_rewrite_title]" name="<?php echo $this->settings_field; ?>[404_rewrite_title]">
            <span class="description">This option will automatically generate title for your Not Found (404) Page.</span>
        </p>
        <?php
    }

    /**
     * Show document setting box
     */
    function document_description_box() {
        ?>    
        <span class="description">
            Document Description will defined your page summary which is the one of most important SEO information in your document source. It will tell search engines the information contained in the document. The description change from page to page, but these options will help you control what it looks by default.
        </span>

        <p>
            <label for="<?php echo $this->settings_field; ?>[post_description]"><?php _e('Post Description Format:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php echo $this->_model->get('post_description'); ?>" id="<?php echo $this->settings_field; ?>[post_description]" name="<?php echo $this->settings_field; ?>[post_description]">
            <span class="description">This option will automatically generate description format for entire post.</span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[page_description]"><?php _e('Page Description Format:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php echo $this->_model->get('page_description'); ?>" id="<?php echo $this->settings_field; ?>[page_description]" name="<?php echo $this->settings_field; ?>[page_description]">
            <span class="description">This option will automatically generate description format for entire page.</span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[search_description]"><?php _e('Search Description Format:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php echo $this->_model->get('search_description'); ?>" id="<?php echo $this->settings_field; ?>[search_description]" name="<?php echo $this->settings_field; ?>[search_description]">
            <span class="description">This option will automatically generate description format for search page.</span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[category_description]"><?php _e('Category Description Format:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php echo $this->_model->get('category_description'); ?>" id="<?php echo $this->settings_field; ?>[category_description]" name="<?php echo $this->settings_field; ?>[category_description]">
            <span class="description">This option will automatically generate description format for category page.</span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[author_description]"><?php _e('Author Description Format:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php echo $this->_model->get('author_description'); ?>" id="<?php echo $this->settings_field; ?>[author_description]" name="<?php echo $this->settings_field; ?>[author_description]">
            <span class="description">This option will automatically generate description format for author page.</span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[archive_description]"><?php _e('Archive Description Format:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php echo $this->_model->get('archive_description'); ?>" id="<?php echo $this->settings_field; ?>[archive_description]" name="<?php echo $this->settings_field; ?>[archive_description]">
            <span class="description">This option will automatically generate description format for archive page.</span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[tag_description]"><?php _e('Tag Description Format:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php echo $this->_model->get('tag_description'); ?>" id="<?php echo $this->settings_field; ?>[tag_description]" name="<?php echo $this->settings_field; ?>[tag_description]">
            <span class="description">This option will automatically generate description format for tag page.</span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[taxonomy_description]"><?php _e('Taxonomy Description Format:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php echo $this->_model->get('taxonomy_description'); ?>" id="<?php echo $this->settings_field; ?>[taxonomy_description]" name="<?php echo $this->settings_field; ?>[taxonomy_description]">
            <span class="description">This option will automatically generate description format for custom taxonomy page.</span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[404_description]"><?php _e('404 Page Description Format:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php echo $this->_model->get('404_description'); ?>" id="<?php echo $this->settings_field; ?>[404_description]" name="<?php echo $this->settings_field; ?>[404_description]">
            <span class="description">This option will automatically generate description format for 404 page.</span>
        </p>
        <?php
    }

    /**
     * Show document setting box
     */
    function document_keyword_box() {
        ?>

        <span class="description">
            The Document Keywords Format. It will tell search engines the keyword information contained in the document.
        </span>

        <p>
            <label for="<?php echo $this->settings_field; ?>[post_keywords]"><?php _e('Post Keywords Format:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php echo $this->_model->get('post_keywords'); ?>" id="<?php echo $this->settings_field; ?>[post_keywords]" name="<?php echo $this->settings_field; ?>[post_keywords]">
            <span class="description">This option will automatically generate keywords format for tire post.</span>
        </p>

        <p>
            <label for="<?php echo $this->settings_field; ?>[post_keywords]"><?php _e('Post Keywords Format:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php echo $this->_model->get('post_keywords'); ?>" id="<?php echo $this->settings_field; ?>[post_keywords]" name="<?php echo $this->settings_field; ?>[post_keywords]">
            <span class="description">This option will automatically generate keywords format for entire post.</span>
        </p>

        <p>
            <label for="<?php echo $this->settings_field; ?>[page_keywords]"><?php _e('Page Keywords Format:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php echo $this->_model->get('page_keywords'); ?>" id="<?php echo $this->settings_field; ?>[page_keywords]" name="<?php echo $this->settings_field; ?>[page_keywords]">
            <span class="description">This option will automatically generate keywords format for entire page.</span>
        </p>

        <p>
            <label for="<?php echo $this->settings_field; ?>[author_keywords]"><?php _e('Author Keywords Format:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php echo $this->_model->get('author_keywords'); ?>" id="<?php echo $this->settings_field; ?>[author_keywords]" name="<?php echo $this->settings_field; ?>[author_keywords]">
            <span class="description">This option will automatically generate keywords format for author page.</span>
        </p>

        <p>
            <label for="<?php echo $this->settings_field; ?>[search_keywords]"><?php _e('Search Keywords Format:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php echo $this->_model->get('search_keywords'); ?>" id="<?php echo $this->settings_field; ?>[search_keywords]" name="<?php echo $this->settings_field; ?>[search_keywords]">
            <span class="description">This option will automatically generate keywords format for search page.</span>
        </p>

        <p>
            <label for="<?php echo $this->settings_field; ?>[archive_keywords]"><?php _e('Archive Keywords Format:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php echo $this->_model->get('archive_keywords'); ?>" id="<?php echo $this->settings_field; ?>[archive_keywords]" name="<?php echo $this->settings_field; ?>[archive_keywords]">
            <span class="description">This option will automatically generate keywords format for archive page.</span>
        </p>

        <p>
            <label for="<?php echo $this->settings_field; ?>[tag_keywords]"><?php _e('Tag Keywords Format:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php echo $this->_model->get('tag_keywords'); ?>" id="<?php echo $this->settings_field; ?>[tag_keywords]" name="<?php echo $this->settings_field; ?>[tag_keywords]">
            <span class="description">This option will automatically generate keywords format for tag archive page.</span>
        </>
        
        <p>
            <label for="<?php echo $this->settings_field; ?>[taxonomy_keywords]"><?php _e('Taxonomy Keywords Format:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php echo $this->_model->get('taxonomy_keywords'); ?>" id="<?php echo $this->settings_field; ?>[taxonomy_keywords]" name="<?php echo $this->settings_field; ?>[taxonomy_keywords]">
            <span class="description">This option will automatically generate keywords format for tag archive page.</span>
        </p>

        <p>
            <label for="<?php echo $this->settings_field; ?>[404_keywords]"><?php _e('404 Keywords Format:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php echo $this->_model->get('404_keywords'); ?>" id="<?php echo $this->settings_field; ?>[404_keywords]" name="<?php echo $this->settings_field; ?>[404_keywords]">
            <span class="description">This option will automatically generate keywords format for 404 page.</span>
        </p>
        <?php
    }

    /**
     * Show home setting box
     */
    function home_box() {
        ?>
        <span class="description">
            The Home Title will define your homapge title. It will tell search engines the information contained for your entire website especially in your homepage.
        </span>
        <p>
            <label for="<?php echo $this->settings_field; ?>[home_title]"><?php _e('Home Title:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php echo $this->_model->get('home_title'); ?>" id="<?php echo $this->settings_field; ?>[home_title]" name="<?php echo $this->settings_field; ?>[home_title]">
            <span class="description">If you leave the home title field blank, your site’s title will be used instead.</span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[home_meta_description]"><?php _e('Home Meta Description:', 'calibrefx'); ?></label>
            <textarea cols="70" rows="3" id="<?php echo $this->settings_field; ?>[home_meta_description]" name="<?php echo $this->settings_field; ?>[home_meta_description]"><?php echo $this->_model->get('home_meta_description'); ?></textarea>
            <span class="description">If you leave the home title field blank, your site’s title will be used instead.</span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[home_meta_keywords]"><?php _e('Home Meta Keywords:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php echo $this->_model->get('home_meta_keywords'); ?>" id="<?php echo $this->settings_field; ?>[home_meta_keywords]" name="<?php echo $this->settings_field; ?>[home_meta_keywords]">
            <span class="description">If you leave the home title field blank, your site’s title will be used instead.</span>
        </p>

        <h4>Homepage Robots Meta Tags:</h4>

        <p>
            <input type="checkbox" name="<?php echo $this->settings_field; ?>[home_noindex]" id="<?php echo $this->settings_field; ?>[home_noindex]" value="1" <?php checked(1, calibrefx_get_option('home_noindex', $this->_model)); ?> /> <label for="<?php echo $this->settings_field; ?>[home_noindex]"><?php _e("Apply <code>noindex</code> to the homepage?", 'calibrefx'); ?></label>
            <span class="description">You can apply noindex for your homepage. Warning: Leave this uncheck if you don't understand.</span><br/>
            <input type="checkbox" name="<?php echo $this->settings_field; ?>[home_nofollow]" id="<?php echo $this->settings_field; ?>[home_nofollow]" value="1" <?php checked(1, calibrefx_get_option('home_nofollow', $this->_model)); ?> /> <label for="<?php echo $this->settings_field; ?>[home_nofollow]"><?php _e("Apply <code>nofollow</code> to the homepage?", 'calibrefx'); ?></label>
            <span class="description">You can apply nofollow for your homepage. Warning: Leave this uncheck if you don't understand.</span><br/>
            <input type="checkbox" name="<?php echo $this->settings_field; ?>[home_noarchive]" id="<?php echo $this->settings_field; ?>[home_noarchive]" value="1" <?php checked(1, calibrefx_get_option('home_noarchive', $this->_model)); ?> /> <label for="<?php echo $this->settings_field; ?>[home_noarchive]"><?php _e("Apply <code>noarchive</code> to the homepage?", 'calibrefx'); ?></label>
            <span class="description">You can apply noarchive for your homepage. Warning: Leave this uncheck if you don't understand.</span><br/>
        </p>
        <?php
    }

    /**
     * Show robot setting box
     */
    function robot_box() {
        ?>
        <span class="description">
            Robot Meta Noindex will tell the search engine not to index certain page in your website. This option will avoid duplicate content penalty. But use it wisely.
        </span>
        <p>
            <input type="checkbox" name="<?php echo $this->settings_field; ?>[category_noindex]" id="<?php echo $this->settings_field; ?>[category_noindex]" value="1" <?php checked(1, calibrefx_get_option('category_noindex', $this->_model)); ?> /> <label for="<?php echo $this->settings_field; ?>[category_noindex]"><?php _e("Apply <code>noindex</code> to Category Archives?", 'calibrefx'); ?></label><br/>
            <input type="checkbox" name="<?php echo $this->settings_field; ?>[tag_noindex]" id="<?php echo $this->settings_field; ?>[tag_noindex]" value="1" <?php checked(1, calibrefx_get_option('tag_noindex', $this->_model)); ?> /> <label for="<?php echo $this->settings_field; ?>[tag_noindex]"><?php _e("Apply <code>noindex</code> to Tag Archives?", 'calibrefx'); ?></label><br/>
            <input type="checkbox" name="<?php echo $this->settings_field; ?>[author_noindex]" id="<?php echo $this->settings_field; ?>[author_noindex]" value="1" <?php checked(1, calibrefx_get_option('author_noindex', $this->_model)); ?> /> <label for="<?php echo $this->settings_field; ?>[author_noindex]"><?php _e("Apply <code>noindex</code> to Author Archives?", 'calibrefx'); ?></label><br/>
            <input type="checkbox" name="<?php echo $this->settings_field; ?>[date_noindex]" id="<?php echo $this->settings_field; ?>[date_noindex]" value="1" <?php checked(1, calibrefx_get_option('date_noindex', $this->_model)); ?> /> <label for="<?php echo $this->settings_field; ?>[date_noindex]"><?php _e("Apply <code>noindex</code> to Date Archives?", 'calibrefx'); ?></label><br/>
            <input type="checkbox" name="<?php echo $this->settings_field; ?>[search_noindex]" id="<?php echo $this->settings_field; ?>[search_noindex]" value="1" <?php checked(1, calibrefx_get_option('search_noindex', $this->_model)); ?> /> <label for="<?php echo $this->settings_field; ?>[search_noindex]"><?php _e("Apply <code>noindex</code> to Search Archives?", 'calibrefx'); ?></label><br/>
        </p>
        <span class="description">
            Robot Meta Noarchive will tell the search engine not to archive certain page in your website. This option will avoid duplicate content penalty. But use it wisely.
        </span>
        <p>
            <input type="checkbox" name="<?php echo $this->settings_field; ?>[category_noarchive]" id="<?php echo $this->settings_field; ?>[category_noarchive]" value="1" <?php checked(1, calibrefx_get_option('category_noarchive', $this->_model)); ?> /> <label for="<?php echo $this->settings_field; ?>[category_noarchive]"><?php _e("Apply <code>noarchive</code> to Category Archives?", 'calibrefx'); ?></label><br/>
            <input type="checkbox" name="<?php echo $this->settings_field; ?>[tag_noarchive]" id="<?php echo $this->settings_field; ?>[tag_noarchive]" value="1" <?php checked(1, calibrefx_get_option('tag_noarchive', $this->_model)); ?> /> <label for="<?php echo $this->settings_field; ?>[tag_noarchive]"><?php _e("Apply <code>noarchive</code> to Tag Archives?", 'calibrefx'); ?></label><br/>
            <input type="checkbox" name="<?php echo $this->settings_field; ?>[author_noarchive]" id="<?php echo $this->settings_field; ?>[author_noarchive]" value="1" <?php checked(1, calibrefx_get_option('author_noarchive', $this->_model)); ?> /> <label for="<?php echo $this->settings_field; ?>[author_noarchive]"><?php _e("Apply <code>noarchive</code> to Author Archives?", 'calibrefx'); ?></label><br/>
            <input type="checkbox" name="<?php echo $this->settings_field; ?>[date_noarchive]" id="<?php echo $this->settings_field; ?>[date_noarchive]" value="1" <?php checked(1, calibrefx_get_option('date_noarchive', $this->_model)); ?> /> <label for="<?php echo $this->settings_field; ?>[date_noarchive]"><?php _e("Apply <code>noarchive</code> to Date Archives?", 'calibrefx'); ?></label><br/>
            <input type="checkbox" name="<?php echo $this->settings_field; ?>[search_noarchive]" id="<?php echo $this->settings_field; ?>[search_noarchive]" value="1" <?php checked(1, calibrefx_get_option('search_noarchive', $this->_model)); ?> /> <label for="<?php echo $this->settings_field; ?>[search_noarchive]"><?php _e("Apply <code>noarchive</code> to Search Archives?", 'calibrefx'); ?></label><br/>
        </p>
        <p>
            <span class="description">Occasionally, search engines use resources like the Open Directory Project and the Yahoo! Directory to find titles and descriptions for your content. Generally, you will not want them to do this. The <code>noodp</code> and <code>noydir</code> tags prevent them from doing so.</span>
        </p>
        <p>
            <input type="checkbox" name="<?php echo $this->settings_field; ?>[site_noarchive]" id="<?php echo $this->settings_field; ?>[site_noarchive]" value="1" <?php checked(1, calibrefx_get_option('site_noarchive', $this->_model)); ?> /> <label for="<?php echo $this->settings_field; ?>[site_noarchive]"><?php _e("Apply <code>noarchive</code> to your site?", 'calibrefx'); ?></label><br/>
            <input type="checkbox" name="<?php echo $this->settings_field; ?>[site_noodp]" id="<?php echo $this->settings_field; ?>[site_noodp]" value="1" <?php checked(1, calibrefx_get_option('site_noodp', $this->_model)); ?> /> <label for="<?php echo $this->settings_field; ?>[site_noodp]"><?php _e("Apply <code>noodp</code> to your site?", 'calibrefx'); ?></label><br/>
            <input type="checkbox" name="<?php echo $this->settings_field; ?>[site_noydir]" id="<?php echo $this->settings_field; ?>[site_noydir]" value="1" <?php checked(1, calibrefx_get_option('site_noydir', $this->_model)); ?> /> <label for="<?php echo $this->settings_field; ?>[site_noydir]"><?php _e("Apply <code>noydir</code> to your site?", 'calibrefx'); ?></label><br/>
        </p>

        <?php
    }

    /**
     * Show archive setting box
     */
    function archive_box() {
        ?>
        <p>
            <input type="checkbox" name="<?php echo $this->settings_field; ?>[archive_canonical]" id="<?php echo $this->settings_field; ?>[archive_canonical]" value="1" <?php checked(1, $this->_model->get('archive_canonical')); ?> /> <label for="<?php echo $this->settings_field; ?>[archive_canonical]"><?php _e("Canonical Paginated Archives", 'calibrefx'); ?></label><br/>
            <span class="description">This option will output canonical url for the paginated page. So the paginated page will canonical to the first page. This will avoid duplicate content for the archive page.</span>
        </p>
        <?php
    }

}