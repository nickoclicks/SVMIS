<?php

class StudentDashboard extends Controller
{
    public function index()
    {

        if (!Auth::logged_in()) {
            $this->redirect('login');
        }
        

        
        $violation = new Violation(); 
        $user = new User();
        $notice = new Form(); 
        $userRecord = $user->where('id', Auth::id());
        $user_id = $userRecord[0]->user_id; 

         // Check if the user record exists
         if (!empty($userRecord) && isset($userRecord[0]->firstname) && isset($userRecord[0]->lastname)) {
            // Combine firstname and lastname for comparison
            $fullName = $userRecord[0]->firstname . ' ' . $userRecord[0]->lastname;

            // Get the count of notices where the user is the respondent
            $noticeCountQuery = "
                SELECT COUNT(*) as totalNotices 
                FROM notice 
                WHERE resp_name = :resp_name
            ";
            $noticeCountResult = $notice->query($noticeCountQuery, ['resp_name' => $fullName]);

            // Extract the count
            $totalNotices = $noticeCountResult[0]->totalNotices ?? 0;
        }else {
            $fullName = '';
            $totalNotices = 0;
        }

         // Check if the user record exists
         if (!empty($userRecord)) {
            $user_id = $userRecord[0]->user_id;

            // Get the count of complaints filed by the user
            $complaintCountQuery = "
                SELECT COUNT(*) as totalComplaints 
                FROM notice 
                WHERE user_id = :user_id
            ";
            $complaintCountResult = $notice->query($complaintCountQuery, ['user_id' => $user_id]);

            // Extract the count of complaints
            $totalComplaints = $complaintCountResult[0]->totalComplaints ?? 0;
        } else {
            $totalComplaints = 0;
        }


        $query = "
            SELECT violators.*, violations.violation 
            FROM violators 
            JOIN violations ON violators.violation_id = violations.violation_id 
            WHERE violators.user_id = :user_id
            ORDER BY violators.date DESC";
        $violationsCommitted = $violation->query($query, ['user_id' => $user_id]);

        if ($violationsCommitted === false) {
            $violationsCommitted = [];
        }

       // Count the number of minor violations for the logged-in user
    $minorViolationCountQuery = "
     SELECT COUNT(*) as count 
        FROM violations v
        JOIN violators vi ON v.violation_id = vi.violation_id
        WHERE v.level = 'minor' AND vi.user_id = :user_id
  
";
$minorViolationCountResult = $violation->query($minorViolationCountQuery, ['user_id' => $user_id]);
$minorViolationCount = $minorViolationCountResult[0]->count ?? 0;

$majorViolationCountQuery = "
SELECT COUNT(*) as count 
   FROM violations v
   JOIN violators vi ON v.violation_id = vi.violation_id
   WHERE v.level = 'Major' AND vi.user_id = :user_id

";
$majorViolationCountResult = $violation->query($majorViolationCountQuery, ['user_id' => $user_id]);
$majorViolationCount = $majorViolationCountResult[0]->count ?? 0;


        $totalUserViolations = count($violationsCommitted);

        $this->view('student_dashboard', [
            'totalUserViolations' => $totalUserViolations,
            'violationsCommitted' => $violationsCommitted,
            'totalNotices' => $totalNotices,
            'totalComplaints' => $totalComplaints,
            'minorViolationCount' => $minorViolationCount,
            'majorViolationCount' => $majorViolationCount
        ]);
    }

}
