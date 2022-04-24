<?php
/**
 * CSZ CMS
 *
 * An open source content management system
 *
 * Copyright (c) 2019, Chinawut Phongphasook (CSKAZA).
 *
 * Astian Develop Public License (ADPL)
 *
 * This Source Code Form is subject to the terms of the Astian Develop Public
 * License, v. 1.0. If a copy of the APL was not distributed with this
 * file, You can obtain one at http://astian.org/about-ADPL
 *
 * @author	CSKAZA
 * @copyright   Copyright (c) 2019, Chinawut Phongphasook (CSKAZA).
 * @license	http://astian.org/about-ADPL	ADPL License
 * @link	https://www.cszcms.com
 * @since	Version 1.0.0
 */
defined('BASEPATH') || exit('No direct script access allowed');

class Person_model extends CI_Model{

    private $cachetime = 0;

    function __construct(){
        parent::__construct();
        $this->load->model('Csz_model');
        if (CACHE_TYPE == 'file') {
            $this->load->driver('cache', array('adapter' => 'file', 'key_prefix' => EMAIL_DOMAIN . '_'));
        } else {
            $this->load->driver('cache', array('adapter' => CACHE_TYPE, 'backup' => 'file', 'key_prefix' => EMAIL_DOMAIN . '_'));
        }
        if($this->load_config()->pagecache_time == 0){
            $this->setcahetime(1);
        }else{
            $this->setcahetime($this->load_config()->pagecache_time);
        }
    }

    /**
     * setcahetime
     * Set the cache time (In minute)
     * @param   int $minute   the minute of cache time
     */
    private function setcahetime($minute = 0) {
        if(is_numeric($minute)) $this->cachetime = $minute;
    }

    /**
     * load_config
     *
     * Function for load settings from database
     *
     * @return	object or FALSE
     */
    public function load_config(){
        return $this->Csz_model->load_config();
    }

    /**
     * getUser
     *
     * Function for get member data
     *
     * @param	string	$id    member id
     * @return	object or FALSE
     */
    public function getUser($id, $type = ''){
        // Get the user details
        $sql_where = "id_usuario = '".$id."'";
        if($type){
            $sql_where.= " AND tipo_persona = '".$type."'";
        }
        $rows = $this->Csz_model->getValue('*', 'person', $sql_where, '', 1);
        if($rows !== FALSE){
            return $rows;
        }else{
            return FALSE;
        }
    }
    public function getClients($id, $type = ''){
        // Get the user details
        $sql_where = "id_usuario = '".$id."'";
        if($type){
            $sql_where.= " AND tipo_persona = '".$type."'";
        }
        $rows = $this->Csz_model->getValueArray('*', 'person', $sql_where, '');
        if($rows !== FALSE){
            return $rows;
        }else{
            return FALSE;
        }
    }
}
