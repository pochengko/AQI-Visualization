<?php
class Ibike extends CI_Controller {


    public function index()
    {
      $this->load->view('echarts/ibike');
    }

    function  getjson(){
          $ibike=file_get_contents('http://ybjson01.youbike.com.tw:1002/gwjs.json');
               echo $ibike;
        
      }

}