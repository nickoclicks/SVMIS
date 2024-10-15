<?php

class Login extends Controller
{
    function index()
    {
        $errors = array();

        if (count($_POST) > 0) {
            $user = new User();

            if ($row = $user->where('email', $_POST['email'])) {

                $row = $row[0];
                if (password_verify($_POST['password'], $row->password)) {
                    Auth::authenticate($row); 

                    if (Auth::isAdmin() || Auth::isSuperAdmin()) {
                        log_activity('Admin Login ' . $row->firstname . ' ' . $row->lastname);
                        $this->redirect('home'); 
                    } elseif (Auth::isStudent()) {
                        log_activity('Student Login ' . $row->firstname . ' ' . $row->lastname);
                        $this->redirect('studentdashboard');
                    } else {
                        log_activity('User  Login ' . $row->firstname . ' ' . $row->lastname);
                        $this->redirect('home');
                    }
                  
                    if (Auth::isAdmin() || Auth::isSuperAdmin()) {
                        $this->redirect('home'); 
                    } elseif (Auth::isStudent()) {
                        $this->redirect('studentdashboard');
                    } else {
                        
                        $this->redirect('home');
                    }
                }
            }

            $errors['email'] = "Wrong email or password";
        }

        $this->view('login', [
            'errors' => $errors
        ]);

        
    }

    
}
