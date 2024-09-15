<?php

class Violators extends Model
{
    public $table = 'violators';

    protected $allowedColumns = [
        'user_id',
        'school_id',
        'violation_id',
        'disabled',
        'date',
        'compensation',
        'timer_start',
        'duration',
        'office',
        'status'  // Added status to reflect updates in status
    ];

    protected $beforeInsert = [
        'make_school_id',
    ];

    protected $afterSelect = [
        'get_user',
    ];

    public function make_school_id($data)
    {
        if (isset($_SESSION['USER']->school_id)) {
            $data['school_id'] = $_SESSION['USER']->school_id;
        }
        return $data;
    }

    public function get_user($data)
    {
        $user = new User();
        foreach ($data as $key => $row) {
            $result = $user->where('user_id', $row->user_id);
            $data[$key]->user = is_array($result) ? $result[0] : false;
        }
        return $data;
    }

    public function countAll()
    {
        return $this->query("SELECT COUNT(*) AS count FROM violators")[0]->count;
    }

    // Find recent violators
    public function findRecent($limit = 5)
    {
        return $this->query("SELECT * FROM violators ORDER BY date DESC LIMIT $limit");
    }

    // Updated the method for updating a violator's status by violation ID
    public function updateStatus($violationId, $newStatus)
    {
        $query = "UPDATE violators SET status = :status WHERE id = :id";
        $this->query($query, [
            'status' => $newStatus,
            'id' => $violationId
        ]);
    }

    // Get violator by ID for editing
    public function findById($id)
    {
        $query = "SELECT * FROM violators WHERE id = :id LIMIT 1";
        $result = $this->query($query, ['id' => $id]);
        return $result ? $result[0] : null;
    }

    /* Update violator's information
    public function updateViolator($id, $data)
    {
        // Construct the update query based on allowed columns
        $allowedColumns = array_intersect_key($data, array_flip($this->allowedColumns));

        if (!empty($allowedColumns)) {
            $setClause = implode(', ', array_map(fn($col) => "$col = :$col", array_keys($allowedColumns)));

            $query = "UPDATE violators SET $setClause WHERE id = :id";

            $allowedColumns['id'] = $id; // Include the ID in parameters
            return $this->query($query, $allowedColumns);
        }
        return false;
    }*/
    public function validate($data)
{
    $errors = [];
    // Add validation rules here
    if (empty($data['user_id'])) {
        $errors[] = 'User ID is required';
    }
    // Add more validation rules as needed

    $this->errors = $errors;
    return empty($errors);
}

public function update($id, $data)
{
    $allowedColumns = array_intersect_key($data, array_flip($this->allowedColumns));
    
    if (!empty($allowedColumns)) {
        $setClause = implode(', ', array_map(fn($col) => "$col = :$col", array_keys($allowedColumns)));
        
        $query = "UPDATE violators SET $setClause WHERE id = :id";
        $allowedColumns['id'] = $id; // Add the violation ID to the parameters
        
        return $this->query($query, $allowedColumns);
    }
    return false;
}



/*public function findViolatorWithViolation($user_id)
{
    $query = "
        SELECT violators.*, violations.violation 
        FROM violators 
        LEFT JOIN violations 
        ON violators.violation_id = violations.id 
        WHERE violators.user_id = :user_id 
        LIMIT 1
    ";

    $params = ['user_id' => $user_id];
    $result = $this->query($query, $params);

    // Debugging: Log or output the result
    error_log(print_r($result, true));

    return $result ? $result[0] : null;
}*/

public function updateViolator($id, $data)
{
    $sql = "UPDATE violators SET name = :name, email = :email, phone = :phone WHERE user_id = :user_id";

    $params = [
        ':name' => $data['name'],
        ':email' => $data['email'],
        ':phone' => $data['phone'],
        ':id' => $id
    ];

    return $this->query($sql, $params);
}

public function getCompensationOptions($violation_id)
{
    $query = "
        SELECT v.compensation 
        FROM violations v
        INNER JOIN violators vl ON v.violation_id = vl.violation_id
        WHERE vl.violation_id = :violation_id
        LIMIT 1
    ";
    
    return $this->query($query, ['violation_id' => $violation_id]);
}

public function getViolationName($violationId)
{
    $query = "
        SELECT v.violation
        FROM violations v
        INNER JOIN violators vl ON v.violation_id = vl.violation_id
        WHERE vl.violation_id = :violationId
    ";
    
    $result = $this->query($query, ['violationId' => $violationId]);
    return $result ? $result[0]->violation : null;
}

public function getUserName($userId)
    {
        $query = "
            SELECT u.firstname, u.lastname, v.office
            FROM users u
            INNER JOIN violators v ON u.user_id = v.user_id
            WHERE v.user_id = :userId
        ";
        
        $result = $this->query($query, ['userId' => $userId]);
        return $result ? $result[0] : null;
    }

    public function getOffice($userId)
{
    $query = "
        SELECT office FROM violators WHERE user_id = :id
    ";
    
    $result = $this->query($query, ['id' => $userId]);
    $office = '';
    if ($result) {
        foreach ($result as $row) {
            $office = $row->office;
        }
    }
    return $office;
}


public function getDuration($userId)
{
    $query = "
        SELECT duration FROM violators WHERE user_id = :id
    ";
    
    $result = $this->query($query, ['id' => $userId]);
    $duration = '';
    if ($result) {
        foreach ($result as $row) {
            $duration = $row->duration;
        }
    }
    return $duration;
}



    

    


}
