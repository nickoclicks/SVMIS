<?php


class Forms extends Controller
{
    public function index()
    {
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }
        $user_id = $_GET['user_id'] ?? null;
        if (!$user_id) {
            $this->redirect('profile'); 
        }
        $users = new User();
        $form = new Form();
        $errors = null;

        $appointmentsThisWeek = $form->getAppointmentsThisWeek();
        $usersmodel = $users->getUsers();
        
        $complaints = $form->getComplaintsByUserId($user_id);
        $violations = $form->getViolations();

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
                'appt_date' => $_POST['appt_date'] ?? '',
                'appt_time' => $_POST['appt_time'] ?? '',
                'sanction_party' => $_POST['sanction_party'] ?? '',
                'sanction_type' => $_POST['sanction_type'] ?? '',
                'hours' => $_POST['hours'] ?? '',
                'comm_date' => $_POST['comm_date'] ?? '',
                'comm_time' => $_POST['comm_time'] ?? '',
                'office' => $_POST['office'] ?? '',
                'status' => $_POST['status'] ?? 'Unresolved',  // Default status
                'user_id' => $user_id,
            ];

            if ($form->validate($data)) {
                $form->insert($data);
                
                $this->redirect('profile/' . $user_id . '#complainant');
            } else {
                $errors = $form->errors;
            }
        }

        $this->view('form', [
            'errors' => $errors,
            'complaints' => $complaints,
            'violations' => $violations,  
            'user_id' => $user_id,
            'users' => $usersmodel,
            'appointmentsThisWeek' => $appointmentsThisWeek
        ]);
    }

    public function getStudentIds()
    {
        $form = new Form();
        $term = $_GET['term'] ?? ''; 
        $studentIds = $form->getStudentIdSuggestions($term);
        echo json_encode($studentIds); 
    }

    public function getStudentName()
    {
        $form = new Form();
        $term = $_GET['term'] ?? ''; 
        $studentIds = $form->getStudentNameSuggestions($term);
        echo json_encode($studentIds); 
    }

    public function getRespondentDetails()
    {
        $form = new Form();
        $std_id = $_GET['std_id'] ?? ''; 
        $respondentDetails = $form->getRespondentDetailsById($std_id);
    
        if ($respondentDetails) {
            echo json_encode([
                'email' => $respondentDetails->email,
                'course' => $respondentDetails->course,
                'year_level_id' => $respondentDetails->year_level,
                'phone' => $respondentDetails->phone,
                'address' => $respondentDetails->address
            ]);
        } else {
            echo json_encode([]);
        }
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
                // Update the form entry in the database
                $form->update($id, $_POST);
        
                // Get the user ID after updating (for redirection)
                $row = $form->findById($id);
        
                // Redirect to the profile page with the correct user ID
                // No changes needed here
                $this->redirect('profile/' . $row->user_id);
            } else {
                // Capture validation errors if they exist
                $errors = $form->errors;
            }
        }
        
        // Find the form row data by ID
        $row = $form->where('id', $id);
        
        // Breadcrumbs setup
        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Violations', 'violations'];
        $crumbs[] = ['Edit', 'violations/edit'];
        
        if ($row) {
            // If the row is found, assign it for the view
            $row = $row[0];
        }
        
        // Load the form edit view, passing in any errors, the form row, and breadcrumbs
        $this->view('forms.edit', [
            'errors' => $errors ?? null,
            'row' => $row,
            'crumbs' => $crumbs
        ]);
        
    }

    

    

    

    
}
