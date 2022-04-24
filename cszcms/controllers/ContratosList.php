<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * CSZ CMS
 *
 * An open source content management system
 *
 * Copyright (c) 2016, Astian Foundation.
 *
 * Astian Develop Public License (ADPL)
 *
 * This Source Code Form is subject to the terms of the Astian Develop Public
 * License, v. 1.0. If a copy of the APL was not distributed with this
 * file, You can obtain one at http://astian.org/about-ADPL
 *
 * @author	CSKAZA
 * @copyright   Copyright (c) 2016, Astian Foundation.
 * @license	http://astian.org/about-ADPL	ADPL License
 * @link	https://www.cszcms.com
 * @since	Version 1.0.0
 */
class ContratosList extends CI_Controller
{

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
        $this->load->library('pdf');
        $this->_init();
    }

    public function _init()
    {
        $this->template->set('core_css', $this->Csz_model->coreCss());
        $js_arr = array(base_url() . 'assets/js/contratosList.js');
        $this->template->set('core_js', $this->Csz_model->coreJs($js_arr));
        $row = $this->Csz_model->load_config();
        $pageURL = $this->Csz_model->getCurPages();
        $this->template->set('additional_js', $row->additional_js);
        $this->template->set('additional_metatag', $row->additional_metatag);
        $title = $this->Csz_model->pagesTitle('Contratos');

        $this->template->set('title', $title);
        $this->template->set('meta_tags', $this->Csz_model->coreMetatags($title, $row->keywords, $title));
        $this->template->set('cur_page', $pageURL);
    }

    public function index()
    {
        $this->csz_referrer->setIndex('contrato');
        $this->template->setSub('contrato', $this);
        $this->load->model('Csz_startup');
        $this->template->loadFrontViews('contratosList/home');
    }
    public function comenzarContrato()
    {
        $data = $this->input->post('data'); # add this      
        $this->session->set_userdata('IdContrato', $data);          
        redirect ('contrato','refresh');
    }

    public function obtenerListas()
    {
        $data['listaTipoContrato']  = $this->ContratosList_model->listTipoContratos();
        $data['listaContrato']  = $this->ContratosList_model->listContratos();
        //add the header here
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
