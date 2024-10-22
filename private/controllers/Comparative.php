<?php
class Comparative extends Controller
{
    public function index()
    {
        // Check if the user is logged in; if not, redirect to the login page
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }

        // Instantiate the Archives model
        $archivesModel = new Archives();
        $violator = new Violators();


        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            // Handle the first set of filters
            if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
                $_SESSION['filters']['start_date'] = $_GET['start_date'];
                $_SESSION['filters']['end_date'] = $_GET['end_date'];
            }
            // Handle the second set of filters
            if (isset($_GET['vstart_date']) && isset($_GET['vend_date'])) {
                $_SESSION['filters1']['vstart_date'] = $_GET['vstart_date'];
                $_SESSION['filters1']['vend_date'] = $_GET['vend_date'];
            }
           
        }
        

        $filters = [
            'start_date' => $_GET['start_date'] ?? '',
        'end_date' => $_GET['end_date'] ?? '',
        ];

        $filterConditions = [];
        $queryParams = [];


        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $filterConditions[] = "archived_violators.date BETWEEN :start_date AND :end_date";
            $queryParams['start_date'] = $filters['start_date'];
            $queryParams['end_date'] = $filters['end_date'];
        } elseif (!empty($filters['start_date'])) {
            $filterConditions[] = "archived_violators.date >= :start_date";
            $queryParams['start_date'] = $filters['start_date'];
        } elseif (!empty($filters['end_date'])) {
            $filterConditions[] = "archived_violators.date <= :end_date";
            $queryParams['end_date'] = $filters['end_date'];
        }

          // Build the WHERE clause dynamically
          $whereClause = '';
          if (!empty($filterConditions)) {
              $whereClause = 'WHERE ' . implode(' AND ', $filterConditions);
          }
  
    

        $recentViolators = $archivesModel->query("
    SELECT archived_violators.*
    FROM archived_violators 
    $whereClause
    ORDER BY WEEKDAY(archived_violators.date)
  
", $queryParams);

if ($recentViolators === false) {
    $recentViolators = [];
}


//para ni sa violations
$filters1 = [
    'start_date_1' => $_GET['start_date_1'] ?? '',
'end_date_1' => $_GET['end_date_1'] ?? '',
];

$filterConditions1 = [];
$queryParams1 = [];


if (!empty($filters1['start_date_1']) && !empty($filters1['end_date_1'])) {
    $filterConditions1[] = "violators.date BETWEEN :start_date_1 AND :end_date_1";
    $queryParams1['start_date_1'] = $filters1['start_date_1'];
    $queryParams1['end_date_1'] = $filters1['end_date_1'];
} elseif (!empty($filters1['start_date_1'])) {
    $filterConditions1[] = "violators.date >= :start_date_1";
    $queryParams1['start_date_1'] = $filters1['start_date_1'];
} elseif (!empty($filters1['end_date_1'])) {
    $filterConditions1[] = "violators.date <= :end_date_1";
    $queryParams1['end_date_1'] = $filters1['end_date_1'];
}


  // Build the WHERE clause dynamically
  $whereClause = '';
  if (!empty($queryParams1)) {
      $whereClause = 'WHERE ' . implode(' AND ', $filterConditions1);
  }
  

  $recentViolators1 = $violator->query("
  SELECT violators.*, enrollment.year_level
  FROM violators 
  JOIN violations on violators.violation_id = violations.violation_id
  JOIN enrollment on violators.year_level_id = enrollment.year_level_id
  $whereClause
  ORDER BY WEEKDAY(violators.date)

", $queryParams1);
  
if ($recentViolators1 === false) {
  $recentViolators1 = [];
}

        // Get the school year from the request (if any)
   

        // Pass the data to the view for initial load
        $this->view('comparative', [
           
           
           
            'recentViolators' => $recentViolators,
            'recentViolators1' => $recentViolators1,
            'filters' => $filters, // Pass the filters to the view
    
           
        ]);
    }

    }
