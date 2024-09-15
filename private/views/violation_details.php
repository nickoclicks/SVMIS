<?php
// Fetch the violation ID from the URL
$violation_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch the violation details from the database
// (Replace with your actual database query)
$violation = get_violation_by_id($violation_id); // Replace with your actual function

if (!$violation) {
    echo '<h4>Violation details not found!</h4>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Violation Details</title>
    <!-- Include your CSS files here -->
</head>
<body>

<?php $this->view('/includes/header'); ?>
<?php $this->view('/includes/navigation'); ?>

<div class="container p-4">
    <h1>Violation Details</h1>
    <table class="table table-bordered">
        <tr><th>Violation</th><td><?php echo esc($violation->violation); ?></td></tr>
        <tr><th>Date Committed</th><td><?php echo get_date($violation->date); ?></td></tr>
        <tr><th>Description</th><td><?php echo esc($violation->description); ?></td></tr>
    </table>
</div>

<?php $this->view('includes/footer'); ?>

</body>
</html>
