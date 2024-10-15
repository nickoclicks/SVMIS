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
        $user->toggleStatus(1);

        // Check if there is a search term
        $searchTerm = $_GET['search'] ?? '';

        if ($searchTerm) {
            $data = $user->searchStaffMembersByName($searchTerm);
        } else {
            $data = $user->getAllStaffMembers();
        }

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['staff', 'users'];

        $this->view('users', [
            'rows' => $data,
            'crumbs' => $crumbs,
            'searchTerm' => $searchTerm,
        ]);
    }

    public function edit($id = null)
{
    if (!Auth::logged_in()) {
        $this->redirect('login');
    }

    $user = new User();
    $errors = array();

    // Check if the form is submitted
    if (count($_POST) > 0) {
        if ($user->validate($_POST, true)) {
            // Update user details
            $user->update($id, $_POST);
            $row = $user->findById($id);

                if ($row && isset($row->user_id)) {

            $this->redirect("profile/" . $row->user_id);
            

            // Redirect back to the users list after update
            $this->redirect('users');
                }
        } else {
            $errors = $user->errors;
        }
    }

    // Fetch the user's details by id for editing
    $row = $user->findById($id);

    if ($row) {
        $this->view('profileinfo.edit', [
            'errors' => $errors,
            'row' => $row,
        ]);
    } else {
        $this->redirect('users'); // If user not found, redirect to users list
    }
}

public function toggleStatus($id = null)
{
    if (!Auth::logged_in()) {
        $this->redirect('login');
    }

    $user = new User();

    // Fetch the user's details by id
    $row = $user->findById($id);

    if ($row) {
        // Toggle the user's status
        $status = ($row->status == 'active') ? 'inactive' : 'active';
        $user->update($id, ['status' => $status]);

        // Redirect back to the users list
        $this->redirect('users');
    } else {
        $this->redirect('users'); // If user not found, redirect to users list
    }
}



}
