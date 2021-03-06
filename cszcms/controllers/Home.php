<?php

defined('BASEPATH') or exit('No direct script access allowed');
/**
 * CSZ CMS
 *
 * An open source content management system
 *
 * Copyright (c) 2016 - 2017, Astian Foundation.
 *
 * Astian Develop Public License (ADPL)
 * 
 * This Source Code Form is subject to the terms of the Astian Develop Public
 * License, v. 1.0. If a copy of the APL was not distributed with this
 * file, You can obtain one at http://astian.org/about-ADPL
 * 
 * @author	CSKAZA
 * @copyright   Copyright (c) 2016 - 2017, Astian Foundation.
 * @license	http://astian.org/about-ADPL	ADPL License
 * @link	https://www.cszcms.com
 * @since	Version 1.0.0
 */
class Home extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     * $this->template->set_template('template_name'); to use another one, 
     * before $this->template->load('index_page', array('view' => 'data'));
     * ---
     * OR
     * $this->template->load('index_page', array('view' => 'data'), 'template_name'); If template file name is 'main'
     */
    var $page_rs;
    var $page_url;

    function __construct()
    {
        parent::__construct();
        $this->CI = &get_instance();
        $this->load->database();
        $row = $this->Csz_model->load_config();
        if ($row->themes_config) {
            $this->template->set_template($row->themes_config);
        }
        if (!$this->session->userdata('fronlang_iso')) {
            $this->Csz_model->setSiteLang();
        }
        if ($this->Csz_model->chkLangAlive($this->session->userdata('fronlang_iso')) == 0) {
            $this->session->unset_userdata('fronlang_iso');
            $this->Csz_model->setSiteLang();
        }
        $this->_init();
    }

    public function _init()
    {
        $row = $this->Csz_model->load_config();
        $pageURL = $this->Csz_model->getCurPages();
        if (strpos($pageURL, 'plugin') !== FALSE) {
            redirect($this->Csz_model->base_link() . '/' . $pageURL);
        }
        $this->page_url = $pageURL;
        $this->page_rs = $this->Csz_model->load_page($pageURL);
        $page_rs = $this->page_rs;
        $this->template->set('title', 'ContratosLegal.com');
        $this->template->set('additional_js', $row->additional_js);
        $this->template->set('additional_metatag', $row->additional_metatag);
        if ($row->maintenance_active) {
            $this->template->set('core_css', $this->Csz_model->coreCss());
            $this->template->set('core_js', $this->Csz_model->coreJs());
            $title = $this->Csz_model->pagesTitle($this->Csz_model->getLabelLang('site_maintenance_title'));
            $this->template->set('title', 'ContratosLegal.com');
            $this->template->set('meta_tags', $this->Csz_model->coreMetatags($this->Csz_model->getLabelLang('site_maintenance_subtitle'), $row->keywords, $title));
            $this->template->set('cur_page', $pageURL);
        } else {
            if ($page_rs !== FALSE) {
                Member_helper::is_allow_groups($page_rs->user_groups_idS);
                $this->template->set('core_css', $this->Csz_model->coreCss($page_rs->custom_css, FALSE));
                $this->template->set('core_js', $this->Csz_model->coreJs($page_rs->custom_js, FALSE));
                $title = $this->Csz_model->pagesTitle($page_rs->page_title);
                $this->template->set('title', 'ContratosLegal.com');
                $this->template->set('meta_tags', $this->Csz_model->coreMetatags($page_rs->page_desc, $page_rs->page_keywords, $title, '', $page_rs->more_metatag));
                $this->template->set('cur_page', $page_rs->page_url);
            } else {
                $this->template->set('core_css', $this->Csz_model->coreCss());
                $this->template->set('core_js', $this->Csz_model->coreJs());
                $title = $this->Csz_model->pagesTitle($this->Csz_model->getLabelLang('site_error_404_title'));
                $this->template->set('title', 'ContratosLegal.com');
                $this->template->set('meta_tags', $this->Csz_model->coreMetatags($this->Csz_model->getLabelLang('site_error_404_title'), $row->keywords, $title));
                $this->template->set('cur_page', $pageURL);
            }
        }
    }

    public function index()
    {
        $config = $this->Csz_model->load_config();
        if ($config->maintenance_active) {
            $this->template->loadFrontViews('static/maintenance');
        } else {

            $this->template->loadFrontViews('home/home');

            if ($this->Csz_model->findFrmTag($this->output->get_output(), TRUE) !== false) {
                /* For CSRF Protection on page (random CSRF token not use cache) */
                $config->pagecache_time = 0;
            }
            if ($this->uri->segment(1) && $config->pagecache_time != 0) {
                $this->db->cache_on();
                $this->output->cache($config->pagecache_time);
            }
        }
    }

    public function error_404()
    {
        $config = $this->Csz_model->load_config();
        if ($config->maintenance_active) {
            $this->template->loadFrontViews('static/maintenance');
        } else {
            set_status_header(404);
            $html = '<center>
                        <h1 style="font-size:120px;color:red;">404</h1>
                        <h2>' . $this->Csz_model->getLabelLang('site_error_404_title') . '</h2><br>
                        <p>' . $this->Csz_model->getLabelLang('site_error_404_text') . '</p><br>
                        <a class="btn btn-primary btn-lg" href="' . base_url() . '" role="button">' . $this->Csz_model->getLabelLang('btn_back') . ' &raquo;</a>
                    </center><script>setTimeout(function(){window.location.href="' . base_url() . '";},15000);</script>';
            $this->template->setSub('content', $html);
            //Load the view
            $this->template->loadFrontViews('static/error404');
            if ($config->pagecache_time != 0) {
                $this->db->cache_on();
                $this->output->cache($config->pagecache_time);
            }
        }
    }

    public function setLang()
    {
        $this->Csz_model->setSiteLang($this->uri->segment(2));
        redirect(base_url(), 'refresh');
    }

    public function getCoreCSS()
    {
        if (function_exists('session_cache_limiter')) {
            @session_cache_limiter(''); // add this line to the beginning of your php script to disable the cache limiter function:
        }
        $expires = 60 * 60 * 24 * 30; // Cache lifetime 30 days
        $file = FCPATH . 'assets/css/bootstrap.min.css';
        $cssFiles = array(
            $file,
            FCPATH . 'assets/css/flag-icon.min.css',
            FCPATH . 'assets/css/full-slider.css',
            FCPATH . 'assets/css/contrato.css',
            FCPATH . 'assets/css/home.css',
            FCPATH . 'assets/css/bootstrap-datepicker.css',
        );
        $etag = @md5_file($file); // Generate Etag
        $fileModified = @filemtime($file);
        /*
          Set 304 Not Modified if old visitor
         */
        if (isset($_SERVER['SERVER_PROTOCOL']) && isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && isset($_SERVER['HTTP_IF_NONE_MATCH']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $fileModified && trim($_SERVER['HTTP_IF_NONE_MATCH']) == $etag) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 304 Not Modified');
            echo $this->Csz_model->setJSCSScache($cssFiles, 'corecss', 'css', $expires);
        } else {
            $this->Csz_model->setJSCSSheader($fileModified, $expires, $etag, 'text/css');
            echo $this->Csz_model->setJSCSScache($cssFiles, 'corecss', 'css', $expires);
        }
        $this->output->cache(43200);
        exit(0);
    }

    public function getCoreJS(){
        if (function_exists('session_cache_limiter')) {
            @session_cache_limiter(''); // add this line to the beginning of your php script to disable the cache limiter function:
        }
        //$expires = 60 * 60 * 24 * 30; // Cache lifetime 30 days
        $expires=0;
        $file = FCPATH.'assets/js/bootstrap.min.js';
        $jsFiles = array(
            FCPATH.'assets/js/jquery-1.12.4.min.js',
            $file,
            FCPATH.'assets/js/jquery-ui.min.js',
            FCPATH.'assets/js/ui-loader.min.js',
            FCPATH.'assets/js/bootstrap-datepicker.min.js',
            FCPATH.'assets/js/scripts.min.js',
        );
        $etag = @md5_file($file); // Generate Etag
        $fileModified = @filemtime($file);
        /*
          Set 304 Not Modified if old visitor
         */
        if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && isset($_SERVER['HTTP_IF_NONE_MATCH']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $fileModified && trim($_SERVER['HTTP_IF_NONE_MATCH']) == $etag) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 304 Not Modified');
            echo $this->Csz_model->setJSCSScache($jsFiles, 'corejs', 'js', $expires);
        } else {
            $this->Csz_model->setJSCSSheader($fileModified, $expires, $etag, 'text/javascript');
            echo $this->Csz_model->setJSCSScache($jsFiles, 'corejs', 'js', $expires);
        }
        $this->output->cache(43200);
        exit(0);
    }

}
