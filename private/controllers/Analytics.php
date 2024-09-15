<?php

class Analytics extends Controller
{
    function index()
    {
        // Check if the user is logged in
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }
        
        // Instantiate the models
        $violation = new Violation();
        $violator = new Violators();
        $user = new User();
        $notice = new Form();

        // Fetch total counts
        $totalViolations = $violation->countAll();
        $totalViolators = $violator->countAll();
        $totalNotices = $notice->countAll();
       
        // Fetch recent records with user data
        $recentViolations = $violation->findRecent(5); // Get the 5 most recent violations
        $recentViolators = $violator->query("
            SELECT violators.*, users.firstname, users.lastname, users.course, users.image 
            FROM violators 
            JOIN users ON violators.user_id = users.user_id 
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

        // Fetch violators data for the line chart
        $violatorsData = $violator->query("
            SELECT COUNT(id) as count, DATE(date) as date 
            FROM violators 
            GROUP BY DATE(date) 
            ORDER BY DATE(date)
        ");

        // Prepare data for the line chart
        $chartLabels = array_column($violatorsData, 'date');
        $chartData = array_column($violatorsData, 'count');

        // Fetch data for the pie chart
        $pieData = $this->getPieData();

        // Prepare data for the pie chart
        $pieLabels = array_keys($pieData);
        $pieValues = array_values($pieData);


        // Fetch data for the bar chart
        $barChartData = $this->getBarChartData();

        // Prepare data for the bar chart
        $barChartLabels = array_keys($barChartData);
        $barChartValues = array_values($barChartData);

        $statusDistribution = $this->getStatusDistribution();

        // Prepare data for the stacked bar chart
        $statusLabels = $statusDistribution['labels'];
        $statusData = $statusDistribution['data'];

        // Pass all data to the view
        $this->view('analytics', [
            'totalViolations' => $totalViolations,
            'totalViolators' => $totalViolators,
            'recentViolations' => $recentViolations,
            'recentViolators' => $recentViolators,
            'totalUserViolations' => $totalUserViolations,
            'violationsCommitted' => $violationsCommitted, 
            'chartLabels' => $chartLabels,
            'chartData' => $chartData, 
            'totalNotices' => $totalNotices,
            'pieLabels' => $pieLabels, 
            'pieData' => $pieValues,     
            'barChartLabels' => $barChartLabels,
            'barChartData' => $barChartValues,
            'statusLabels' => $statusLabels,
            'statusData' => $statusData
        ]);
    }

    private function getPieData()
{
    // Instantiate the models
    $violator = new Violators();
    $violation = new Violation();

    // Fetch violation distribution from the violators table with join to get violation names
    $query = "
        SELECT v.violation AS violation_name, COUNT(vr.violation_id) AS count
        FROM violators vr
        JOIN violations v ON vr.violation_id = v.violation_id
        GROUP BY v.violation
    ";

    $results = $violator->query($query);

    // Check if results are retrieved correctly
    if (!$results) {
        return [];
    }

    // Prepare data for the pie chart
    $pieData = [];
    foreach ($results as $row) {
        $pieData[$row->violation_name] = $row->count;
    }

    return $pieData;
}

private function getBarChartData()
{
    // Instantiate models
    $violator = new Violators();
    $user = new User();

    // Query to get the count of violations for each student
    $query = "
        SELECT u.firstname, u.lastname, COUNT(v.user_id) AS violation_count
        FROM violators v
        JOIN users u ON v.user_id = u.user_id
        GROUP BY u.user_id
        ORDER BY COUNT(v.user_id) DESC
        LIMIT 5
    ";

    $results = $violator->query($query);

    // Check if results are retrieved correctly
    if (!$results) {
        return [];
    }

    // Prepare data for the bar chart
    $barChartData = [];
    foreach ($results as $row) {
        $fullName = $row->firstname . ' ' . $row->lastname;
        $barChartData[$fullName] = $row->violation_count;
    }

    return $barChartData;
}

// Add this method to your Analytics controller
private function getStatusDistribution()
{
    // Instantiate the models
    $violator = new Violators();

    // Fetch distribution of violations by status
    $query = "
        SELECT status, COUNT(*) as count
        FROM violators
        GROUP BY status
    ";

    $results = $violator->query($query);

    // Check if results are retrieved correctly
    if (!$results) {
        return [];
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
