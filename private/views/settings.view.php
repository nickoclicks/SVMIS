<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f7fa;
        margin: 0;
        padding: 20px;
    }

    .dashboard-container {
        max-width: 1700px;
        margin: 0 auto;
        margin-left: -140px;
    }

    h1 {
    color: #007bff; /* Set the text color */
    font-size: 1.2rem; /* Increase the font size */
    font-weight: bold; /* Make the text bold */
    text-align: start; /* Center align the text */
    
    padding: 10px; /* Add padding */
    
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1); /* Add a subtle text shadow */
    background-color: #f4f7fa; /* Optional: Add a background color */
    border-radius: 5px; /* Optional: Round the corners */
}


    .card {
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
        padding: 5px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th, .table td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
    }

    .table th {
        background-color: #007bff;
        color: white;
        font-weight: bold;
    }

    .table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .table tr:hover {
        background-color: #f1f1f1;
    }

    .text-reset {
        color: #007bff;
        text-decoration: none;
    }

    .text-reset:hover {
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .table {
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }
    }
    .card-custom-height {
        height: 200px; /* Set your desired height */
        overflow-y: auto; /* Enable vertical scrolling */
    }
    thead {
    position: sticky; /* Make the header sticky */
    top: 0; /* Set the top position */
    z-index: 1; /* Ensure it stays above other content */
    background-color: #007bff; /* Add background color for visibility */
    color: white; /* Text color for contrast */
}
</style>

<div class="dashboard-container">
    <h1 style="text-align: center;">Notice Appointment Notification</h1>

    <div class="row">
        <div class="col-md-12">

            <h1>Today</h1>
            <div class="card card-custom-height">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Appointment Date</th>
                            <th>Appointment Time</th>
                            <th>Complainant</th>
                            <th>Respondent</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (is_array($appointments) || is_object($appointments)): ?>
    <?php foreach ($appointments as $appointment): ?>
        <tr>
            <td><?= get_date($appointment->appt_date); ?></td>
            <td><?= date('g:i A', strtotime($appointment->appt_time)) ?></td>
            <td>
                <?php
                $compNameForLink = str_replace(' ', '.', $appointment->user_id);
                ?>
                <?php if (Auth::isAdmin()): ?>
                    <a href="<?= ROOT ?>/profile/<?= urlencode($compNameForLink) ?> #complainant" class="text-reset">
                <?php endif ?>
                <?= htmlspecialchars(ucwords(str_replace('.', ' ', $appointment->user_id))); ?>
                <?php if (Auth::isAdmin()): ?>
                    </a>
                <?php endif ?>
            </td>
            <td><?= htmlspecialchars($appointment->resp_name); ?></td>
            <td><?= htmlspecialchars($appointment->status); ?></td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="5">No appointments available.</td>
    </tr>
<?php endif; ?>
                    </tbody>
                </table>
            </div>

            <h1>Upcoming</h1>
<div class="card card-custom-height">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Appointment Date</th>
                <th>Appointment Time</th>
                <th>Complainant</th>
                <th>Respondent</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (is_array($upcomingappointments) || is_object($upcomingappointments)): ?>
                <?php foreach ($upcomingappointments as $appointment): ?>
                    <tr>
                        <td><?= get_date($appointment->appt_date); ?></td>
                        <td><?= date('g:i A', strtotime($appointment->appt_time)); ?></td>
                        <td>
                            <?php
                            $compNameForLink = str_replace(' ', '.', $appointment->user_id);
                            ?>
                            <?php if (Auth::isAdmin()): ?>
                                <a href="<?= ROOT ?>/profile/<?= urlencode($compNameForLink) ?> #complainant" class="text-reset text-decoration-none">
                            <?php endif ?>
                            <?= htmlspecialchars(ucwords(str_replace('.', ' ', $appointment->user_id))); ?>
                            <?php if (Auth::isAdmin()): ?>
                                </a>
                            <?php endif ?>
                        </td>
                        <td><?= htmlspecialchars($appointment->resp_name); ?></td>
                        <td><?= htmlspecialchars($appointment->status); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No upcoming appointments available.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
        
<h1>Past</h1>
<div class="card card-custom-height">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Appointment Date</th>
                <th>Appointment Time</th>
                <th>Complainant</th>
                <th>Respondent</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (is_array($appointmentsforpast) || is_object($appointmentsforpast)): ?>
                <?php foreach ($appointmentsforpast as $appointment): ?>
                    <tr>
                        <td><?= get_date($appointment->appt_date); ?></td>
                        <td><?= date('g:i A', strtotime($appointment->appt_time)); ?></td>
                        <td>
                            <?php
                            $compNameForLink = str_replace(' ', '.', $appointment->user_id); 
                            ?>
                            <?php if (Auth::isAdmin()): ?>
                                <a href="<?= ROOT ?>/profile/<?= urlencode($compNameForLink) ?> #complainant" class="text-reset">
                            <?php endif ?>
                            <?= htmlspecialchars(ucwords(str_replace('.', ' ', $appointment->user_id))); ?>
                            <?php if (Auth::isAdmin()): ?>
                                </a>
                            <?php endif ?>
                        </td>
                        <td><?= htmlspecialchars($appointment->resp_name); ?></td>
                        <td><?= htmlspecialchars($appointment->status); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No past appointments available.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
        </div>
    </div>



<?php $this->view('includes/footer'); ?>