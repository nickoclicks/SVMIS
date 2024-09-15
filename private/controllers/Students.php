<?php

class Students extends Controller
{
    function index()
    {
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }

        $user = new User();
        $school_id = Auth::getSchool_id();

        // Check if there is a search term
        $searchTerm = $_GET['search'] ?? '';

        if ($searchTerm) {
            // Query to search students by name
            $data = $user->query(
                "SELECT * FROM users WHERE rank = 'student' AND (firstname LIKE :search OR lastname LIKE :search) ORDER BY id DESC",
                [
                    
                    'search' => '%' . $searchTerm . '%'
                ]
            );
        } else {
            // Default query to get all students
            $data = $user->query(
                "SELECT * FROM users WHERE rank = 'student' ORDER BY id DESC",
               
            );
        }

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['students', 'students'];

        $this->view('students', [
            'rows' => $data,
            'crumbs' => $crumbs,
            'searchTerm' => $searchTerm,
        ]);
    }
}
