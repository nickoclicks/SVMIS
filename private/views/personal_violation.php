<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

<div class="container-fluid p-4 shadow mx-auto" style="max-width: 1000px; margin-top: 40px">
    <?php
    // Ensure the violation_id is present in the URL
    if (isset($_GET['violation_id'])) {
        $violation_id = $_GET['violation_id'];

        // Query to fetch the violation details
        $query = "SELECT * FROM violators WHERE id = :id";
        $params = [':id' => $violation_id];

        // Assuming $db is your database connection instance
        $violation = $db->query($query, $params)->fetch(PDO::FETCH_OBJ);

        if ($violation): ?>
            <h3>Violation Details</h3>
            <table class="table table-hover table-striped table-bordered">
                <tr><th>Violation:</th><td><?php echo esc($violation->violation); ?></td></tr>
                <tr><th>Date Committed:</th><td><?php echo get_date($violation->date); ?></td></tr>
                <tr><th>Status:</th><td><?php echo ucfirst($violation->status); ?></td></tr>
                <tr><th>Resolution:</th><td><?php echo esc($violation->resolution); ?></td></tr>
            </table>

            <a href="<?= ROOT ?>/update_violation.php?violation_id=<?php echo $violation->id; ?>" class="btn btn-primary">Update Violation</a>
        <?php else: ?>
            <h3 class="text-center">Violation not found!</h3>
        <?php endif;
    } else {
        echo "<h3 class='text-center'>No violation ID provided.</h3>";
    }
    ?>

<?php $this->view('includes/footer'); ?>
