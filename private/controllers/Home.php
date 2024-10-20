<?php

class Home extends Controller
{
    function index()
    {
       //Authentication para sa user 
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }
        //Initialize ang mga model nga kinahanglan para sa pag retrieve ug data
        $violation = new Violation();
        $violator = new Violators();
        $user = new User();
        $notice = new Form();

        // Fetch ang mga total counts, mao ni ang naa sa mga cards
        $totalViolations = $violation->countAll();
        $totalNotices = $notice->countAll();
        $totalSdcs = $notice->countAlll();
       

        $schoolYearId = 'all';

         // Check if the form is submitted
         if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['school_year_id'])) {
            $schoolYearId = $_POST['school_year_id'];
            
        }

        $schoolYearId1 = null;
        $schoolYearId2 = null;
        
        $totalViolations1 = null;
        $totalViolations2 = null;

        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['school_year_id_1'])) {
                $schoolYearId1 = $_POST['school_year_id_1'];
                $totalViolations1 = $this->fetchTotalViolations($schoolYearId1);
            }

            if (isset($_POST['school_year_id_2'])) {
                $schoolYearId2 = $_POST['school_year_id_2'];
                $totalViolations2 = $this->fetchTotalViolations($schoolYearId2);
            }
            
        }
        
// Determine the query based on the filter
if ($schoolYearId === 'all') {
    // Count all violators
    $totalViolators = $violator->countAll();
} else {
    // Count violators for a specific school year
    $totalViolatorsResult = $violator->query("SELECT COUNT(*) as count FROM violators WHERE school_year_id = :school_year_id", ['school_year_id' => $schoolYearId]);
    $totalViolators = 0;
    if (!empty($totalViolatorsResult) && isset($totalViolatorsResult[0]->count)) {
        $totalViolators = $totalViolatorsResult[0]->count;
    }
}
    
        
        // Fetch recent records with user data
        $recentViolations = $violation->findRecent(5); // Get the 5 most recent violations
        $recentViolators = $violator->query("
            SELECT violators.*, users.firstname, users.lastname, users.course, users.image, violations.violation, violations.level, users.std_id 
            FROM violators 
            JOIN users ON violators.user_id = users.user_id
            JOIN violations ON violators.violation_id = violations.violation_id 
            ORDER BY violators.date DESC 
            LIMIT 5
        ");

        // Get current logged-in user's user_id
        $userRecord = $user->where('id', Auth::id());
        $user_id = $userRecord[0]->user_id;  // Assuming user_id is retrieved correctly

        // Fetch the violations committed by the logged-in user
        $violationsCommitted = $violation->query("
            SELECT * 
            FROM violations 
            WHERE user_id = :user_id
            ORDER BY date DESC
        ", ['user_id' => $user_id]);

        // Check if the query returned results
        if ($violationsCommitted === false) {
            $violationsCommitted = [];
        }

        // Count total violations committed by the logged-in user
        $totalUserViolations = count($violationsCommitted);


        // Fetch data for the line chart based on different time periods
        $chartDataWeek = $violator->query("
        SELECT COUNT(id) as count, DAYNAME(date) as day 
    FROM violators 
    WHERE YEARWEEK(date, 1) = YEARWEEK(CURDATE(), 1)
    AND (:school_year_id = 'all' OR school_year_id = :school_year_id)
    GROUP BY WEEKDAY(date)
    ORDER BY WEEKDAY(date)
", ['school_year_id' => $schoolYearId]);
    
    if ($chartDataWeek !== false) {
        $chartLabelsWeek = array_column($chartDataWeek, 'day');
        $chartDataWeek = array_column($chartDataWeek, 'count');
    } else {
        $chartLabelsWeek = [];
        $chartDataWeek = [];
    }
    
   

    //fetch data for violters per day kanang tibook day nani ha
    $chartDataDay = $violator->query("
        SELECT COUNT(id) as count, DAYNAME(date) as day 
    FROM violators 
    WHERE (:school_year_id = 'all' OR school_year_id = :school_year_id)
    GROUP BY DAYNAME(date) 
    ORDER BY FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')
", ['school_year_id' => $schoolYearId]);

    
    $chartLabelsDay = array_column($chartDataDay, 'day');
    $chartDataDay = array_column($chartDataDay, 'count');
    
    
   // Fetch data for the current month (by week)
$chartDataMonth = $violator->query("
SELECT 
        COUNT(id) as count, 
        FLOOR((DAY(date) - 1) / 7) + 1 AS week, 
        MONTHNAME(date) as month 
    FROM violators 
    WHERE MONTH(date) = MONTH(CURDATE()) AND YEAR(date) = YEAR(CURDATE())
    AND (:school_year_id = 'all' OR school_year_id = :school_year_id)
    GROUP BY FLOOR((DAY(date) - 1) / 7) + 1, MONTHNAME(date) 
    ORDER BY FLOOR((DAY(date) - 1) / 7) + 1
", ['school_year_id' => $schoolYearId]);

if ($chartDataMonth !== false) {
    $chartLabelsMonth = array_map(function($row) {
        return $row->month . ' - Week ' . $row->week;
    }, $chartDataMonth);
    $chartDataMonth = array_column($chartDataMonth, 'count');
} else {
    $chartLabelsMonth = [];
    $chartDataMonth = [];
}
    // Fetch data for the current year (by month)
    // Fetch data for the current year (by month and week)
$chartDataYear = $violator->query("
SELECT 
        COUNT(id) as count, 
        FLOOR((DAY(date) - 1) / 7) + 1 AS week, 
        MONTHNAME(date) as month, 
        YEAR(date) as year 
    FROM violators 
    WHERE YEAR(date) = YEAR(CURDATE())
    AND (:school_year_id = 'all' OR school_year_id = :school_year_id)
    GROUP BY FLOOR((DAY(date) - 1) / 7) + 1, MONTHNAME(date), YEAR(date) 
    ORDER BY MONTH(date), FLOOR((DAY(date) - 1) / 7) + 1
", ['school_year_id' => $schoolYearId]);

$chartLabelsYear = array_map(function($row) {
return $row->month . ' - Week ' . $row->week;
}, $chartDataYear);

$chartDataYear = array_column($chartDataYear, 'count');
    
    // Default to weekly view
    $chartLabels = $chartLabelsWeek;
    $chartData = $chartDataWeek;


        

        // Fetch data for the pie chart
        $pieData = $this->getPieData($schoolYearId);

        // Prepare data for the pie chart
        $pieLabels = array_keys($pieData);
        $pieValues = array_values($pieData);


        // Fetch data for the bar chart
        $barChartData = $this->getBarChartData($schoolYearId);

        // Prepare data for the bar chart
        $barChartLabels = array_keys($barChartData);
        $barChartValues = array_values($barChartData);

        $statusDistribution = $this->getStatusDistribution($schoolYearId);

        // Prepare data for the stacked bar chart
        $statusLabels = $statusDistribution['labels'];
        $statusData = $statusDistribution['data'];

        // Pass all data to the view
        $this->view('home', [
            'totalViolations' => $totalViolations,
            'totalViolators' => $totalViolators,
            'totalSdcs' => $totalSdcs,
            'recentViolations' => $recentViolations,
            'recentViolators' => $recentViolators,
            'totalUserViolations' => $totalUserViolations,
            'violationsCommitted' => $violationsCommitted, // Pass the violations to the view
            'chartLabels' => $chartLabels, // Pass chart labels to the view
            'chartData' => $chartData,      // Pass chart data to the view
            'totalNotices' => $totalNotices,
            'pieLabels' => $pieLabels,     // Pass pie chart labels
            'pieData' => $pieValues,        // Pass pie chart data
            'barChartLabels' => $barChartLabels,  // Add this line
            'barChartData' => $barChartValues,
            'statusLabels' => $statusLabels,  // Pass status labels to the view
        'statusData' => $statusData,        // Pass status data to the view
        'chartLabels' => $chartLabels, // Existing data (if needed)
    'chartData' => $chartData,     // Existing data (if needed)
    'chartLabelsWeek' => $chartLabelsWeek,
    'chartDataWeek' => $chartDataWeek,
    'chartLabelsDay' => $chartLabelsDay,
    'chartDataDay' => $chartDataDay,
    'chartLabelsMonth' => $chartLabelsMonth,
    'chartDataMonth' => $chartDataMonth,
    'chartLabelsYear' => $chartLabelsYear,
    'chartDataYear' => $chartDataYear,
    'totalViolations1' => $totalViolations1,
            'totalViolations2' => $totalViolations2,
            'schoolYear1' => $schoolYearId1,
            'schoolYear2' => $schoolYearId2,
            
        ]);
    }


    private function fetchTotalViolations($schoolYearId)
    {
        $violation = new Violation();
        $totalViolationsResult = $violation->query("SELECT COUNT(*) as count FROM violators WHERE school_year_id = :school_year_id", ['school_year_id' => $schoolYearId]);
        $totalViolations = 0;
        if (!empty($totalViolationsResult) && isset($totalViolationsResult[0]->count)) {
            $totalViolations = $totalViolationsResult[0]->count;
        }
        return $totalViolations;
    }
    

    private function getPieData($schoolYearId)
{
    // Instantiate the models
    $violator = new Violators();
    $violation = new Violation();

    // Fetch violation distribution from the violators table with join to get violation names
    $query = "
       SELECT v.level AS violation_level, COUNT(vr.violation_id) AS count
            FROM violators vr
            JOIN violations v ON vr.violation_id = v.violation_id
            WHERE (:school_year_id = 'all' OR vr.school_year_id = :school_year_id)
            GROUP BY v.level
    ";

    $results = $violator->query($query, ['school_year_id' => $schoolYearId]);

    // Check if results are retrieved correctly
    if (!$results) {
        return [];
    }

    // Prepare data for the pie chart
    $pieData = [];
    foreach ($results as $row) {
        $pieData[$row->violation_level] = $row->count;
    }

    return $pieData;
}

// Replace the getBarChartData method with this new method
    private function getBarChartData($schoolYearId)
    {
        // Instantiate models
        $violator = new Violators();
        $user = new User();

        // Query to get the count of violators for each course
        $query = "
           SELECT u.course, COUNT(v.user_id) AS violator_count
            FROM violators v
            JOIN users u ON v.user_id = u.user_id
            WHERE (:school_year_id = 'all' OR v.school_year_id = :school_year_id)
            GROUP BY u.course
            ORDER BY COUNT(v.user_id) DESC
            LIMIT 3
        ";

        $results = $violator->query($query, ['school_year_id' => $schoolYearId]);

        // Check if results are retrieved correctly
        if (!$results) {
            return [];
        }

        // Prepare data for the bar chart
        $barChartData = [];
        foreach ($results as $row) {
            $barChartData[$row->course] = $row->violator_count;
        }

        return $barChartData;
    }

// Add this method to your Analytics controller
private function getStatusDistribution($schoolYearId)
{
    // Instantiate the models
    $violator = new Violators();

    // Fetch distribution of violations by status
    $query = "
        SELECT status, COUNT(*) as count
            FROM violators
            WHERE (:school_year_id = 'all' OR school_year_id = :school_year_id)
            GROUP BY status
    ";

    $results = $violator->query($query, ['school_year_id' => $schoolYearId]);

    // Check if results are retrieved correctly
    if (!$results) {
        return ['labels' => [], 'data' => []];
    }


    // Prepare data for the stacked bar chart
    $statusLabels = [];
    $statusData = [];

    foreach ($results as $row) {
        $statusLabels[] = $row->status;
        $statusData[] = $row->count;
    }

    return ['labels' => $statusLabels, 'data' => $statusData];
}




}

