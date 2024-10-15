<?php

class Enrollment extends Model
{
    protected $table = 'enrollment';
    protected $allowedColumns = ['user_id', 'year_level'];

    public function addEnrollment($userId, $yearLevel)
    {
        $data = [
            'user_id' => $userId,
            'year_level' => $yearLevel,
        ];

        $result = $this->insert($data);

        if (!$result) {
            error_log("Failed to insert enrollment data for user_id: $userId");
        }

        return $result;
    }
    public function save() {
        $this->query("INSERT INTO enrollments SET user_id = :user_id, year_level = :year_level", [
            'user_id' => $this->user_id,
            'year_level' => $this->year_level
        ]);
    }
}