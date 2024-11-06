<?php

class Login extends Controller
{
    function index()
    {
        $errors = array();
        
        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new User();
            $row = $user->where('email', $_POST['email']);
            
            // Verify user credentials
            if ($row && password_verify($_POST['password'], $row[0]->password)) {
                Auth::authenticate($row[0]);

                // Redirect based on user role
                if (Auth::isAdmin() || Auth::isSuperAdmin()) {
                    return $this->redirect('home'); 
                } elseif (Auth::isStudent()) {
                    return $this->redirect('studentdashboard');
                } else {
                    return $this->redirect('home');
                }
            }
            // If login fails, set error message
            $errors['email'] = "Wrong email or password";
        }
        
        // Render the login view with errors
        $this->view('login', [
            'errors' => $errors
        ]);
    }
}