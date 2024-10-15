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

        foreach ($data as &$student) {
            $student->unresolved_violations = $violator->countUnresolvedByUserId($student->user_id);
        }

        foreach ($data as &$student) {
            $student->unresolved_notices = $form->countUnresolvedNoticesByUserId($student->std_id);
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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $this->db->beginTransaction();

                // Validate and create user
                if ($user->validate($_POST)) {
                    $userId = $user->create($_POST);

                    if ($userId) {
                        // Prepare and create enrollment
                        $enrollmentData = [
                            'user_id' => $userId,
                            'year_level' => $_POST['year_level']
                        ];

                        if ($enrollment->create($enrollmentData)) {
                            $this->db->commit();
                            $this->redirect('users');
                        } else {
                            throw new Exception("Failed to insert enrollment data.");
                        }
                    }
                } else {
                    $errors = $user->errors;
                }
            } catch (Exception $e) {
                $this->db->rollBack();
                $errors[] = $e->getMessage();
            }
        }

        $this->view('signup', [
            'errors' => $errors,
        ]);
    }

    

}
