<?php 

class Goodmorals extends Model {
  protected $table = 'good_moral_logs';

  protected $allowedColumns = ['log_name', 'date'];

  


public function countAll()
{
    return $this->query("SELECT COUNT(*) AS count FROM activity_logs")[0]->count;
}
}