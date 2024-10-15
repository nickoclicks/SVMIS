<?php

class StudentDashboard extends Controller
{
    public function index()
    {

        if (!Auth::logged_in()) {
            $this->redirect('login');
        }

        
        $violation = $this->load_model('Violators'); 
        $user = $this->load_model('User');
        $notice = $this->load_model('Form'); // Assuming you have a Notice model

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


        $totalUserViolations = count($violationsCommitted);

        $this->view('student_dashboard', [
            'totalUserViolations' => $totalUserViolations,
            'violationsCommitted' => $violationsCommitted,
            'totalNotices' => $totalNotices,
            'totalComplaints' => $totalComplaints,
        ]);
    }

    public function violationdetails()
{
    if (!Auth::logged_in()) {
        $this->redirect('login');
    }

    $violation = $this->load_model('Violators');
    $user = $this->load_model('User');
    $notice = $this->load_model('Form'); // Assuming you have a Notice model

    // Get user details
    $userRecord = $user->where('id', Auth::id());
    $user_id = $userRecord[0]->user_id;

    // Combine firstname and lastname for comparison
    $fullName = $userRecord[0]->firstname . ' ' . $userRecord[0]->lastname;
    $resp_name = $fullName;

    // Fetch data for notices
    $noticeQuery = "SELECT * FROM notice WHERE resp_name = :resp_name";
    $notices = $notice->query($noticeQuery, ['resp_name' => $resp_name]);

    // Fetch data for violations committed by the user
    $violationQuery = "
        SELECT violators.*, violations.violation 
        FROM violators 
        JOIN violations ON violators.violation_id = violations.violation_id 
        WHERE violators.user_id = :user_id";
    $violationsCommitted = $violation->query($violationQuery, ['user_id' => $user_id]);

    // Fetch data for complaints (if separate from notices)
    $complaintsQuery = "SELECT * FROM notice WHERE user_id = :user_id";
    $complaints = $notice->query($complaintsQuery, ['user_id' => $user_id]); // Adjust if you have a separate complaints model

    // Pass all the data to the view
    $this->view('student_dashboard_details', [
        'notices' => $notices,
        'violationsCommitted' => $violationsCommitted,
        'complaints' => $complaints
    ]);
}

public function complaintsdetails()
{
    if (!Auth::logged_in()) {
        $this->redirect('login');
    }

    $violation = $this->load_model('Violators');
    $user = $this->load_model('User');
    $notice = $this->load_model('Form'); // Assuming you have a Notice model

    // Get user details
    $userRecord = $user->where('id', Auth::id());
    $user_id = $userRecord[0]->user_id;

    // Combine firstname and lastname for comparison
    $fullName = $userRecord[0]->firstname . ' ' . $userRecord[0]->lastname;
    $resp_name = $fullName;

    // Fetch data for notices
    $noticeQuery = "SELECT * FROM notice WHERE resp_name = :resp_name";
    $notices = $notice->query($noticeQuery, ['resp_name' => $resp_name]);

    // Fetch data for violations committed by the user
    $violationQuery = "
        SELECT violators.*, violations.violation 
        FROM violators 
        JOIN violations ON violators.violation_id = violations.violation_id 
        WHERE violators.user_id = :user_id";
    $violationsCommitted = $violation->query($violationQuery, ['user_id' => $user_id]);

    // Fetch data for complaints (if separate from notices)
    $complaintsQuery = "SELECT * FROM notice WHERE user_id = :user_id";
    $complaints = $notice->query($complaintsQuery, ['user_id' => $user_id]); // Adjust if you have a separate complaints model

    // Pass all the data to the view
    $this->view('student_complaints_details', [
        'notices' => $notices,
        'violationsCommitted' => $violationsCommitted,
        'complaints' => $complaints
    ]);
}

public function noticesdetails()
{
    if (!Auth::logged_in()) {
        $this->redirect('login');
    }

    $violation = $this->load_model('Violators');
    $user = $this->load_model('User');
    $notice = $this->load_model('Form'); // Assuming you have a Notice model

    // Get user details
    $userRecord = $user->where('id', Auth::id());
    $user_id = $userRecord[0]->user_id;

    // Combine firstname and lastname for comparison
    $fullName = $userRecord[0]->firstname . ' ' . $userRecord[0]->lastname;
    $resp_name = $fullName;

    // Fetch data for notices
    $noticeQuery = "SELECT * FROM notice WHERE resp_name = :resp_name";
    $notices = $notice->query($noticeQuery, ['resp_name' => $resp_name]);

    // Fetch data for violations committed by the user
    $violationQuery = "
        SELECT violators.*, violations.violation 
        FROM violators 
        JOIN violations ON violators.violation_id = violations.violation_id 
        WHERE violators.user_id = :user_id";
    $violationsCommitted = $violation->query($violationQuery, ['user_id' => $user_id]);

    // Fetch data for complaints (if separate from notices)
    $complaintsQuery = "SELECT * FROM notice WHERE user_id = :user_id";
    $complaints = $notice->query($complaintsQuery, ['user_id' => $user_id]); // Adjust if you have a separate complaints model

    // Pass all the data to the view
    $this->view('student_notices_details', [
        'notices' => $notices,
        'violationsCommitted' => $violationsCommitted,
        'complaints' => $complaints
    ]);
}
}
