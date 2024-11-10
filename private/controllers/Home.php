<?php

class Home extends Controller
{
    function index()
    {
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }

        $violation = new Violation();
        $violator = new Violators();
        $user = new User();
        $notice = new Form();

        $totalViolations = $violator->countAlll();
        $totalNotices = $notice->countAll();
        $totalSdcs = $notice->countAlll();
        $totalViolators = $violator->countAll();
       
        $schoolYearId = 'all';
        $userRecord = $user->where('id', Auth::id());
        $user_id = $userRecord[0]->user_id; 

        $violationsCommitted = $violation->query("
            SELECT * 
            FROM violations 
            WHERE user_id = :user_id
            ORDER BY date DESC
        ", ['user_id' => $user_id]);

        if ($violationsCommitted === false) {
            $violationsCommitted = [];
        }

        $totalUserViolations = count($violationsCommitted);

        $chartDataWeek = $violator->query("
        SELECT COUNT(id) as count, DAYNAME(date) as day 
        FROM violators 
        WHERE YEARWEEK(date, 1) = YEARWEEK(CURDATE(), 1)
        AND (:school_year_id = :school_year_id)
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

    $chartDataDay = $violator->query("
        SELECT COUNT(id) as count, DAYNAME(date) as day 
    FROM violators 
    WHERE (:school_year_id = :school_year_id)
    GROUP BY DAYNAME(date) 
    ORDER BY FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')
", ['school_year_id' => $schoolYearId]);

    if($chartDataDay !== false) {
    $chartLabelsDay = array_column($chartDataDay, 'day');
    $chartDataDay = array_column($chartDataDay, 'count');
} else {
    $chartLabelsDay = [];
    $chartDataDay = [];

}

$chartDataMonth = $violator->query("
SELECT 
        COUNT(id) as count, 
        FLOOR((DAY(date) - 1) / 7) + 1 AS week, 
        MONTHNAME(date) as month 
    FROM violators 
    WHERE MONTH(date) = MONTH(CURDATE()) AND YEAR(date) = YEAR(CURDATE())
    AND (:school_year_id = :school_year_id)
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
$chartDataYear = $violator->query("
SELECT 
        COUNT(id) as count, 
        FLOOR((DAY(date) - 1) / 7) + 1 AS week, 
        MONTHNAME(date) as month, 
        YEAR(date) as year 
    FROM violators 
    WHERE YEAR(date) = YEAR(CURDATE())
    AND (:school_year_id = :school_year_id)
    GROUP BY FLOOR((DAY(date) - 1) / 7) + 1, MONTHNAME(date), YEAR(date) 
    ORDER BY MONTH(date), FLOOR((DAY(date) - 1) / 7) + 1
", ['school_year_id' => $schoolYearId]);

if ($chartDataYear !== false) {
    $chartLabelsYear = array_map(function($row) {
        return $row->month . ' - Week ' . $row->week;
    }, $chartDataYear);
    $chartDataYear = array_column($chartDataYear, 'count');
} else {
    $chartLabelsYear = [];
    $chartDataYear = [];
}

        $chartDataYear = array_column($chartDataYear, 'count');
        $chartLabels = $chartLabelsWeek;
        $chartData = $chartDataWeek;

        $pieData = $this->getPieData($schoolYearId);
        $pieLabels = array_keys($pieData);
        $pieValues = array_values($pieData);

        $barChartData = $this->getBarChartData($schoolYearId);
        $barChartLabels = array_keys($barChartData);
        $barChartValues = array_values($barChartData);

        $statusDistribution = $this->getStatusDistribution($schoolYearId);

        $statusLabels = $statusDistribution['labels'];
        $statusData = $statusDistribution['data'];

        $this->view('home', [
            'totalViolators' => $totalViolators,
            'totalViolations' => $totalViolations,
            'totalSdcs' => $totalSdcs,
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
            'statusData' => $statusData,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,   
            'chartLabelsWeek' => $chartLabelsWeek,
            'chartDataWeek' => $chartDataWeek,
            'chartLabelsDay' => $chartLabelsDay,
            'chartDataDay' => $chartDataDay,
            'chartLabelsMonth' => $chartLabelsMonth,
            'chartDataMonth' => $chartDataMonth,
            'chartLabelsYear' => $chartLabelsYear,
            'chartDataYear' => $chartDataYear,
        ]);
    }
    private function getPieData($schoolYearId)
{
    $violator = new Violators();
    $query = "
       SELECT v.level AS violation_level, COUNT(vr.violation_id) AS count
            FROM violators vr
            JOIN violations v ON vr.violation_id = v.violation_id
            WHERE (:school_year_id = 'all' OR vr.school_year_id = :school_year_id)
            GROUP BY v.level
    ";
    $results = $violator->query($query, ['school_year_id' => $schoolYearId]);
    if (!$results) {
        return [];
    }
    $pieData = [];
    foreach ($results as $row) {
        $pieData[$row->violation_level] = $row->count;
    }
    return $pieData;
}
    private function getBarChartData($schoolYearId)
    {
        $violator = new Violators();
        $query = "
           SELECT u.course, COUNT(v.user_id) AS violator_count
            FROM violators v
            JOIN users u ON v.user_id = u.user_id
            WHERE (:school_year_id = :school_year_id)
            GROUP BY u.course
            ORDER BY COUNT(v.user_id) DESC
            LIMIT 3
        ";
        $results = $violator->query($query, ['school_year_id' => $schoolYearId]);
        if (!$results) {
            return [];
        }
        $barChartData = [];
        foreach ($results as $row) {
            $barChartData[$row->course] = $row->violator_count;
        }

        return $barChartData;
    }
private function getStatusDistribution($schoolYearId)
{
    $violator = new Violators();
    $query = "
        SELECT status, COUNT(*) as count
            FROM violators
            WHERE (:school_year_id = :school_year_id)
            GROUP BY status
    ";
    $results = $violator->query($query, ['school_year_id' => $schoolYearId]);
    if (!$results) {
        return ['labels' => [], 'data' => []];
    }
    $statusLabels = [];
    $statusData = [];
    foreach ($results as $row) {
        $statusLabels[] = $row->status;
        $statusData[] = $row->count;
    }
    return ['labels' => $statusLabels, 'data' => $statusData];
}
}