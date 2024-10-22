<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>


<style>
    canvas {
        max-width: 600px;
        margin: auto;
    }
</style>
</head>
<body>

<div class="dashboard-container mt-4" style="background: linear-gradient(135deg, #ffffff, #f9f9f9); max-width: 1650px; margin: 40px auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">

<a href="reports" class="btn btn-secondary border" style="background-color: white; border: none; cursor: pointer; padding: 10px; font-size: 16px; color: black">Violation</a>
<a href="sdcs" class="btn btn-secondary border" style="background-color: white; border: none; cursor: pointer; padding: 10px; font-size: 16px; color: black">Notice</a>
<a href="goodmoral" class="btn btn-secondary border" style="background-color: white; border: none; cursor: pointer; padding: 10px; font-size: 16px; color: black">Good Moral Report</a>
<a href="comparative" class="btn btn-secondary border" style="background-color: white; border: none; cursor: pointer; padding: 10px; font-size: 16px; color: black">Comparative Analysis</a>


<?php
// Assuming this code is at the top of your page where you handle form submissions
$filters = [
    'start_date' => isset($_GET['start_date']) ? $_GET['start_date'] : '',
    'end_date' => isset($_GET['end_date']) ? $_GET['end_date'] : ''
];

$filters1 = [
    'start_date_1' => isset($_GET['start_date_1']) ? $_GET['start_date_1'] : '',
    'end_date_1' => isset($_GET['end_date_1']) ? $_GET['end_date_1'] : ''
];
?>

<div class="row">
    <div class="col-md-6">
    <form method="GET" action="">
            <div class="row mb-3">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
        <div class="col-md-6">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" id="start_date" name="start_date" class="form-control" value="<?php echo $filters['start_date']; ?>">
        </div>
        <div class="col-md-6">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" id="end_date" name="end_date" class="form-control" value="<?php echo $filters['end_date']; ?>">
        </div>

            </div>
           
    </div>

    <div class="col-md-6">
    
            <div class="row mb-3">
            
        <div class="col-md-6">
            <label for="start_date_1" class="form-label">Start Date</label>
            <input type="date" id="start_date_1" name="start_date_1" class="form-control" value="<?php echo $filters1['start_date_1']; ?>">
        </div>
        <div class="col-md-6">
            <label for="end_date_1" class="form-label">End Date</label>
            <input type="date" id="end_date_1" name="end_date_1" class="form-control" value="<?php echo $filters1['end_date_1']; ?>">
        </div>

            </div>
    </div>
            <center><button type="submit" class="btn btn-secondary" style="width: 10%; color: white; font-weight: 600">Apply Filters</button></center>
        </form>
   
</div>

        <div class="row">         <!-- Display count of each status -->
<?php
$yearLevel = array_column($recentViolators, 'year_level');
$YearLevelCounts = array_count_values($yearLevel);
?>
    <div class="col-md-6">
    <canvas id="status-chart" width="400" height="200"></canvas>
    <?php
    $dateofViolation = array_column($recentViolators, 'date');
    $DateofViolationCounts = array_count_values($dateofViolation);
    
    // Convert dates to day names
    $dayNamesViolation = [];
    foreach ($dateofViolation as $date) {
        $dayNamesViolation[] = date('l', strtotime($date)); // 'l' returns full textual representation of the day
    }
    $DayViolationCounts = array_count_values($dayNamesViolation);
    $uniqueDayNamesViolation = array_keys($DayViolationCounts);
    $uniqueDayCountsViolation = array_values($DayViolationCounts);?>

<canvas id="date-chart" width="400" height="200"></canvas>
    </div>
    <div class="col-md-6">
    <?php
$yearLevelpresent = array_column($recentViolators1, 'year_level');
$YearLevelPresentCounts = array_count_values($yearLevelpresent);
?>
    <canvas id="statuspresent-chart" width="400" height="200"></canvas>

    <?php
    $datepresent = array_column($recentViolators1, 'date');
    $DatePresentCounts = array_count_values($datepresent);
    
    // Convert dates to day names
    $dayNames = [];
    foreach ($datepresent as $date) {
        $dayNames[] = date('l', strtotime($date)); // 'l' returns full textual representation of the day
    }
    $DayPresentCounts = array_count_values($dayNames);
    $uniqueDayNames = array_keys($DayPresentCounts);
    $uniqueDayCounts = array_values($DayPresentCounts);?>
    <canvas id="datepresent-chart" width="400" height="200"></canvas>
    </div>
