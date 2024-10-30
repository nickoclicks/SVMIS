<?php 

class Logs extends Model {
  protected $table = 'activity_logs';

  protected $allowedColumns = ['activity_name', 'date'];

  

  public function getPrintActivities() {

    //for good moral chart
    $chartData = $this->query("
        SELECT 
        COUNT(activity_name) AS count, 
        DATE(date) AS activity_date, 
        DAYNAME(date) AS activity_day 
    FROM 
        activity_logs 
    WHERE 
        activity_name LIKE '%good moral%' 
    GROUP BY 
        activity_date, activity_day 
    ORDER BY FIELD(activity_day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')
    ");
    

    //for the violation slip chart
    $chartData1 = $this->query("
         SELECT 
        COUNT(activity_name) AS count, 
        DATE(date) AS activity_date, 
        DAYNAME(date) AS activity_day 
    FROM 
        activity_logs 
    WHERE 
        activity_name LIKE '%violation slip%' 
    GROUP BY 
        activity_date, activity_day 
    ORDER BY FIELD(activity_day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')
    ");
    

    if ($chartData !== false) {
        $chartLabels = array_column($chartData, 'activity_day');
        $chartData = array_column($chartData, 'count');
        $chartLabels1 = array_column($chartData1, 'activity_day');
        $chartData1 = array_column($chartData1, 'count');
    } else {
        $chartLabels = [];
        $chartData = [];
    }

    return ['labels' => $chartLabels, 'data' => $chartData, 'data1' => $chartData1, 'labels1' => $chartLabels1];
}
}