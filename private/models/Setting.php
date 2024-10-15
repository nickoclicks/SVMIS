<?php

//activity log unta name ani nga table pero gi settings nako kay dadot nako i butang s asettings na page ang activity log
 class Setting extends Model {

  public $table = 'activity_logs';

  protected $allowedColumns = [
    'activity_name',
    'date'
];

public function getActivityLogs()
{
    $query = "SELECT * FROM activity_logs ORDER BY date DESC LIMIT 20";
    return $this->query($query);
}

 }