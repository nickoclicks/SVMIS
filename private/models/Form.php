<?php

class Form extends Model
{
    public $table = 'notice';

    protected $allowedColumns = [
        'complaint',
        'date',
        'resp_name',
        'resp_id',
        'resp_course_year',
        'resp_phone',
        'resp_address',
        'resp_email',
        'violations',
        'ind_name',
        'ind_position',
        'ind_place',
        'ind_date',
        'ind_time',
        'evidence',
        'wit_name',
        'wit_contact',
        'status',
        'user_id'
    ];

    protected $beforeInsert = [
        'make_user_id',
    ];

    public function validate($data)
    {
        $errors = [];

        // Add validation rules here
        if (empty($data['complaint'])) {
            $errors[] = 'Complaint name is required';
        }
        if (empty($data['resp_id'])) {
            $errors[] = 'Respondent student ID is required';
        }

        // Add more validation rules as needed
        $this->errors = $errors;
        return empty($errors);
    }

    public function make_user_id($data)
    {
        // If user_id is already set (from the controller), don't overwrite it
        if (!isset($data['user_id']) && isset($_SESSION['USER']->user_id)) {
            $data['user_id'] = $_SESSION['USER']->user_id;  // Only use session ID if not set
        }
        return $data;
    }
    

    // Insert validated data into the notice table
    public function insertNotice($data)
    {
        return $this->insert($data);
    }

    // Fetch complainant name suggestions based on input term
    public function getCompNameSuggestions($term) {
      $query = "SELECT firstname FROM users WHERE firstname LIKE :term LIMIT 5";
      $params = ['term' => '%' . $term . '%'];
      return $this->query($query, $params);  // Ensure the `query()` method correctly fetches the data
  }

  public function countAll()
    {
        return $this->query("SELECT COUNT(*) AS count FROM notice")[0]->count;
    }

    public function getComplaintsByUserId($user_id)
    {
        $query = "SELECT * FROM notice WHERE user_id = :user_id";
        $params = ['user_id' => $user_id];
        try {
            return $this->query($query, $params);
        } catch (Exception $e) {
            echo 'Query error: ' . $e->getMessage();
            return [];
        }
    }

    public function getViolations()
    {
        $query = "SELECT id, violation FROM violations";
        try {
            return $this->query($query);  // Assuming query() method executes and fetches the results
        } catch (Exception $e) {
            echo 'Query error: ' . $e->getMessage();
            return [];
        }
}

public function getStudentIdSuggestions($term)
    {
        $query = "SELECT id, std_id FROM users WHERE std_id LIKE :term LIMIT 5";
        $params = ['term' => '%' . $term . '%'];
        return $this->query($query, $params);  // Query the database
    }

    public function getRespondentDetailsById($std_id)
    {
        $query = "SELECT firstname, lastname, email, course, year_level, phone, street, barangay, city, municipality FROM users WHERE std_id = :std_id LIMIT 1";
        $params = ['std_id' => $std_id];
        return $this->query($query, $params)[0] ?? null;  // Return the first result or null
    }
     // Get violator by ID for editing
     public function findById($id)
     {
         $query = "SELECT * FROM notice WHERE id = :id LIMIT 1";
         $result = $this->query($query, ['id' => $id]);
         return $result ? $result[0] : null;
     }

     public function getUserName($userId)
    {
        $query = "
            SELECT u.firstname, u.lastname
            FROM users u
            INNER JOIN violators v ON u.user_id = v.user_id
            WHERE v.user_id = :userId
        ";
        
        $result = $this->query($query, ['userId' => $userId]);
        return $result ? $result[0] : null;
    }
}