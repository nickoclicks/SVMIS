<?php

class Comparative extends Controller
{
    public function index()
    {
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }

        $archivesModel = new Archives();

        // Fetch total number of violations per day of the week
        $violationsPerDay = $this->getViolationsPerDay($archivesModel);

        // Pass the data to the view for chart display
        $this->view('comparative', [
            'violationsPerDay' => $violationsPerDay,
        ]);
    }

    private function getViolationsPerDay($model)
    {
        // Query to get the total number of violations grouped by day of the week
        $query = "
            SELECT DAYOFWEEK(date) as day_of_week, COUNT(*) as total_violations
            FROM archived_violators
            GROUP BY day_of_week
            ORDER BY day_of_week
        ";

        // Execute the query and return the results
        return $model->query($query);
    }
    
}