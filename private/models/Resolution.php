<?php

class Sdc extends Model
{
    public $table = 'complaint';

    protected $allowedColumns = [
        'complaint',
        'date',
        'comp_name',
        'comp_id',
        'comp_course_year',
        'comp_phone',
        'comp_address',
        'comp_email',
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
    ];

    public function validate($data)
    {
        $errors = [];

        // Add validation rules here
        if (empty($data['complaint'])) {
            $errors[] = 'Complaint name is required';
        }
        if (empty($data['comp_id'])) {
            $errors[] = 'Complainant student ID is required';
        }
        if (empty($data['resp_id'])) {
            $errors[] = 'Respondent student ID is required';
        }

        // Add more validation rules as needed
        $this->errors = $errors;
        return empty($errors);
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

  
}
