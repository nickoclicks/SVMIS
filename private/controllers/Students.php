<?php

class Students extends Controller
{
    function index()
    {
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }

        $user = new User();
        $violator = new Violators();
        $form = new Form();
        $school_id = Auth::getSchool_id();

        

        // Check if there is a search term
        $searchTerm = $_GET['search'] ?? '';

        if ($searchTerm) {
            $data = $user->searchStudentsByName($searchTerm);
        } else {
            $data = $user->getAllStudents();
        }

        if (is_array($data) || is_object($data)) {
            foreach ($data as &$student) {
                $student->unresolved_violations = $violator->countUnresolvedByUserId($student->user_id);
            }
        
            foreach ($data as &$student) {
                $student->unresolved_notices = $form->countUnresolvedNoticesByUserId($student->std_id);
            }
        } else {
            // Handle the case where $data is not valid (e.g., log an error or set $data to an empty array)
            $data = []; // or handle the error as needed
        }

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['students', 'students'];

        $this->view('students', [
            'rows' => $data,
            'crumbs' => $crumbs,
            'searchTerm' => $searchTerm,
        ]);
    }

    public function create()
    {
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }

        $user = new User();
        $enrollment = new Enrollment();
        $errors = array();

       

        $this->view('signup', [
            'errors' => $errors,
        ]);
    }

    

}