</div>
<!-- Add a canvas for the chart -->

<div class="row">
    <div class="col-md-6">
        <?php if (!empty($recentViolators)): ?>
            <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped" id="table" hidden>
                <thead style="background-color: black;">
                    <tr>
                        <th class="text-light">Student ID</th>
                        <th class="text-light">Violation</th>
                        <th class="text-light">Date</th>
                        <th class="text-light">First Name</th>
                        <th class="text-light">Last Name</th>
                        <th class="text-light">Year Level</th>
                        <th class="text-light">Semester</th>
                        <th class="text-light">Status</th>
                        <th class="text-light">School Year</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentViolators as $archivesModel): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($archivesModel->user_id); ?></td>
                            <td><?php echo htmlspecialchars($archivesModel->violation); ?></td>
                            <td><?php echo htmlspecialchars(get_date($archivesModel->date)); ?></td>
                            <td><?php echo htmlspecialchars($archivesModel->firstname); ?></td>
                            <td><?php echo htmlspecialchars($archivesModel->lastname); ?></td>
                            <td><?php echo htmlspecialchars($archivesModel->year_level); ?></td>
                            <td><?php echo htmlspecialchars($archivesModel->semester_name); ?></td>
                            <td><?php echo htmlspecialchars($archivesModel->status); ?></td>
                            <td><?php echo htmlspecialchars($archivesModel->school_year); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No records found.</p>
        <?php endif; ?>
    </div>
</div>

    <div class="col-md-6">
    <?php if (!empty($recentViolators1)): ?>
            <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped" id="table" hidden>
                <thead style="background-color: black;">
                    <tr>
                        <th class="text-light">Student ID</th>
                        <th class="text-light">Complaint</th>
                        <th class="text-light">Date</th>
                        <th class="text-light">First Name</th>
                        <th class="text-light">Last Name</th>
                        <th class="text-light">Year Level</th>
                        <th class="text-light">Semester</th>
                        <th class="text-light">Status</th>
                        <th class="text-light">School Year</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentViolators1 as $violator): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($violator->user_id); ?></td>
                            <td><?php echo htmlspecialchars($violator->violation); ?></td>
                            <td><?php echo htmlspecialchars(get_date($violator->date)); ?></td>
                            <td><?php echo htmlspecialchars($violator->firstname); ?></td>
                            <td><?php echo htmlspecialchars($violator->lastname); ?></td>
                            <td><?php echo htmlspecialchars($violator->year_level); ?></td>
                            <td><?php echo htmlspecialchars($violator->semester_name); ?></td>
                            <td><?php echo htmlspecialchars($violator->status); ?></td>
                            <td><?php echo htmlspecialchars($violator->school_year); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No records found.</p>
        <?php endif; ?>
    </div>
    </div>
</div>
</div>


    
    <!-- Use Chart.js to render the bar chart -->
   
    <script>
        const ctx = document.getElementById('status-chart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_keys($YearLevelCounts)); ?>,
                datasets: [{
                    label: 'Violation Status Counts',
                    data: <?php echo json_encode(array_values($YearLevelCounts)); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const ctx1 = document.getElementById('date-chart').getContext('2d');
const chart1 = new Chart(ctx1, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($uniqueDayNamesViolation); ?>,
        datasets: [{
            label: 'Violation Status Counts',
            data: <?php echo json_encode($uniqueDayCountsViolation); ?>,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

        const ctx2 = document.getElementById('statuspresent-chart').getContext('2d');
        const chart2 = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_keys($YearLevelPresentCounts)); ?>,
                datasets: [{
                    label: 'Violation Status Counts',
                    data: <?php echo json_encode(array_values($YearLevelPresentCounts)); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        
        const ctx3 = document.getElementById('datepresent-chart').getContext('2d');
const chart3 = new Chart(ctx3, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($uniqueDayNames); ?>,
        datasets: [{
            label: 'Violation Status Counts',
            data: <?php echo json_encode($uniqueDayCounts); ?>,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
    </script>

</div>
</div>


<?php $this->view('includes/footer'); ?>