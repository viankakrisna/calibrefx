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
            'post_rewrite_title' => '%post_title%',
            'page_rewrite_title' => '%page_title%',
            'author_rewrite_title' => '%author_name% Profile &raquo; %site_title%',
            'category_rewrite_title' => '%category_title% &raquo; %site_title%',
            'archive_rewrite_title' => 'Archive: %date% &raquo; %site_title%',
            'tag_rewrite_title' => 'Tags: %tag% &raquo; %site_title%',
            'search_rewrite_title' => '%search% &raquo; %site_title%',
            '404_rewrite_title' => 'Nothing found for %request_words% &raquo; %site_title%',
            'post_description' => '%description%',
            'page_description' => '%description%',
            'author_description' => 'Profile Author: %author_name% in %site_title%',
            'search_description' => 'Search Result %search% in %site_title%',
            'category_description' => 'Page Category %category_title% for %site_title%',
            'archive_description' => 'Website Archive %date% for %site_title%',
            'tag_description' => 'Website Tag %tag% for %site_title%',
            '404_description' => 'Nothing found for %request_words%',
            'post_keywords' => '%keywords%',
            'page_keywords' => '%keywords%',
            'author_keywords' => '%author_name%',
            'search_keywords' => '%search%, article %search%, review %search%',
            'category_keywords' => '%category_title%, %category_title% articles, %category_title% list',
            'archive_keywords' => '%site_title% archive, %site_title% %date% archive ',
            'tag_keywords' => '%tag%, article %tag%, review %tag%',
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
        
        $CFX->security->add_sanitize_filter(
                'one_zero', 
                $this->settings_field,
                array(
                    'enable_seo',
                    'doc_canonical_url',
                    'doc_enable_rewrite_title',
                    'home_noindex',
                    'home_nofollow',
                    'home_noarchive',
                    'category_noindex',
                    'tag_noindex',
                    'author_noindex',
                    'date_noindex',
                    'search_noindex',
                    'category_noarchive',
                    'tag_noarchive',
                    'author_noarchive',
                    'date_noarchive',
                    'search_noarchive',
                    'site_noarchive',
                    'site_noodp',
                    'site_noydir',
                    'archive_canonical')
        );
        
        $CFX->security->add_sanitize_filter(
                'safe_text', 
                $this->settings_field,
                array(
                    'post_rewrite_title',
                    'page_rewrite_title',
                    'author_rewrite_title',
                    'category_rewrite_title',
                    'archive_rewrite_title',
                    'tag_rewrite_title',
                    'search_rewrite_title',
                    '404_rewrite_title',
                    'post_description',
                    'page_description',
                    'author_description',
                    'search_description',
                    'category_description',
                    'archive_description',
                    'tag_description',
                    '404_description',
                    'post_keywords',
                    'page_keywords',
                    'author_keywords',
                    'search_keywords',
                    'category_keywords',
                    'archive_keywords',
                    'tag_keywords',
                    '404_keywords',
                    'home_title',
                    'home_meta_description',
                    'home_meta_keywords')
        );
    }

    public function meta_sections() {
        global $calibrefx_current_section;

        calibrefx_clear_meta_section();

        calibrefx_add_meta_section('document', __('Document Settings', 'calibrefx'));
        calibrefx_add_meta_section('home', __('Homepage', 'calibrefx'));
        calibrefx_add_meta_section('robot', __('Robots', 'calibrefx'));
        calibrefx_add_meta_section('archive', __('Archive', 'calibrefx'));

        $calibrefx_current_section = 'document';
        if (!empty($_GET['section'])) {
            $calibrefx_current_section = sanitize_text_field($_GET['section']);
        }
    }

    public function meta_boxes() {
        calibrefx_add_meta_box('document', 'professor', 'calibrefx-seo-settings', __('SEO Settings', 'calibrefx'), array(&$this,'seo_settings_box'), $this->pagehook, 'main', 'high');
        calibrefx_add_meta_box('document', 'professor', 'calibrefx-seo-settings-document-title-settings', __('Document Title Settings', 'calibrefx'), array(&$this,'document_title_box'), $this->pagehook, 'main', 'high');
        calibrefx_add_meta_box('document', 'professor', 'calibrefx-seo-settings-document-description-settings', __('Document Description Settings', 'calibrefx'), array(&$this,'document_description_box'), $this->pagehook, 'main', 'high');
        calibrefx_add_meta_box('document', 'professor', 'calibrefx-seo-settings-document-keyword-settings', __('Document Keyword Settings', 'calibrefx'), array(&$this,'document_description_box'), $this->pagehook, 'main', 'high');

        calibrefx_add_meta_box('home', 'professor', 'calibrefx-seo-settings-home-settings', __('Home Settings', 'calibrefx'), array(&$this,'home_box'), $this->pagehook, 'main', 'high');

        calibrefx_add_meta_box('robot', 'professor', 'calibrefx-seo-settings-robot-meta-settings', __('Robot Meta Settings', 'calibrefx'), array(&$this,'robot_box'), $this->pagehook, 'main');

        calibrefx_add_meta_box('archive', 'professor', 'calibrefx-seo-settings-archive-settings', __('Archive Settings', 'calibrefx'), array(&$this,'archive_box'), $this->pagehook, 'main');
    }

    //Meta Boxes Sections
    
    /**
     * Show seo settings box
     */
    function seo_settings_box() { ?>
         <span class="description">
            You can disable the SEO feature if you want to use another SEO plugin by uncheck the checkbox below. 
        </span>
        <p>
            <input type="checkbox" name="<?php echo $this->settings_field; ?>[enable_seo]" id="<?php echo $this->settings_field; ?>[enable_seo]" value="1" <?php checked(1, calibrefx_get_option('enable_seo', $this->_model)); ?> /> <label for="<?php echo $this->settings_field; ?>[enable_seo]"><?php _e("Enable SEO Feature?", 'calibrefx'); ?></label><br/>
        </p>
        <?php
    }
    
    /**
     * Show document setting box
     */
    function document_title_box() {
        ?>
        <span class="description">
            The Document Title is the single most important SEO tag in your document source. It will tell search engines the information contained in the document. The doctitle changes from page to page, but these options will help you control what it looks by default.
        </span>
        <p>
            <input type="checkbox" name="<?php echo $this->settings_field; ?>[doc_canonical_url]" id="<?php echo $this->settings_field; ?>[doc_canonical_url]" value="1" <?php checked(1, calibrefx_get_option('doc_canonical_url', $this->_model)); ?> /> <label for="<?php echo $this->settings_field; ?>[doc_canonical_url]"><?php _e("Enable Canonical URL?", 'calibrefx'); ?></label><br/>
            <span class="description">This option will automatically generate Canonical URLS for your entire WordPress installation. This will help to prevent duplicate content penalties by Google.</span>
        </p>
        <p>
            <input type="checkbox" name="<?php echo $this->settings_field; ?>[doc_enable_rewrite_title]" id="<?php echo $this->settings_field; ?>[doc_enable_rewrite_title]" value="1" <?php checked(1, calibrefx_get_option('doc_enable_rewrite_title', $this->_model)); ?> /> <label for="<?php echo $this->settings_field; ?>[doc_enable_rewrite_title]"><?php _e("Enable Rewrite Title?", 'calibrefx'); ?></label><br/>
            <span class="description">This option will automatically generate title for your entire site (can be override from post).</span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[post_rewrite_title]"><?php _e('Post Rewrite Title:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php calibrefx_option('post_rewrite_title', $this->_model); ?>" id="<?php echo $this->settings_field; ?>[post_rewrite_title]" name="<?php echo $this->settings_field; ?>[post_rewrite_title]">
            <span class="description">This option will automatically generate title for your entire post.</span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[page_rewrite_title]"><?php _e('Page Rewrite Title:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php calibrefx_option('page_rewrite_title', $this->_model); ?>" id="<?php echo $this->settings_field; ?>[page_rewrite_title]" name="<?php echo $this->settings_field; ?>[page_rewrite_title]">
            <span class="description">This option will automatically generate title for your entire page.</span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[category_rewrite_title]"><?php _e('Category Rewrite Title:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php calibrefx_option('category_rewrite_title', $this->_model); ?>" id="<?php echo $this->settings_field; ?>[category_rewrite_title]" name="<?php echo $this->settings_field; ?>[category_rewrite_title]">
            <span class="description">This option will automatically generate title for your entire category.</span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[archive_rewrite_title]"><?php _e('Archive Rewrite Title:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php calibrefx_option('archive_rewrite_title', $this->_model); ?>" id="<?php echo $this->settings_field; ?>[archive_rewrite_title]" name="<?php echo $this->settings_field; ?>[archive_rewrite_title]">
            <span class="description">This option will automatically generate title for your entire archive.</span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[author_rewrite_title]"><?php _e('Author Rewrite Title:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php calibrefx_option('author_rewrite_title', $this->_model); ?>" id="<?php echo $this->settings_field; ?>[author_rewrite_title]" name="<?php echo $this->settings_field; ?>[author_rewrite_title]">
            <span class="description">This option will automatically generate title for author page.</span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[tag_rewrite_title]"><?php _e('Tag Rewrite Title:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php calibrefx_option('tag_rewrite_title', $this->_model); ?>" id="<?php echo $this->settings_field; ?>[tag_rewrite_title]" name="<?php echo $this->settings_field; ?>[tag_rewrite_title]">
            <span class="description">This option will automatically generate title for your entire tag page.</span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[search_rewrite_title]"><?php _e('Search Rewrite Title:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php calibrefx_option('search_rewrite_title', $this->_model); ?>" id="<?php echo $this->settings_field; ?>[search_rewrite_title]" name="<?php echo $this->settings_field; ?>[search_rewrite_title]">
            <span class="description">This option will automatically generate title for your Search page result.</span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[404_rewrite_title]"><?php _e('404 Rewrite Title:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php calibrefx_option('404_rewrite_title', $this->_model); ?>" id="<?php echo $this->settings_field; ?>[404_rewrite_title]" name="<?php echo $this->settings_field; ?>[404_rewrite_title]">
            <span class="description">This option will automatically generate title for your Search page result.</span>
        </p>
        <?php
    }

    /**
     * Show document setting box
     */
    function document_description_box() {
        ?>    
        <span class="description">
            The Document Description Format. It will tell search engines the information contained in the document.
        </span>

        <p>
            <label for="<?php echo $this->settings_field; ?>[post_description]"><?php _e('Post Description Format:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php calibrefx_option('post_description', $this->_model); ?>" id="<?php echo $this->settings_field; ?>[post_description]" name="<?php echo $this->settings_field; ?>[post_description]">
            <span class="description">This option will automatically generate description for your entire post.</span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[page_description]"><?php _e('Page Description Format:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php calibrefx_option('page_description', $this->_model); ?>" id="<?php echo $this->settings_field; ?>[page_description]" name="<?php echo $this->settings_field; ?>[page_description]">
            <span class="description">This option will automatically generate description for your entire page.</span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[search_description]"><?php _e('Search Description Format:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php calibrefx_option('search_description', $this->_model); ?>" id="<?php echo $this->settings_field; ?>[search_description]" name="<?php echo $this->settings_field; ?>[search_description]">
            <span class="description">This option will automatically generate description for your search page.</span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[category_description]"><?php _e('Category Description Format:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php calibrefx_option('category_description', $this->_model); ?>" id="<?php echo $this->settings_field; ?>[category_description]" name="<?php echo $this->settings_field; ?>[category_description]">
            <span class="description">This option will automatically generate description for your category page.</span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[author_description]"><?php _e('Author Description Format:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php calibrefx_option('author_description', $this->_model); ?>" id="<?php echo $this->settings_field; ?>[author_description]" name="<?php echo $this->settings_field; ?>[author_description]">
            <span class="description">This option will automatically generate description for your author page.</span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[archive_description]"><?php _e('Archive Description Format:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php calibrefx_option('archive_description', $this->_model); ?>" id="<?php echo $this->settings_field; ?>[archive_description]" name="<?php echo $this->settings_field; ?>[archive_description]">
            <span class="description">This option will automatically generate description for your archive page.</span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[tag_description]"><?php _e('Tag Description Format:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php calibrefx_option('tag_description', $this->_model); ?>" id="<?php echo $this->settings_field; ?>[tag_description]" name="<?php echo $this->settings_field; ?>[tag_description]">
            <span class="description">This option will automatically generate description for your tag page.</span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[404_description]"><?php _e('404 Page Description Format:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php calibrefx_option('404_description', $this->_model); ?>" id="<?php echo $this->settings_field; ?>[404_description]" name="<?php echo $this->settings_field; ?>[404_description]">
            <span class="description">This option will automatically generate description for your 404 page.</span>
        </p>
        <?php
    }

    /**
     * Show document setting box
     */
    function document_keyword_box() {
        ?>

        <span class="description">
            The Document Keywords Format. It will tell search engines the information contained in the document.
        </span>

        <p>
            <label for="<?php echo $this->settings_field; ?>[post_keywords]"><?php _e('Post Keywords Format:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php calibrefx_option('post_keywords', $this->_model); ?>" id="<?php echo $this->settings_field; ?>[post_keywords]" name="<?php echo $this->settings_field; ?>[post_keywords]">
            <span class="description">This option will automatically generate keywords for your entire post.</span>
        </p>

        <p>
            <label for="<?php echo $this->settings_field; ?>[post_keywords]"><?php _e('Post Keywords Format:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php calibrefx_option('post_keywords', $this->_model); ?>" id="<?php echo $this->settings_field; ?>[post_keywords]" name="<?php echo $this->settings_field; ?>[post_keywords]">
            <span class="description">This option will automatically generate keywords for your entire post.</span>
        </p>

        <p>
            <label for="<?php echo $this->settings_field; ?>[page_keywords]"><?php _e('Page Keywords Format:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php calibrefx_option('page_keywords', $this->_model); ?>" id="<?php echo $this->settings_field; ?>[page_keywords]" name="<?php echo $this->settings_field; ?>[page_keywords]">
            <span class="description">This option will automatically generate keywords for your entire page.</span>
        </p>

        <p>
            <label for="<?php echo $this->settings_field; ?>[author_keywords]"><?php _e('Author Keywords Format:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php calibrefx_option('author_keywords', $this->_model); ?>" id="<?php echo $this->settings_field; ?>[author_keywords]" name="<?php echo $this->settings_field; ?>[author_keywords]">
            <span class="description">This option will automatically generate keywords for your author page.</span>
        </p>

        <p>
            <label for="<?php echo $this->settings_field; ?>[search_keywords]"><?php _e('Search Keywords Format:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php calibrefx_option('search_keywords', $this->_model); ?>" id="<?php echo $this->settings_field; ?>[search_keywords]" name="<?php echo $this->settings_field; ?>[search_keywords]">
            <span class="description">This option will automatically generate keywords for your search page.</span>
        </p>

        <p>
            <label for="<?php echo $this->settings_field; ?>[archive_keywords]"><?php _e('Archive Keywords Format:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php calibrefx_option('archive_keywords', $this->_model); ?>" id="<?php echo $this->settings_field; ?>[archive_keywords]" name="<?php echo $this->settings_field; ?>[archive_keywords]">
            <span class="description">This option will automatically generate keywords for your archive page.</span>
        </p>

        <p>
            <label for="<?php echo $this->settings_field; ?>[tag_keywords]"><?php _e('Tag Keywords Format:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php calibrefx_option('tag_keywords', $this->_model); ?>" id="<?php echo $this->settings_field; ?>[tag_keywords]" name="<?php echo $this->settings_field; ?>[tag_keywords]">
            <span class="description">This option will automatically generate keywords for your tag archive page.</span>
        </p>

        <p>
            <label for="<?php echo $this->settings_field; ?>[404_keywords]"><?php _e('404 Keywords Format:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php calibrefx_option('404_keywords', $this->_model); ?>" id="<?php echo $this->settings_field; ?>[404_keywords]" name="<?php echo $this->settings_field; ?>[404_keywords]">
            <span class="description">This option will automatically generate keywords for your 404 page.</span>
        </p>
        <?php
    }

    /**
     * Show home setting box
     */
    function home_box() {
        ?>
        <span class="description">
            The Home Title is the single most important SEO tag in your document source. It will tell search engines the information contained in the document especially in your homepage.
        </span>
        <p>
            <label for="<?php echo $this->settings_field; ?>[home_title]"><?php _e('Home Title:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php calibrefx_option('home_title', $this->_model); ?>" id="<?php echo $this->settings_field; ?>[home_title]" name="<?php echo $this->settings_field; ?>[home_title]">
            <span class="description">If you leave the home title field blank, your site’s title will be used instead.</span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[home_meta_description]"><?php _e('Home Meta Description:', 'calibrefx'); ?></label>
            <textarea cols="70" rows="3" id="<?php echo $this->settings_field; ?>[home_meta_description]" name="<?php echo $this->settings_field; ?>[home_meta_description]"></textarea>
            <span class="description">If you leave the home title field blank, your site’s title will be used instead.</span>
        </p>
        <p>
            <label for="<?php echo $this->settings_field; ?>[home_meta_keywords]"><?php _e('Home Meta Keywords:', 'calibrefx'); ?></label>
            <input type="text" size="80" value="<?php calibrefx_option('home_meta_keywords', $this->_model); ?>" id="<?php echo $this->settings_field; ?>[home_meta_keywords]" name="<?php echo $this->settings_field; ?>[home_meta_keywords]">
            <span class="description">If you leave the home title field blank, your site’s title will be used instead.</span>
        </p>

        <h4>Homepage Robots Meta Tags:</h4>

        <p>
            <input type="checkbox" name="<?php echo $this->settings_field; ?>[home_noindex]" id="<?php echo $this->settings_field; ?>[home_noindex]" value="1" <?php checked(1, calibrefx_get_option('home_noindex', $this->_model)); ?> /> <label for="<?php echo $this->settings_field; ?>[home_noindex]"><?php _e("Apply <code>noindex</code> to the homepage?", 'calibrefx'); ?></label><br/>
            <input type="checkbox" name="<?php echo $this->settings_field; ?>[home_nofollow]" id="<?php echo $this->settings_field; ?>[home_nofollow]" value="1" <?php checked(1, calibrefx_get_option('home_nofollow', $this->_model)); ?> /> <label for="<?php echo $this->settings_field; ?>[home_nofollow]"><?php _e("Apply <code>nofollow</code> to the homepage?", 'calibrefx'); ?></label><br/>
            <input type="checkbox" name="<?php echo $this->settings_field; ?>[home_noarchive]" id="<?php echo $this->settings_field; ?>[home_noarchive]" value="1" <?php checked(1, calibrefx_get_option('home_noarchive', $this->_model)); ?> /> <label for="<?php echo $this->settings_field; ?>[home_noarchive]"><?php _e("Apply <code>noarchive</code> to the homepage?", 'calibrefx'); ?></label><br/>
        </p>
        <?php
    }

    /**
     * Show robot setting box
     */
    function robot_box() {
        ?>
        <span class="description">
            The Document Title is the single most important SEO tag in your document source. It succinctly informs search engines of what information is contained in the document. The doctitle changes from page to page, but these options will help you control what it looks by default.
        </span>
        <p>
            <input type="checkbox" name="<?php echo $this->settings_field; ?>[category_noindex]" id="<?php echo $this->settings_field; ?>[category_noindex]" value="1" <?php checked(1, calibrefx_get_option('category_noindex', $this->_model)); ?> /> <label for="<?php echo $this->settings_field; ?>[category_noindex]"><?php _e("Apply <code>noindex</code> to Category Archives?", 'calibrefx'); ?></label><br/>
            <input type="checkbox" name="<?php echo $this->settings_field; ?>[tag_noindex]" id="<?php echo $this->settings_field; ?>[tag_noindex]" value="1" <?php checked(1, calibrefx_get_option('tag_noindex', $this->_model)); ?> /> <label for="<?php echo $this->settings_field; ?>[tag_noindex]"><?php _e("Apply <code>noindex</code> to Tag Archives?", 'calibrefx'); ?></label><br/>
            <input type="checkbox" name="<?php echo $this->settings_field; ?>[author_noindex]" id="<?php echo $this->settings_field; ?>[author_noindex]" value="1" <?php checked(1, calibrefx_get_option('author_noindex', $this->_model)); ?> /> <label for="<?php echo $this->settings_field; ?>[author_noindex]"><?php _e("Apply <code>noindex</code> to Author Archives?", 'calibrefx'); ?></label><br/>
            <input type="checkbox" name="<?php echo $this->settings_field; ?>[date_noindex]" id="<?php echo $this->settings_field; ?>[date_noindex]" value="1" <?php checked(1, calibrefx_get_option('date_noindex', $this->_model)); ?> /> <label for="<?php echo $this->settings_field; ?>[date_noindex]"><?php _e("Apply <code>noindex</code> to Date Archives?", 'calibrefx'); ?></label><br/>
            <input type="checkbox" name="<?php echo $this->settings_field; ?>[search_noindex]" id="<?php echo $this->settings_field; ?>[search_noindex]" value="1" <?php checked(1, calibrefx_get_option('search_noindex', $this->_model)); ?> /> <label for="<?php echo $this->settings_field; ?>[search_noindex]"><?php _e("Apply <code>noindex</code> to Search Archives?", 'calibrefx'); ?></label><br/>
        </p>
        <span class="description">
            The Document Title is the single most important SEO tag in your document source. It succinctly informs search engines of what information is contained in the document. The doctitle changes from page to page, but these options will help you control what it looks by default.
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
            <input type="checkbox" name="<?php echo $this->settings_field; ?>[archive_canonical]" id="<?php echo $this->settings_field; ?>[archive_canonical]" value="1" <?php checked(1, calibrefx_get_option('archive_canonical', $this->_model)); ?> /> <label for="<?php echo $this->settings_field; ?>[archive_canonical]"><?php _e("Canonical Paginated Archives", 'calibrefx'); ?></label><br/>
        </p>
        <?php
    }

}