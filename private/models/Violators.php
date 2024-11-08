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
        'status',
        'remarks',
        'time_start',
        'time_end',
        'comp_date',
        'level',
        'year_level_id',
        'semester_id'
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
        return $this->query("SELECT COUNT(DISTINCT user_id) AS count FROM violators;")[0]->count;
    }

    public function countAlll()
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
        SELECT v.violation, v.level
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
            SELECT u.firstname, u.lastname, u.std_id, v.office, e.year_level, u.course
            FROM users u
            INNER JOIN violators v ON u.user_id = v.user_id
            INNER JOIN enrollment e ON u.year_level_id = e.year_level_id
            WHERE v.user_id = :userId
        ";
        
        $result = $this->query($query, ['userId' => $userId]);
        return $result ? $result[0] : null;
    }

    public function getViolationDescription($violationId)
    {
        $query = "
                SELECT v.level
                FROM violations v
                INNER JOIN violators vl ON v.violation_id = vl.violation_id
                WHERE vl.violation_id = :violationId
        ";
        
        $result = $this->query($query, ['violationId' => $violationId]);
        return $result ? $result[0]->level : null;
    }
    
    public function getViolationCategory($violationId)
    {
        $query = "
                SELECT v.category
                FROM violations v
                INNER JOIN violators vl ON v.violation_id = vl.violation_id
                WHERE vl.violation_id = :violationId
        ";
        
        $result = $this->query($query, ['violationId' => $violationId]);
        return $result ? $result[0]->category : null;
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


// Add this method to your Violators model

public function getUserViolationStats($userId)
    {
        $query = "
           SELECT 
            u.firstname, 
            u.lastname, 
            vv.level,
            vv.violation,
            CASE 
                WHEN SUM(CASE WHEN vl.status = 'Unresolved' THEN 1 ELSE 0 END) > 0 THEN 'Unresolved'
                ELSE 'Resolved'
            END AS status,
            COUNT(vl.id) AS total_violations
        FROM 
            users u
        LEFT JOIN 
            violators vl ON u.user_id = vl.user_id
        LEFT JOIN
            violations vv ON vl.violation_id = vv.violation_id
        WHERE 
            u.user_id = :user_id
        GROUP BY 
            vv.violation
        ORDER BY 
            total_violations DESC
        ";

        $result = $this->query($query, ['user_id' => $userId]);

        return $result ? $result : [];
    }

    public function getOfficeCounts()
{
    $query = "
        SELECT office, COUNT(id) AS count
        FROM violators
        GROUP BY office
    ";

    $result = $this->query($query);

    return $result ? $result : [];
}

public function filterBySchoolYearId($schoolYearId) {
    $query = "SELECT * FROM violators WHERE school_year_id = :schoolYearId";
    return $this->query($query, ['schoolYearId' => $schoolYearId]);
}

public function countUnresolvedByUserId($userId)
{
    $query = "SELECT COUNT(*) as count FROM violators WHERE user_id = :user_id AND status != 'Resolved'";
    $result = $this->query($query, ['user_id' => $userId]);
    return $result ? $result[0]->count : 0;
}
    //gikan sa home
}
