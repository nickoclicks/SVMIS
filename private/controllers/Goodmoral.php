<?php

class Goodmoral extends Controller {
  public function index()
  {
  if (!Auth::logged_in()) {
    $this->redirect('login');
  }


  $logs = new Goodmorals();

$totalActivity = $logs->countAll();



  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Handle the first set of filters
    if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
        $_SESSION['filters']['start_date'] = $_GET['start_date'];
        $_SESSION['filters']['end_date'] = $_GET['end_date'];
    }
}

$filters = [
    'start_date' => $_GET['start_date'] ?? '',
'end_date' => $_GET['end_date'] ?? '',
];

$filterConditions = [];
        $queryParams = [];

        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $filterConditions[] = "good_moral_logs.date BETWEEN :start_date AND :end_date";
            $queryParams['start_date'] = $filters['start_date'];
            $queryParams['end_date'] = $filters['end_date'];
        } elseif (!empty($filters['start_date'])) {
            $filterConditions[] = "good_moral_logs.date >= :start_date";
            $queryParams['start_date'] = $filters['start_date'];
        } elseif (!empty($filters['end_date'])) {
            $filterConditions[] = "good_moral_logs.date <= :end_date";
            $queryParams['end_date'] = $filters['end_date'];
        }

        

 

// Build the WHERE clause dynamically
$whereClause = '';
if (!empty($filterConditions)) {
    $whereClause = 'WHERE ' . implode(' AND ', $filterConditions);
}

$recentActivity = $logs->query("
SELECT * FROM good_moral_logs
$whereClause
ORDER BY WEEKDAY(date), date DESC
", $queryParams);

  if ($recentActivity === false) {
    $recentActivity = [];
}


  

  // Query data for the chart

  $this->view('certificatereport', [
    'recentActivity' => $recentActivity,
'totalActivity' => $totalActivity,
  ]);

}
}