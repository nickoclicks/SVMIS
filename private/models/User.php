<?php

class User extends Model
{

  protected $allowedColumns = [
    'std_id',
    'firstname',
    'lastname',
    'year_level',
    'course',
    'email',
    'password',
    'rank',
    'gender',
    'date',
    'street',
    'municipality',
    'barangay',
    'city',
    'phone',
  ];

  protected $beforeInsert = [
    'make_user_id',
    
    'hash_password'
  ];


  public function validate($DATA)
  {
    $this->errors = array();
//check for firstname
    if(empty($DATA['firstname']) || !preg_match('/^[a-z A-Z]+$/', $DATA['firstname']))
    {
      $this->errors['firstname'] = "Only letters allowed in firstname";
    }

    //check for lastname
    if(empty($DATA['lastname']) || !preg_match('/^[a-zA-Z]+$/', $DATA['lastname']))
    {
      $this->errors['lastname'] = "Only letters allowed in firstname";
    }

    //check for email
    if(empty($DATA['email']) || !filter_var($DATA['email'],FILTER_VALIDATE_EMAIL))
    {
      $this->errors['email'] = "Email is not valid";
    }

    //check if email exists
    if($this->where('email',$DATA['email']))
    {
      $this->errors['email'] = "That email is already in use";
    }

    //check for gender
    $gender = ['Female','Male'];
    if(empty($DATA['gender']) || in_array($DATA['gender'], $gender))
    {
      $this->errors['gender'] = "Gender is not valid";
    }

    //check for password length
    if(strlen($DATA['password']) < 8)
    {
      $this->errors['password'] = "Password must be at least 8 characters";
    }

    //check for rank
    $rank = ['Super admin','Admin', 'Student'];
    if(empty($DATA['rank']) || in_array($DATA['rank'], $rank))
    {
      $this->errors['rank'] = "Rank is not valid";
    }

//check for password
    if(empty($DATA['password']) || $DATA['password'] != $DATA['password2'])
    {
      $this->errors['password'] = "The password doesnt match";
    }

    if (count($this->errors)==0)
    {
      return true;
    }
    return false;
  }
  //protected $table = "users";

  public function make_user_id($data)
  {
    
    $data['user_id'] = strtolower($data['firstname'] . "." . $data['lastname']);

    while($this->where('user_id',$data['user_id']))
    {
      $data['user_id'] .= rand(10,9999);
    }
    return $data;
  }
  public function make_school_id($data)
  {
    if(isset($_SESSION['USER']->school_id)){
    $data['school_id'] = $_SESSION['USER']->school_id;
    }
    return $data;
  }
  public function hash_password($data)
  {
    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    return $data;
  }


}