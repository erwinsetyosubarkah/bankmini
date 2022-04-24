<?php 


class Beranda extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        
            redirect(base_url().'beranda-admin');
               
    }
}