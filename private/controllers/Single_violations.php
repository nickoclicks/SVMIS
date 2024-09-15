<?php

class Single_violations extends Controller

{
  function index($id = '')
  {
    if(!Auth::logged_in())
    {
      $this->redirect('login');
    }
    $violations = new Violation();
    $row = $violations->first('violation_id',$id);
    $crumbs[] = ['Dashboard',''];
    $crumbs[] = ['violations','violations'];

    if($row)
    {
      $crumbs[] = [$row->violation,''];
    }

    $page_tab = isset($_GET['tab']) ? $_GET['tab'] : 'violators';

    $vio = new Violators();
    
    $results = false;
    if(($page_tab  == 'violators-add' || $page_tab == "violators-remove") && count($_POST) > 0)
    {
      if(isset($_POST['search'])){

        if(trim($_POST['name']) != ""){

        //find violator
      $user = new User();
      $name = "%".trim($_POST['name'])."%";
      $query = "Select * from users where (firstname like :fname || lastname like :lname) && rank = 'student' limit 10";
      $results = $user->query($query,['fname'=>$name,'lname'=>$name,]);

        }else{
          $errors[] = "please type something to find";
        }
        
      }
        else if(isset($_POST['selected'])){

          if($page_tab == 'violators-add'){
        //add violators
        $arr = array();
        $arr['user_id'] = $_POST['selected'];
        $arr['violation_id'] = $id; 
        $arr['disabled'] = 0;
        $arr['date'] = date("Y-m-d H:i:s");

        $vio->insert($arr);

        $this->redirect('single_violations/'.$id.'?tab=violators');
      }
      else
      if($page_tab == 'violators-remove'){


        $query = "select id from violators where user_id - :user_id && violation_id = :violation_id";

        if($row = $vio->query($query,[
          'user_id' => $_POST['selected'],
          'violation_id' => $id,
        ])){
        $arr = array();
        $arr['disabled'] = 1;

        $vio->update($row[0]->id,$arr);

        $this->redirect('single_violations/'.$id.'?tab=violators');
      }
    }
    }
  }
    else
    if($page_tab == 'violators')
{
      //display violators
      $violators = $vio->where('violation_id',$id);
      $data['violators']  = $violators;

  }

      $data['row']        = $row;
      $data['crumbs']     = $crumbs;
      $data['page_tab']   = $page_tab;
      $data['results']    = $results;

    $this->view('single_violations', $data);
  }
}
