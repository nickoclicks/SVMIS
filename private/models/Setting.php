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
public function archiveResolvedViolations()
{
    // Archive resolved violations
    $archiveQuery = "INSERT INTO archived_violators (id, user_id, violation_id, firstname, lastname, year_level, semester_name, date, status, archived_date)
                     SELECT id, user_id, violation_id, firstname, lastname, year_level, semester_name, date, status, CURRENT_DATE
                     FROM violatorsforarchived
                     WHERE status = 'resolved'";
    
    // Execute the archive query
    $this->query($archiveQuery);
    
    // Delete resolved violations from the active table
    $deleteQuery = "DELETE FROM violators WHERE status = 'resolved'";
    
    // Execute the delete query
    $this->query($deleteQuery);
    
}


 }