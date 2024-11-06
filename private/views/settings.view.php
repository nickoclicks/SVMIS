<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

<div class="dashboard-container" style="margin-left: -150px">
    <center>
        <div class="row">
            <h1>Notice Appointment Notification</h1>
        </div>
    </center>

    <div class="row">
        <div class="col-md-12">
          

        <h1>Today</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Appointment Date</th>
                        <th>Appointment Time</th>
                        <th>Complainant</th>
                        <th>Respondent</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $appointment) { ?>
                        <tr>
                            <td><?= get_date($appointment->appt_date); ?></td>
                            <td><?= date('g:i A', strtotime($appointment->appt_time)) ?></td>
                            <td>
                            <?php
                                $compNameForLink = str_replace(' ', '.', $appointment->user_id); 
                                ?>
                               <?php if (Auth::isAdmin()): ?>
                                <a href="<?= ROOT ?>/profile/<?= urlencode($compNameForLink) ?> #complainant" class="text-reset text-decoration-none">
                                <?php endif ?>
                            <?= htmlspecialchars($appointment->user_id); ?></td>
                                </a>
                            <td><?= htmlspecialchars($appointment->resp_name); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <h1>Past</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Appointment Date</th>
                        <th>Appointment Time</th>
                        <th>Complainant</th>
                        <th>Respondent</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointmentsforpast as $appointment) { ?>
                        <tr>
                            <td><?= get_date($appointment->appt_date); ?></td>
                            <td><?= date('g:i A', strtotime($appointment->appt_time)) ?></td>
                            <td>
                            <?php
                                $compNameForLink = str_replace(' ', '.', $appointment->user_id); 
                                ?>
                               <?php if (Auth::isAdmin()): ?>
                                <a href="<?= ROOT ?>/profile/<?= urlencode($compNameForLink) ?> #complainant" class="text-reset text-decoration-none">
                                <?php endif ?>
                            <?= htmlspecialchars($appointment->user_id); ?></td>
                                </a>
                            <td><?= htmlspecialchars($appointment->resp_name); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <h1>Upcoming</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Appointment Date</th>
                        <th>Appointment Time</th>
                        <th>Complainant</th>
                        <th>Respondent</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($upcomingappointments as $appointment) { ?>
                        <tr>
                            <td><?= get_date($appointment->appt_date); ?></td>
                            <td><?= date('g:i A', strtotime($appointment->appt_time)) ?></td>
                            <td>
                            <?php
                                $compNameForLink = str_replace(' ', '.', $appointment->user_id); 
                                ?>
                               <?php if (Auth::isAdmin()): ?>
                                <a href="<?= ROOT ?>/profile/<?= urlencode($compNameForLink) ?> #complainant" class="text-reset text-decoration-none">
                                <?php endif ?>
                            <?= htmlspecialchars($appointment->user_id); ?></td>
                                </a>
                            <td><?= htmlspecialchars($appointment->resp_name); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>



<?php $this->view('includes/footer'); ?>