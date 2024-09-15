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
        $totalViolations = $violation->countAll();
        $totalViolators = $violator->countAll();
        $totalNotices = $notice->countAll();

        // Filter by status, year level, course, and month
        $filters = [
            'status' => $_GET['status'] ?? '',
            'year_level' => $_GET['year_level'] ?? '',
            'course' => $_GET['course'] ?? '',
            'month' => $_GET['month'] ?? ''
        ];

        $filterConditions = [];
        $queryParams = [];

        // Build query conditions based on filters
        if (!empty($filters['status'])) {
            $filterConditions[] = "notice.status = :status";
            $queryParams['status'] = $filters['status'];
        }
        if (!empty($filters['year_level'])) {
            $filterConditions[] = "users.year_level = :year_level";
            $queryParams['year_level'] = $filters['year_level'];
        }
        if (!empty($filters['course'])) {
            $filterConditions[] = "users.course = :course";
            $queryParams['course'] = $filters['course'];
        }
        if (!empty($filters['month'])) {
            $filterConditions[] = "MONTH(notice.date) = :month";
            $queryParams['month'] = $filters['month'];
        }

        // Build the WHERE clause dynamically
        $whereClause = '';
        if (!empty($filterConditions)) {
            $whereClause = 'WHERE ' . implode(' AND ', $filterConditions);
        }

        // Fetch filtered records for the table
        $recentViolators = $violator->query("
            SELECT notice.*, users.firstname, users.lastname, users.course, notice.status, users.std_id, users.year_level, users.middlename
            FROM notice 
            JOIN users ON notice.user_id = users.user_id
            $whereClause
            ORDER BY notice.date DESC
            LIMIT 10
        ", $queryParams);

        if ($recentViolators === false) {
            $recentViolators = [];
        }

        // Fetch records for specific statuses (you can remove this if not needed)
        $referred = $violator->query("
            SELECT notice.*, users.firstname, users.lastname, users.course, notice.status, users.std_id, users.year_level
            FROM notice 
            JOIN users ON notice.user_id = users.user_id
            WHERE notice.status = 'Referred to SDC'
            ORDER BY notice.date
            LIMIT 5
        ");

        $solvedcomp = $violator->query("
            SELECT notice.*, users.firstname, users.lastname, users.course, notice.status, users.std_id, users.year_level
            FROM notice 
            JOIN users ON notice.user_id = users.user_id
            WHERE notice.status = 'Solved'
            ORDER BY notice.date
            LIMIT 5
        ");

        $unresolvedcomp = $violator->query("
            SELECT notice.*, users.firstname, users.lastname, users.course, notice.status, users.std_id, users.year_level
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

        // Prepare data for the chart
        $chartLabels = array_column($violatorsData, 'date');
        $chartData = array_column($violatorsData, 'count');

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
            'filters' => $filters // Pass the filters to the view
        ]);
    }

    public function printReports()
    {
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }

        // Instantiate the model
        $notice = new Sdc();

        // Retrieve the selected report types from POST data
        $reportTypes = $_POST['report_type'] ?? [];

        // Prepare data based on the selected report types
        $data = [];
        foreach ($reportTypes as $type) {
            switch ($type) {
                case 'Referred to SDC':
                    $data['Referred to SDC'] = $notice->query("
                        SELECT notice.*, users.firstname, users.lastname, users.course, notice.status, users.middlename
                        FROM notice 
                        JOIN users ON notice.user_id = users.user_id 
                        WHERE status = 'Referred to SDC'
                        ORDER BY date
                    ");
                    break;
                case 'Resolved':
                    $data['Resolved'] = $notice->query("
                        SELECT notice.*, users.firstname, users.lastname, users.course, notice.status, users.middlename
                        FROM notice 
                        JOIN users ON notice.user_id = users.user_id 
                        WHERE status = 'Solved'
                        ORDER BY date
                    ");
                    break;
                case 'Unresolved':
                    $data['Unresolved'] = $notice->query("
                        SELECT notice.*, users.firstname, users.lastname, users.course, notice.status, users.middlename
                        FROM notice 
                        JOIN users ON notice.user_id = users.user_id 
                        WHERE status = 'Unresolved'
                        ORDER BY date
                    ");
                    break;
            }
        }

        // Generate the print view (you may need to create a separate view for printing)
        $this->view('print_reports', ['data' => $data]);
    }
}
