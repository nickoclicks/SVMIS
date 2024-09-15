<?php

class Profile extends Controller
{
    public function index($id = '')
    {
        // Fetch user details
        $user = new User();
        $row = $user->first('user_id', $id);

        // Fetch violations committed by the user with violation details
        $vio = new Violators();
        $queryViolations = "
            SELECT violators.*, violations.violation 
            FROM violators 
            JOIN violations ON violators.violation_id = violations.violation_id 
            WHERE violators.user_id = :user_id";
        $violations_committed = $vio->query($queryViolations, ['user_id' => $id]);

        // Fetch notices where user is the complainant
        $noticeModel = new Form(); // Assuming you have a Form model
        $queryNoticesAsComplainant = "
            SELECT * FROM notice
            WHERE user_id = :user_id";
        $noticesAsComplainant = $noticeModel->query($queryNoticesAsComplainant, ['user_id' => $id]);

        // Fetch notices where user is the respondent
        // Assuming resp_name is the concatenation of firstname and lastname
        $queryNoticesAsRespondent = "
            SELECT * FROM notice
            WHERE resp_name = :resp_name";
        $respName = $row->firstname . ' ' . $row->lastname;
        $noticesAsRespondent = $noticeModel->query($queryNoticesAsRespondent, ['resp_name' => $respName]);

        // Pass user data, violations, and notices to the view
        $this->view('profile', [
            'row' => $row,
            'violations_committed' => $violations_committed,
            'noticesAsComplainant' => $noticesAsComplainant,
            'noticesAsRespondent' => $noticesAsRespondent,
        ]);
    }

    function formatDateWithSuffix($timestamp){
        $day = date('j', $timestamp);
        $daySuffix = '';

        if ($day == 1 || $day == 21 || $day == 31) {
            $daySuffix = 'st';
        } elseif ($day == 2 || $day == 22) {
            $daySuffix = 'nd';
        } elseif ($day == 3 || $day == 23){
            $daySuffix = 'rd';
        }

        return date('jS', $timestamp) . 'day of ' . date('F Y'. $timestamp);

}
}