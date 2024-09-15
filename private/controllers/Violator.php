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
                    $this->redirect('violators'); // Fallback redirect if no user_id is found
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

            $this->view('violator.edit', [
                'errors' => $errors,
                'row' => $row,
                'compensations' => $compensations,
                'violationName' => $violationName,
                'userName' => $userName,
                'office' => $office
            ]);
        } else {
            $this->redirect('violators'); // If violation not found, redirect to violators list
        }
    }
}
