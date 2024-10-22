<?php

class Profile extends Controller
{
    public function index($id = '')
    {
        // Fetch user details
        $user = new User();
        $row = $user->first('user_id', $id);

        $vio = new Violators();
       
       
$queryViolations = "
SELECT violators.*, violations.violation, violations.level, violations.category,
       (SELECT COUNT(*) FROM violators v2 
        JOIN violations v2_violations ON v2.violation_id = v2_violations.violation_id
        
        WHERE v2.user_id = violators.user_id 
          AND v2_violations.level = violations.level 
          AND v2_violations.category = violations.category
          AND v2.date <= violators.date) AS offense_count,
       violators.compensation,
       enrollment.year_level,
       semesters.semester_name,
       school_years.school_year
FROM violators 
JOIN violations ON violators.violation_id = violations.violation_id 
JOIN users ON violators.user_id = users.user_id
JOIN enrollment ON violators.year_level_id = enrollment.year_level_id
JOIN semesters ON violators.semester_id = semesters.semester_id
JOIN school_years ON violators.school_year_id = school_years.school_year_id
WHERE violators.user_id = :user_id";
$violations_committed = $vio->query($queryViolations, ['user_id' => $id]);

// Calculate unresolved violations



$violations_committed = $vio->query($queryViolations, ['user_id' => $id]);

if (is_array($violations_committed) || is_object($violations_committed)) {
        // Calculate sanctions for each violation
        foreach ($violations_committed as &$violation) {
            // Ensure the category is being accessed correctly
            if (isset($violation->category)) {
                $violation->sanctions = $this->getSanctionsForViolation($violation->offense_count, $violation->level, $violation->category);
            } else {
                // Handle the case where category is not set
                error_log('Category not set for violation ID: ' . $violation->violation_id);
            }
        }
    }
        
        $noticeModel = new Form();
        $queryNoticesAsComplainant = "
            SELECT * FROM notice
            WHERE user_id = :user_id";
        $noticesAsComplainant = $noticeModel->query($queryNoticesAsComplainant, ['user_id' => $id]);
        

        // Fetch notices where user is the respondent
        $noticeModel = new Form(); // Assuming you have a Form model
        $queryNoticesAsRespondent = "
        SELECT notice.*, users.firstname, users.lastname
        FROM notice
        JOIN users ON notice.user_id = users.user_id
        WHERE notice.resp_name = :resp_name";
    $noticesAsRespondent = $noticeModel->query($queryNoticesAsRespondent, ['resp_name' => $row->firstname . ' ' . $row->lastname]);

        // Pass user data, violations, and notices to the view
        $this->view('profile', [
            'row' => $row,
            'violations_committed' => $violations_committed,
            'noticesAsComplainant' => $noticesAsComplainant,
            'noticesAsRespondent' => $noticesAsRespondent,
            'yearLevelText' => $this->formatDateWithSuffix($row->year_level_id),

            
        ]);
    }


    

    function formatDateWithSuffix($yearLevel){
        $yearLevelText = '';
    
        if ($yearLevel == 1) {
            $yearLevelText = '1st';
        } elseif ($yearLevel == 2) {
            $yearLevelText = '2nd';
        } elseif ($yearLevel == 3) {
            $yearLevelText = '3rd';
        } elseif ($yearLevel == 4) {
            $yearLevelText = '4th';
        }
    
        return $yearLevelText;
    }

private function getSanctionsForViolation($offenseCount, $level, $category)
{
    $sanctions = [];

    if ($level == 'Minor') {
        if ($category == '1'){
            if ($offenseCount == 1) {
                $sanctions = ['Violation Slip'];
             } elseif ($offenseCount == 2) {
                $sanctions = ['Warning Slip', 'Written explanation and apology by the student','Conference with student','Community service for 4 hours'];
            } elseif ($offenseCount == 3) {
                $sanctions = ['Violation Report','Written explanation and apology by the student', 'Conference with Student','Community service for 6 hours','Character Probation'];
            } elseif ($offenseCount >= 3) {
                $sanctions = ['Violation Report','Written explanation and apology by the student', 'Conference with Student','Counseling','Community service for 10 hours','Character Probation'];
            }
        }
    } elseif ($level == 'Major') {
        if ($category == '1'){
        if ($offenseCount == 1) {
            $sanctions = ['Violation Report','Written explanation and apology by the student', 'Conference with Student','Counseling','Community service for 10 hours','Character Probation'];
        } elseif ($offenseCount == 2) {
            $sanctions = ['Community Service', 'Conference with Student'];
        } elseif ($offenseCount >= 3) {
            $sanctions = ['Suspension', 'Refer to Guidance'];
        }
    }
        elseif ($category == '2'){
            if ($offenseCount == 1) {
                $sanctions = ['Violation Report','Written explanation and apology by the student','Conference with Student and Parent','Community service for 15 hours','3 Weeks Suspension','Counseling','Referred to Police Authority','Final Character Probation'];
            }
            elseif($offenseCount >= 2) {
                $sanctions = ['Violation Report','Referred to Police Authority','Exclusion','Expulsion'];
            }
    }
    elseif ($category == '3'){
        if ($offenseCount >= 1) {
            $sanctions = ['Violation Report','Exclusion','Referred to Police Authority','Expulsion'];
        }
}
}


    return $sanctions;
}

function formatYearLevel($yearLevel) {
    switch ($yearLevel) {
        case 1:
            return '1st';
        case 2:
            return '2nd';
        case 3:
            return '3rd';
        case 4:
            return '4th';
        default:
            return ''; // Return empty for invalid year levels
    }
}



}