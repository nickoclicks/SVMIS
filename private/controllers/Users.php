<?php

class Users extends Controller
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
            // Query to search staff members by name
            $data = $user->query(
                "SELECT * FROM users WHERE rank IN ('staff', 'admin') AND (firstname LIKE :search OR lastname LIKE :search) ORDER BY id DESC",
                [
                    
                    'search' => '%' . $searchTerm . '%'
                ]
            );
        } else {
            // Default query to get all staff members
            $data = $user->query(
                "SELECT * FROM users WHERE rank IN ('staff', 'admin') ORDER BY id DESC",
                
            );
        }

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['staff', 'users'];

        $this->view('users', [
            'rows' => $data,
            'crumbs' => $crumbs,
            'searchTerm' => $searchTerm,
        ]);
    }
}
