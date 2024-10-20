<?php

class Violations extends Controller
{
    public function index()
    {
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }

        $violations = new Violation();
        $data = $violations->findAll();


        
        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Violations', 'violations'];

        $this->view('violations', [
            'crumbs' => $crumbs,
            'rows' => $data
        ]);
    }

    public function add()
    {
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }

        $errors = array();
        $violations = new Violation();

        if (count($_POST) > 0) {
            if ($violations->validate($_POST)) {
                $arr['violation'] = $_POST['violation'];
                $arr['description'] = $_POST['description'];
                $arr['category'] = $_POST['category'];
                $arr['compensation'] = $_POST['compensation'];
                $arr['level'] = $_POST['level'];
                $arr['date'] = date("Y-m-d H:i:s");
                $violations->insert($arr);
                $this->redirect('violations');
            } else {
                $errors = $violations->errors;
            }
        }

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Violations', 'violations'];
        $crumbs[] = ['Add', 'violations/add'];

        $this->view('violations.add', [
            'errors' => $errors,
            'crumbs' => $crumbs
        ]);
    }

    public function edit($id = null)
    {
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }

        $violations = new Violation();
        $errors = array();

        if (count($_POST) > 0) {
            if ($violations->validate($_POST)) {
                $violations->update($id, $_POST);
                $this->redirect('violations');
            } else {
                $errors = $violations->errors;
            }
        }

        $row = $violations->where('id', $id);
        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Violations', 'violations'];
        $crumbs[] = ['Edit', 'violations/edit'];
        if ($row) {
            $row = $row[0];
        }
        $this->view('violations.edit', [
            'errors' => $errors,
            'row' => $row,
            'crumbs' => $crumbs
        ]);
    }

    public function delete($id = null)
    {
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }

        $violations = new Violation();
        $errors = array();

        if (count($_POST) > 0) {
            $violations->delete($id);
            $this->redirect('violations');
        }

        $row = $violations->where('id', $id);
        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Violations', 'violations'];
        $crumbs[] = ['Delete', 'violations/delete'];

        $row = $row[0];
        $this->view('violations.delete', [
            'row' => $row,
            'crumbs' => $crumbs
        ]);
    }

    public function assign($violation_id)
{
    $user_id = $_GET['user_id'] ?? null;

    if ($user_id && $violation_id) {
        $violations = new Violation();
        $violations->assignViolationToUser($violation_id, $user_id);

        $user = new User();
        $user_data = $user->where('id', $user_id);

        if ($user_data) {
            $user_id = $user_data[0]->user_id;
            error_log("Redirecting to profile of user: $user_id");
            $this->redirect("profile/$user_id");
        } else {
            error_log("User not found with ID: $user_id");
            $this->redirect("violations");
        }
    } else {
        error_log("Violation or User ID not provided");
        $this->redirect("violations");
    }
}
/*public function updateStatus()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $postData = json_decode(file_get_contents('php://input'), true);
        $violationId = $postData['id'] ?? null;
        $newStatus = $postData['status'] ?? null;

        error_log('Received POST data: ' . print_r($postData, true)); // Log the received data

        if (empty($violationId) || empty($newStatus)) {
            echo json_encode(['success' => false, 'message' => 'Invalid input.']);
            return;
        }

        $model = $this->loadModel('Violators');
        $result = $model->updateViolationStatus($violationId, $newStatus);

        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database update failed.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    }
}


  /*  public function getViolationDetails()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $model = $this->loadModel('Violators');
            $violation = $model->getViolationById($id);

            if ($violation) {
                echo json_encode($violation);
            } else {
                echo json_encode(null);
            }
        } else {
            echo json_encode(null);
        }
    }

   /* public function details($violation_id)
{
    // Load the violation model
    $violationModel = new Violation();

    // Fetch the violation details by ID
    $violation = $violationModel->getViolationById($violation_id);

    // Check if the request method is POST to update the status
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['status'], $_POST['violation_id'])) {
        $status = $_POST['status'];
        $violation_id = $_POST['violation_id'];

        // Update the status in the database
        $violationModel->updateStatus($violation_id, $status);

        // Redirect to the same page to reflect the updated status
        header("Location: " . ROOT . "/violations/details/$violation_id");
        exit;
    }

    // Pass the violation details to the view
    $this->view('private/personal_violation', ['violation' => $violation]);
*/
    }





    

