<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

<div class="container mt-4">
    <h1>Print Preview</h1>
    <div id="print-preview">
        <div class="print-header">
            <h1>School Name</h1>
            <p>School Address</p>
        </div>
        <!-- Example Table -->
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Course</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($recentViolators)): ?>
                    <?php foreach ($recentViolators as $violator): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($violator->id); ?></td>
                            <td><?php echo htmlspecialchars($violator->firstname); ?></td>
                            <td><?php echo htmlspecialchars($violator->lastname); ?></td>
                            <td><?php echo htmlspecialchars($violator->course); ?></td>
                            <td><?php echo htmlspecialchars($violator->status); ?></td>
                            <td><?php echo htmlspecialchars(get_date($violator->date)); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No records found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <center>
        <button onclick="window.print()" class="btn btn-secondary" style="width: 10%;">Print</button>
    </center>
</div>

<?php $this->view('includes/footer'); ?>