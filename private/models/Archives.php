<?php 

class Archives extends Model {

    protected $table = 'archived_violators';
    protected $allowedColumns = [
        'user_id',
        'violation',
        'date',
        'status',
        'firstname',
        'lastname',
        'year_level',
        'semester_name',
        'school_year'
    ];

}