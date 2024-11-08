<?php

class Violation extends Model
{
    public $table = 'violations';

    protected $allowedColumns = [
        'violation',
        'description',
        'date',
        'category',
        'compensation',
        'level',
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

       // if (empty($DATA['violation']) || !preg_match('/^[a-z A-Z]+$/', $DATA['violation'])) {
         //   $this->errors['violation'] = "Only letters allowed in here";
        //}

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

    public function assignViolationToUser ($violation_id, $user_id)
{
    // Fetch the correct user_id using the primary key from the users table
    $user = new User();
    $user_data = $user->where('id', $user_id);

    if ($user_data) {
        $user_id = $user_data[0]->user_id; // Fetch the actual user_id in the format 'name.lastname'

        // Fetch the year_level_id from the user's profile
        $userProfile = new User(); // Assuming you have a UserProfile class
        $profile_data = $userProfile->where('user_id', $user_id);

        if ($profile_data) {
            $year_level_id = $profile_data[0]->year_level_id; // Get the year_level_id
            $semester_id = $profile_data[0]->semester_id; // Get the year_level_id
            $school_year_id = $profile_data[0]->school_year_id; // Get the year_level_id

            // Fetch the correct violation_id using the primary key from the violations table
            $violation = new Violation();
            $violation_data = $violation->where('id', $violation_id);

            if ($violation_data) {
                $violation_id = $violation_data[0]->violation_id; // Fetch the actual violation_id (random string)

                // Ensure both user_id, violation_id, and year_level_id are not null before inserting
                $query = "INSERT INTO violators (user_id, violation_id, year_level_id, school_year_id, semester_id, date, status) 
                          VALUES (:user_id, :violation_id, :year_level_id, :school_year_id, :semester_id, NOW(), :status)";
                $this->query($query, [
                    'user_id' => $user_id,
                    'violation_id' => $violation_id,
                    'year_level_id' => $year_level_id,
                    'school_year_id' => $school_year_id,
                    'semester_id' => $semester_id,
                    'status' => 'Unresolved', // Set default status to 'Unresolved'
                ]);

                
            } else {
                // Handle the case where the violation doesn't exist
                error_log("Violation not found for ID: $violation_id");
            }
        } else {
            // Handle the case where the user's profile doesn't exist
            error_log("User  profile not found for user ID: $user_id");
        }
    } else {
        // Handle the case where the user doesn't exist
        error_log("User  not found for ID: $user_id");
    }
}
}

