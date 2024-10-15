<?php 

class Logs extends Model {
  protected $table = 'activity_logs';

  protected $allowedColumns = ['activity_name', 'date'];

  public function getPrintActivities() {
    $chartData = $this->query("
        SELECT COUNT(log_name) as count, DATE(date) as activity_date 
        FROM good_moral_logs 
        WHERE log_name LIKE '%certificate%'
        GROUP BY DATE(date) 
        ORDER BY count DESC
    ");

    $chartData1 = $this->query("
        SELECT COUNT(log_name) as count, DATE(date) as activity_date 
        FROM good_moral_logs 
        WHERE log_name LIKE '%slip%'
        GROUP BY DATE(date) 
        ORDER BY count DESC
    ");
    

    if ($chartData !== false) {
        $chartLabels = array_column($chartData, 'activity_date');
        $chartData = array_column($chartData, 'count');
        $chartLabels1 = array_column($chartData1, 'activity_date');
        $chartData1 = array_column($chartData1, 'count');
    } else {
        $chartLabels = [];
        $chartData = [];
    }

    return ['labels' => $chartLabels, 'data' => $chartData, 'data1' => $chartData1, 'labels1' => $chartLabels1];
}
}