<?php
class Tcvgh extends CI_Controller {

  public function __construct()
  {
      parent::__construct();
      $this->load->database();
      $this->load->model('tcvgh_model');
  }

    public function getoutbreak()
    {
        $data['outbreak'] = $this->tcvgh_model->get_outbreak($_POST['selectYear']);
        echo json_encode($data['outbreak'],JSON_UNESCAPED_UNICODE);
    }

    public function getcigs()
    {
        $data['cigs'] = $this->tcvgh_model->get_cigs();
        echo json_encode($data['cigs'],JSON_UNESCAPED_UNICODE);
    }

    public function getili()
    {
      $data['ili'] = $this->tcvgh_model->get_ili();
      echo json_encode($data['ili'],JSON_UNESCAPED_UNICODE);
    }



    //頁面
    public function outbreak()
    {
        $data['title'] = 'Outbreak';

        $this->load->view('templates/header', $data);
        $this->load->view('tcvgh/outbreak', $data);
        $this->load->view('templates/footer');
    }

    public function ili()
    {
        $data['title'] = 'ILI';

        $this->load->view('templates/header', $data);
        $this->load->view('tcvgh/ili', $data);
        $this->load->view('templates/footer');
    }

    public function pm25tocigs()
    {
        $data['title'] = 'Cigarettes';

        $this->load->view('templates/header', $data);
        $this->load->view('tcvgh/pm25tocigs', $data);
        $this->load->view('templates/footer');
    }


}
