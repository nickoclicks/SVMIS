<?php

class Schools extends Controller

{
  public function index()
  {

    if(!Auth::logged_in())
    {
      $this->redirect('login');
    }

    $school = new School();


    $data = $school->findAll();

    $crumbs[] = ['Dashboard',''];
    $crumbs[] = ['Offices','offices'];

    $this->view('schools',[
      'crumbs'=>$crumbs,
      'rows'=>$data
    ]);
  }

  public function add()
  {

    if(!Auth::logged_in())
    {
      $this->redirect('login');
    }

    $errors = array();

    $school = new School();
    if(count($_POST) > 0)
    {
      if($school->validate($_POST))
      {
        $arr['school'] = $_POST['school'];
        $arr['date'] = date("Y-m-d H:i:s");
        $school->insert($arr);
        $this->redirect('schools');
      }else
      {
        $errors = $school->errors;
      }

    }

    $crumbs[] = ['Dashboard',''];
    $crumbs[] = ['Schools','schools'];
    $crumbs[] = ['Add','schools/add'];


    $this->view('schools.add',[
      'errors'=>$errors,
      'crumbs'=>$crumbs
    ]);
  }

  public function edit($id = null)
  {

    if(!Auth::logged_in())
    {
      $this->redirect('login');
    }

    $school = new School();
    $errors = array();
    
    
    if(count($_POST) > 0)
    {

      if($school->validate($_POST))
      {

        $school->update($id, $_POST);
        $this->redirect('schools');
      }else
      {
        $errors = $school->errors;
      }

    }

    $row = $school->where('id',$id);
    $crumbs[] = ['Dashboard',''];
    $crumbs[] = ['Schools','schools'];
    $crumbs[] = ['Edit','schools/edit'];
    if($row)
    {
      $row = $row[0];
    }
    $this->view('schools.edit',[
      'errors'=>$errors,
      'row'=>$row,
      'crumbs'=>$crumbs
    ]);
  }

  public function delete($id = null)
  {

    if(!Auth::logged_in())
    {
      $this->redirect('login');
    }

    $school = new School();
    $errors = array();
    
    
    if(count($_POST) > 0)
    {

        $school->delete($id);
        $this->redirect('schools');

    }

    $row = $school->where('id',$id);
    $crumbs[] = ['Dashboard',''];
    $crumbs[] = ['Schools','schools'];
    $crumbs[] = ['Delete','schools/delete'];
   
      $row = $row[0];
    $this->view('schools.delete',[
      'row'=>$row,
      'crumbs'=>$crumbs
    ]);
  }
}