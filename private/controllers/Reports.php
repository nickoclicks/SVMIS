<?php

class Reports extends Controller {
  public function index()
  {
  if (!Auth::logged_in()) {
    $this->redirect('login');
  }

  $violation = new Violation();
  $violator = new Violators();
  $user = new User();
  $notice = new Form();

  

  $totalViolators = $violator->countAll();

  $filters = [
    'status' => $_GET['status'] ?? '',
    'year_level_id' => $_GET['year_level_id'] ?? '',
    'course' => $_GET['course'] ?? '',
    'month' => $_GET['month'] ?? '',
    'start_date' => $_GET['start_date'] ?? '',
'end_date' => $_GET['end_date'] ?? '',
'student_id' => $_GET['student_id'] ?? '',
];

$filterConditions = [];
        $queryParams = [];


   // Build query conditions based on filters
   if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
    $filterConditions[] = "violators.date BETWEEN :start_date AND :end_date";
    $queryParams['start_date'] = $filters['start_date'];
    $queryParams['end_date'] = $filters['end_date'];
} elseif (!empty($filters['start_date'])) {
    $filterConditions[] = "violators.date >= :start_date";
    $queryParams['start_date'] = $filters['start_date'];
} elseif (!empty($filters['end_date'])) {
    $filterConditions[] = "violators.date <= :end_date";
    $queryParams['end_date'] = $filters['end_date'];
}
if (!empty($filters['status'])) {
    $filterConditions[] = "notice.status = :status";
    $queryParams['status'] = $filters['status'];
}
if (!empty($filters['year_level_id'])) {
    $filterConditions[] = "users.year_level_id = :year_level_id";
    $queryParams['year_level_id'] = $filters['year_level_id'];
}
if (!empty($filters['course'])) {
    $filterConditions[] = "users.course = :course";
    $queryParams['course'] = $filters['course'];
}
if (!empty($filters['month'])) {
    $filterConditions[] = "MONTH(notice.date) = :month";
    $queryParams['month'] = $filters['month'];
}
if (!empty($filters['student_id'])) {
    $filterConditions[] = "users.std_id = :student_id"; // Add condition for student_id
    $queryParams['student_id'] = $filters['student_id'];
}

// Build the WHERE clause dynamically
$whereClause = '';
if (!empty($filterConditions)) {
    $whereClause = 'WHERE ' . implode(' AND ', $filterConditions);
}

  $recentViolators = $violator->query("
  SELECT violators.*, users.firstname, users.middlename, users.lastname, users.course, users.std_id, violations.violation, violators.date, enrollment.year_level
  FROM violators
  INNER JOIN users on violators.user_id = users.user_id
  INNER JOIN violations on violators.violation_id = violations.violation_id
  INNER JOIN enrollment on users.year_level_id = enrollment.year_level_id 
  $whereClause
  ORDER BY violators.date DESC
  ", $queryParams);

  if ($recentViolators === false) {
    $recentViolators = [];
}

$violatorsData = $violator->query("
SELECT users.course, COUNT(violators.id) as count, violators.date
FROM violators 
JOIN users ON violators.user_id = users.user_id 
GROUP BY users.course, violators.date 
ORDER BY count DESC
");

$courseData = $violator->query("
SELECT users.course, COUNT(violators.id) as count
FROM violators 
JOIN users ON violators.user_id = users.user_id 
$whereClause
GROUP BY users.course
", $queryParams);

$dateData = $violator->query("
SELECT violators.date, COUNT(violators.id) as count
FROM violators 
JOIN users ON violators.user_id = users.user_id 
$whereClause
GROUP BY violators.date 
ORDER BY violators.date DESC
", $queryParams);


$yearData = $violator->query("
SELECT enrollment.year_level, COUNT(violators.id) as count
FROM violators 
JOIN users ON violators.user_id = users.user_id 
JOIN enrollment on violators.year_level_id = enrollment.year_level_id
$whereClause
GROUP BY enrollment.year_level
", $queryParams);


$yrLabels = array_column($yearData, 'year_level');
$yrCounts = array_column($yearData, 'count');



$courseLabels = array_column($courseData, 'course');
$courseCounts = array_column($courseData, 'count');

$dateLabels = array_column($dateData, 'date');
$dateCounts = array_column($dateData, 'count');

 
  $statuses = array_column($violatorsData, 'status');
  $statusCounts = array_count_values($statuses);

  // Query data for the chart

  $this->view('violationrep', [
    'recentViolators' => $recentViolators,
    'totalViolators' => $totalViolators,
    'statusCounts' => $statusCounts, 
    'filters' => $filters,
    'dateLabels' => $dateLabels, // New date labels for the chart
    'dateCounts' => $dateCounts, 
    'courseLabels' => $courseLabels,
    'courseCounts' => $courseCounts,
    'yrLabels' => $yrLabels,
    'yrCounts' => $yrCounts

  ]);

}
}