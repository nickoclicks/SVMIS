<?php

class Forms extends Controller
{
    public function index()
    {
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }

        // Get the user_id from the URL
        $user_id = $_GET['user_id'] ?? null;

        // Check if the user_id is valid
        if (!$user_id) {
            $this->redirect('profile'); // Redirect if no user_id is found
        }

        $form = new Form();
        $errors = null;

        // Fetch the complaints for the user
        $complaints = $form->getComplaintsByUserId($user_id); 

        // Fetch the list of violations
        $violations = $form->getViolations();  // Fetch violations from the model

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Collect form data
            $data = [
                'complaint' => $_POST['complaint'] ?? '',
                'date' => $_POST['date'] ?? '',
                'resp_name' => $_POST['resp_name'] ?? '',
                'resp_id' => $_POST['resp_id'] ?? '',
                'resp_course_year' => $_POST['resp_course_year'] ?? '',
                'resp_phone' => $_POST['resp_phone'] ?? '',
                'resp_address' => $_POST['resp_address'] ?? '',
                'resp_email' => $_POST['resp_email'] ?? '',
                'violations' => $_POST['violations'] ?? '',  // Add violations
                'ind_name' => $_POST['ind_name'] ?? '',
                'ind_position' => $_POST['ind_position'] ?? '',
                'ind_place' => $_POST['ind_place'] ?? '',
                'ind_date' => $_POST['ind_date'] ?? '',
                'ind_time' => $_POST['ind_time'] ?? '',
                'evidence' => $_POST['evidence'] ?? '',
                'wit_name' => $_POST['wit_name'] ?? '',
                'wit_contact' => $_POST['wit_contact'] ?? '',
                'status' => $_POST['status'] ?? 'Unresolved',  // Default status
                'user_id' => $user_id,
            ];

            // Validate and insert the data
            if ($form->validate($data)) {
                $form->insert($data);

                // Redirect to the profile of the specific user after successful insertion
                $this->redirect('profile/' . $user_id);
            } else {
                $errors = $form->errors;
            }
        }

        // Load the form view and pass any errors, complaints, and violations to it
        $this->view('form', [
            'errors' => $errors,
            'complaints' => $complaints,
            'violations' => $violations,  // Pass the violations to the view
            'user_id' => $user_id 
        ]);
    }

    public function getStudentIds()
    {
        $form = new Form();
        $term = $_GET['term'] ?? '';  // The search term sent via AJAX
        $studentIds = $form->getStudentIdSuggestions($term);
        echo json_encode($studentIds);  // Return the results as JSON
    }

    public function getRespondentDetails()
    {
        $form = new Form();
        $std_id = $_GET['std_id'] ?? '';  // The selected std_id sent via AJAX
        $respondentDetails = $form->getRespondentDetailsById($std_id);
        echo json_encode($respondentDetails);  // Return the results as JSON
    }

    public function edit($id = null)
    {
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }

        $form = new Form();
        $errors = array();

        if (count($_POST) > 0) {
            if ($form->validate($_POST)) {
                $form->update($id, $_POST);
                $row = $form->findById($id);
                $this->redirect('profile/' . $row->user_id);
            } else {
                $errors = $form->errors;
            }
        }

        $row = $form->where('id', $id);
        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Violations', 'violations'];
        $crumbs[] = ['Edit', 'violations/edit'];
        if ($row) {
            $row = $row[0];
        }
        $this->view('forms.edit', [
            'errors' => $errors,
            'row' => $row,
            'crumbs' => $crumbs
        ]);
    }
}
