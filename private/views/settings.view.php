<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

<div class="dashboard-container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-title">Settings</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Select School Year</h5>
                    <form method="POST" action="home">
                        <div class="form-group">
                            <label for="school_year_id">Select School Year:</label>
                            <select name="school_year_id" id="school_year_id" class="form-control">
                                <option value="all">All</option>
                                <option value="1">2024-2025</option>
                                <!-- Add more options as needed -->
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Apply Filter</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Comparative Analysis</h5>
                    <form method="POST" action="compare">
                        <div class="form-group">
                            <label for="school_year_id_1">Select First School Year:</label>
                            <select name="school_year_id_1" id="school_year_id_1" class="form-control">
                                <option value="all">All</option>
                                <option value="1">2024-2025</option>
                                <!-- Add more options as needed -->
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="school_year_id_2">Select Second School Year:</label>
                            <select name="school_year_id_2" id="school_year_id_2" class="form-control">
                                <option value="all">All</option>
                                <option value="1">2023-2024</option>
                                <!-- Add more options as needed -->
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Apply Filter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h2>Activity Logs</h2>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Activity Name</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($activityLogs as $log) { ?>
                        <tr>
                            <td><?= $log->activity_name; ?></td>
                            <td><?= get_date($log->date); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->view('includes/footer'); ?>