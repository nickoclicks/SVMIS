<?php

class Sdcs extends Controller
{
    public function index()
    {
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }

        // Instantiate the models
        $violation = new Violation();
        $violator = new Violators();
        $user = new User();
        $notice = new Form();

        // Fetch total counts
        $totalViolators = $violator->countAll();
        $totalViolations = $violation->countAll();
        $totalViolators = $violator->countAll();
        $totalNotices = $notice->countAll();

        // Filter by status, year level, course, and month
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
            $filterConditions[] = "notice.date BETWEEN :start_date AND :end_date";
            $queryParams['start_date'] = $filters['start_date'];
            $queryParams['end_date'] = $filters['end_date'];
        } elseif (!empty($filters['start_date'])) {
            $filterConditions[] = "notice.date >= :start_date";
            $queryParams['start_date'] = $filters['start_date'];
        } elseif (!empty($filters['end_date'])) {
            $filterConditions[] = "notice.date <= :end_date";
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
    SELECT notice.*, users.firstname, users.lastname, users.course, notice.status, users.std_id, users.year_level_id, users.middlename
    FROM notice 
    JOIN users ON notice.user_id = users.user_id
    $whereClause
    ORDER BY notice.date DESC
  
", $queryParams);

if ($recentViolators === false) {
    $recentViolators = [];
}

        // Fetch records for specific statuses (you can remove this if not needed)
        $referred = $violator->query("
            SELECT notice.*, users.firstname, users.lastname, users.course, notice.status, users.std_id, users.year_level_id
            FROM notice 
            JOIN users ON notice.user_id = users.user_id
            WHERE notice.status = 'Referred to SDC'
            ORDER BY notice.date
            LIMIT 5
        ");

        $solvedcomp = $violator->query("
            SELECT notice.*, users.firstname, users.lastname, users.course, notice.status, users.std_id, users.year_level_id
            FROM notice 
            JOIN users ON notice.user_id = users.user_id
            WHERE notice.status = 'Solved'
            ORDER BY notice.date
            LIMIT 5
        ");

        $unresolvedcomp = $violator->query("
            SELECT notice.*, users.firstname, users.lastname, users.course, notice.status, users.std_id, users.year_level_id
            FROM notice 
            JOIN users ON notice.user_id = users.user_id
            WHERE notice.status = 'Unresolved'
            ORDER BY notice.date
            LIMIT 10
        ");

        // Get current logged-in user's user_id
        $userRecord = $user->where('id', Auth::id());
        $user_id = $userRecord[0]->user_id;

        // Fetch violations committed by the logged-in user
        $violationsCommitted = $violation->query("
            SELECT * 
            FROM violations 
            WHERE user_id = :user_id
            ORDER BY date DESC
        ", ['user_id' => $user_id]);

        // Count total violations committed by the logged-in user
        $totalUserViolations = count($violationsCommitted);

        // Fetch violators data for the chart
        $violatorsData = $violator->query("
            SELECT COUNT(id) as count, DATE(date) as date 
            FROM violators 
            GROUP BY DATE(date) 
            ORDER BY DATE(date)
        ");

        $violatorsData = $violator->query("
        SELECT users.course, COUNT(violators.id) as count 
        FROM violators 
        JOIN users ON violators.user_id = users.user_id 
        GROUP BY users.course 
        ORDER BY count DESC
    ");
    
    
        // Prepare data for the chart
        $chartLabels = array_column($violatorsData, 'date');
        $chartData = array_column($violatorsData, 'count');

        $statuses = array_column($violatorsData, 'status');
        $statusCounts = array_count_values($statuses);

        // Pass all data to the view
        $this->view('sdcs', [
            'totalViolations' => $totalViolations,
            'totalViolators' => $totalViolators,
            'solvedcomp' => $solvedcomp,
            'unresolvedcomp' => $unresolvedcomp,
            'referred' => $referred,
            'recentViolators' => $recentViolators,
            'totalUserViolations' => $totalUserViolations,
            'violationsCommitted' => $violationsCommitted,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'totalNotices' => $totalNotices,
            'filters' => $filters, // Pass the filters to the view
            'totalViolators' => $totalViolators,
            'statusCounts' => $statusCounts, 
           
        ]);
    }

    public function printReports()
{
    if (!Auth::logged_in()) {
        $this->redirect('login');
    }

    // Instantiate the model
    $notice = new Sdc();
    $violator = new Violators();

    // Retrieve the selected report types from POST data
    $reportTypes = $_POST['report_type'] ?? [];

    // Prepare data based on the selected report types
    $data = [];
    $totalCount = 0; // Initialize a variable to store the total count
    foreach ($reportTypes as $type) {
        switch ($type) {
            case 'Referred to SDC':
                $result = $notice->query("
                    SELECT notice.*, users.firstname, users.lastname, users.course, notice.status, users.middlename
                    FROM notice 
                    JOIN users ON notice.user_id = users.user_id 
                    WHERE status = 'Referred to SDC'
                    ORDER BY date
                ");
                $data['Referred to SDC'] = $result;
                $totalCount += count($result); // Add the count to the total count
                break;
            case 'Resolved':
                $result = $notice->query("
                    SELECT notice.*, users.firstname, users.lastname, users.course, notice.status, users.middlename
                    FROM notice 
                    JOIN users ON notice.user_id = users.user_id 
                    WHERE status = 'Solved'
                    ORDER BY date
                ");
                $data['Resolved'] = $result;
                $totalCount += count($result); // Add the count to the total count
                break;
            case 'Unresolved':
                $result = $notice->query("
                    SELECT notice.*, users.firstname, users.lastname, users.course, notice.status, users.middlename
                    FROM notice 
                    JOIN users ON notice.user_id = users.user_id 
                    WHERE status = 'Unresolved'
                    ORDER BY date
                ");
                $data['Unresolved'] = $result;
                $totalCount += count($result); // Add the count to the total count
                break;
            case 'Community Service':
                $result = $notice->query("
                    SELECT notice.*, users.firstname, users.lastname, users.course, notice.status, violators.compensation, users.middlename
                FROM notice 
                JOIN users ON notice.user_id = users.user_id
                JOIN violators on notice.user_id = violators.user_id
                WHERE compensation = 'Community Service'
                ORDER BY date
                ");
                $data['Community Service'] = $result;
                $totalCount += count($result); // Add the count to the total count
                break;
        }
    }

    // Generate the print view (you may need to create a separate view for printing)
    $this->view('print_reports', ['data' => $data, 'totalCount' => $totalCount]);
}
}
