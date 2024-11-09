<?php

class User extends Model
{

  protected $allowedColumns = [
    'std_id',
    'firstname',
    'middlename',
    'lastname',
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
    'status',
    'year_level_id',
    'school_year_id',
    'semester_id'
  ];

  protected $beforeInsert = [
    'make_user_id',
    
    'hash_password'
  ];


  public function validate($DATA, $update = false)
{
    $this->errors = array();
    //check for firstname
    if(!$update && (empty($DATA['firstname']) || !preg_match('/^[a-zA-Z]+$/', $DATA['firstname'])))
    {
        $this->errors['firstname'] = "Only letters allowed in firstname";
    }
    //check for lastname
    if(!$update && (empty($DATA['lastname']) || !preg_match('/^[a-zA-Z]+$/', $DATA['lastname'])))
    {
        $this->errors['lastname'] = "Only letters allowed in lastname";
    }

    //check for email
    if(!$update && (empty($DATA['email']) || !filter_var($DATA['email'],FILTER_VALIDATE_EMAIL)))
    {
        $this->errors['email'] = "Email is not valid";
    }

    //check if email exists (only during creation, not during update)
    if(!$update && $this->where('email',$DATA['email']))
    {
        $this->errors['email'] = "That email is already in use";
    }

    //check for password (only during creation, not during update)
    if(!$update && (isset($DATA['password']) && strlen($DATA['password']) < 8))
    {
        $this->errors['password'] = "Password must be at least 8 characters";
    }

    //check for password match (only during creation, not during update)
    if(!$update && (isset($DATA['password']) && isset($DATA['password2']) && $DATA['password'] != $DATA['password2']))
    {
        $this->errors['password'] = "The password doesn't match";
    }

    //check for rank
   /* $rank = ['Super admin','Admin', 'Student'];
    if(!$update && (empty($DATA['rank']) || !in_array($DATA['rank'], $rank)))
    {
        $this->errors['rank'] = "Rank is not valid";
    }*/

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


  //i modify ko ra ni sunod ug i apply na nako ang mga schedule ubos sa calendar, ers ang name sa function pero mag retrieve ni sa schedules sa appointment
  public function getUsers() {
    $query = "
        SELECT u.firstname, u.lastname, n.user_id, n.resp_name,
               DATE_FORMAT(n.appt_date, '%W, %M %e, %Y') AS appt_date, 
               n.appt_time
        FROM users u
        JOIN notice n ON u.user_id = n.user_id
        WHERE n.appt_date >= CURDATE() - INTERVAL DAYOFWEEK(CURDATE()) + 6 DAY
          AND n.appt_date < CURDATE() + INTERVAL 7 - DAYOFWEEK(CURDATE()) DAY
    ";

    $result = $this->query($query);
    return $result ?: null; // Return null if no users found
}

public function getAllStaffMembers()
    {
        return $this->query("SELECT * FROM users WHERE rank IN ('staff', 'admin') ORDER BY id DESC");
    }

    public function searchStaffMembersByName($searchTerm)
    {
        return $this->query(
            "SELECT * FROM users WHERE rank IN ('staff', 'admin') AND (firstname LIKE :search OR lastname LIKE :search) ORDER BY id DESC",
            [
                'search' => '%' . $searchTerm . '%'
            ]
        );
    }

    public function getAllStudents()
    {
        return $this->query("SELECT * FROM users WHERE rank = 'student' ORDER BY id DESC");
    }

    public function searchStudentsByName($searchTerm)
    {
        return $this->query(
            "SELECT * FROM users WHERE rank = 'student' AND (firstname LIKE :search OR lastname LIKE :search) ORDER BY id DESC",
            [
                'search' => '%' . $searchTerm . '%'
            ]
        );
    }

    public function update($id, $data)
{
    $allowedColumns = array_intersect_key($data, array_flip($this->allowedColumns));
    
    if (!empty($allowedColumns)) {
        $setClause = implode(', ', array_map(fn($col) => "$col = :$col", array_keys($allowedColumns)));
        
        $query = "UPDATE users SET $setClause WHERE id = :id";
        $allowedColumns['id'] = $id; // Add the user ID to the parameters
        
        return $this->query($query, $allowedColumns);
    }
    return false;
}

public function findById($id)
{
    $query = "SELECT * FROM users WHERE id = :id";
    $params = array('id' => $id);
    $result = $this->query($query, $params);
    return $result ? $result[0] : false;
}

public function toggleStatus($id)
{
    $user = $this->findById($id);

    if ($user) {
        $status = ($user->status == 'active') ? 'inactive' : 'active';
        $this->update($id, ['status' => $status]);
        return true;
    }
    return false;
}

  

   
}