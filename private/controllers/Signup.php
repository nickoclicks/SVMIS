<?php

class Signup extends Controller

{
  function index()
  {

    $mode = isset($_GET['mode']) ? $_GET['mode'] : '';
    $errors = array();
    if(count($_POST) > 0)
    {
      $user = new User();

      if($user->validate($_POST))
      {
        $arr['std_id'] = $_POST['std_id'];
        $arr['firstname'] = $_POST['firstname'];
        $arr['middlename'] = $_POST['middlename'];
        $arr['lastname'] = $_POST['lastname'];
        $arr['gender'] = $_POST['gender'];
        $arr['year_level'] = $_POST['year_level'];
        $arr['course'] = $_POST['course'];
        $arr['rank'] = $_POST['rank'];
        $arr['email'] = $_POST['email'];
        $arr['password'] = $_POST['password'];
        $arr['date'] = date("Y-m-d H:i:s");
        $arr['street'] = $_POST['street'];
        $arr['barangay'] = $_POST['barangay'];
        $arr['city'] = $_POST['city'];
        $arr['municipality'] = $_POST['municipality'];
        $arr['phone'] = $_POST['phone'];
        $user->insert($arr);
        $redirect = $mode == 'students' ? 'students':'users';
        $this->redirect($redirect);
      }else
      {
        $errors = $user->errors;
      }
    }

    $this->view('Signup',[
      'errors'=>$errors,
      'mode'=>$mode,
    ]);
  }
}

