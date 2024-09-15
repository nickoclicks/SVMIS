<?php

class Violation extends Model
{
    public $table = 'violations';

    protected $allowedColumns = [
        'violation',
        'description',
        'date',
        'shb_article',
        'compensation'
    ];

    protected $beforeInsert = [
        'make_violation_id',
        'make_school_id',
        'make_user_id',
    ];

    protected $afterSelect = [
        'get_user'
    ];

    public function validate($DATA)
    {
        $this->errors = array();

        if (empty($DATA['violation']) || !preg_match('/^[a-z A-Z]+$/', $DATA['violation'])) {
            $this->errors['violation'] = "Only letters allowed in here";
        }

        if (count($this->errors) == 0) {
            return true;
        }
        return false;
    }

    public function make_user_id($data)
    {
        if (isset($_SESSION['USER']->user_id)) {
            $data['user_id'] = $_SESSION['USER']->user_id;
        }
        return $data;
    }

    public function make_school_id($data)
    {
        if (isset($_SESSION['USER']->school_id)) {
            $data['school_id'] = $_SESSION['USER']->school_id;
        }
        return $data;
    }

    public function make_violation_id($data)
    {
        $data['violation_id'] = random_string(60);
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
        return $this->query("SELECT COUNT(*) AS count FROM violations")[0]->count;
    }

    public function findRecent($limit = 5)
    {
        return $this->query("SELECT * FROM violations ORDER BY date DESC LIMIT $limit");
    }

    public function assignViolationToUser($violation_id, $user_id)
{
    // Fetch the correct user_id using the primary key from the users table
    $user = new User();
    $user_data = $user->where('id', $user_id);

    if ($user_data) {
        $user_id = $user_data[0]->user_id; // Fetch the actual user_id in the format 'name.lastname'
    } else {
        // Handle the case where the user doesn't exist
        $user_id = null;
    }

    // Fetch the correct violation_id using the primary key from the violations table
    $violation = new Violation();
    $violation_data = $violation->where('id', $violation_id);

    if ($violation_data) {
        $violation_id = $violation_data[0]->violation_id; // Fetch the actual violation_id (random string)
    } else {
        // Handle the case where the violation doesn't exist
        $violation_id = null;
    }

    // Ensure both user_id and violation_id are not null before inserting
    if ($user_id && $violation_id) {
        $query = "INSERT INTO violators (user_id, violation_id, date, status) 
                  VALUES (:user_id, :violation_id, NOW(), :status)";
        $this->query($query, [
            'user_id' => $user_id,        // This should be 'name.lastname'
            'violation_id' => $violation_id,
            'status' => 'Unresolved',     // Set default status to 'Unresolved'
        ]);
    }
}

/*public function getViolationById($id)
{
    $query = "SELECT * FROM violators WHERE id = :id";
    $result = $this->db->query($query, [':id' => $id]);
    return $result ? $result : null;
}*/


public function updateStatus($id, $status)
{
    $query = "UPDATE violations SET status = :status WHERE id = :id";
    $this->execute($query, ['status' => $status, 'id' => $id]);
}

}

