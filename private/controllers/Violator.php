<?php
class Violator extends Controller
{
    public function index()
    {
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }

        $violator = new Violators();
        $data = $violator->findAll();


        $this->view('violator', [
            'rows' => $data
        ]);
    }

  

    

    public function edit($id = null)
{
    if (!Auth::logged_in()) {
        $this->redirect('login');
    }

    $violator = new Violators();
    $errors = array();

    // Check if the form is submitted
    if (count($_POST) > 0) {
        if ($violator->validate($_POST)) {
            // Update violation details (status, etc.)
            $violator->update($id, $_POST);

            // Assuming the 'user_id' is part of the violator data
            $row = $violator->findById($id);

            if ($row && isset($row->user_id)) {
                // Redirect back to the specific user's profile after update
                $this->redirect('profile/' . $row->user_id);
            } else {
                $this->redirect('violators/edit'); // Fallback redirect if no user_id is found
            }
        } else {
            $errors = $violator->errors;
        }
    }

    // Fetch the violation's details by id for editing
    $row = $violator->findById($id);

    if ($row) {
        $compensations = $violator->getCompensationOptions($row->violation_id);
        $violationName = $violator->getViolationName($row->violation_id);
        $userName = $violator->getUserName($row->user_id);
        $office = $violator->getOffice($row->id);
        $userViolationStats = $violator->getUserViolationStats($row->user_id);
        $officeCounts = $violator->getOfficeCounts($row->user_id);
        $level = $violator->getViolationDescription($row->violation_id);
        $category = $violator->getViolationCategory($row->violation_id);

        // Get the count of minor violations
        $minorViolationCount = 0;
        foreach ($userViolationStats as $stats) {
            if ($stats->level == 'Minor') {
                $minorViolationCount += $stats->total_violations;
            }
        }

        $moderateViolationCount = 0;
        foreach ($userViolationStats as $stats) {
            if ($stats->level == 'Moderate') {
                $moderateViolationCount += $stats->total_violations;
            }
        }

        $majorViolationCount = 0;
        foreach ($userViolationStats as $stats) {
            if ($stats->level == 'Major') {
                $majorViolationCount += $stats->total_violations;
            }
        }

        // Toggle the visibility of sanctions based on the count of minor violations
        $showViolationSlip = $minorViolationCount == 1;
        $showWarningSlip = $minorViolationCount == 2;
        $showWrittenApology = $minorViolationCount == 2 || $minorViolationCount == 3 || $majorViolationCount >= 3;
        $showConference = $minorViolationCount == 2 && $minorViolationCount <= 4 || $minorViolationCount >= 5 || $majorViolationCount >= 1;
        $showCounseling = $minorViolationCount >= 4 || $majorViolationCount >= 1;
        $showCommunityService = $minorViolationCount == 2 && $minorViolationCount <= 4 || $majorViolationCount >= 1;
        $showViolationReport = $minorViolationCount == 3 || $minorViolationCount >= 5 || $majorViolationCount >= 1;
        $showRefer = $minorViolationCount > 1 || $majorViolationCount >= 1;
        $showCharacter = $minorViolationCount == 3 || $minorViolationCount == 4;
        $showFinalchar = $majorViolationCount >= 1 || $minorViolationCount >= 3;
        $showSuspension = $moderateViolationCount == 9 || $minorViolationCount == 9;
        $showNonre = $minorViolationCount == 9;
        $showExclusion = $majorViolationCount == 2;
        $showExpulsion = $majorViolationCount == 3;
        $showReportPolice = $majorViolationCount >= 3;


        $this->view('violator.edit', [
            'errors' => $errors,
            'row' => $row,
            'compensations' => $compensations,
            'violationName' => $violationName,
            'userName' => $userName,
            'office' => $office,
            'userViolationStats' => $userViolationStats,
            'officeCounts' => $officeCounts,
            'level' => $level,
            'category' => $category,
            'showCommunityService' => $showCommunityService,
            'showSuspension' => $showSuspension,
            'showRefer' => $showRefer,
            'showCharacter' => $showCharacter,
            'showFinalchar' => $showFinalchar,
            'showNonre' => $showNonre,
            'showExclusion' => $showExclusion,
            'showExpulsion' => $showExpulsion,
            'showViolationSlip' => $showViolationSlip,
            'showWarningSlip' => $showWarningSlip,
            'showWrittenApology' => $showWrittenApology,
            'showConference' => $showConference,
            'showViolationReport' => $showViolationReport,
            'showCounseling' => $showCounseling,
            'showReportPolice' => $showReportPolice,
            
        ]);
    } else {
        $this->redirect('violators'); // If violation not found, redirect to violators list
    }
}
}
