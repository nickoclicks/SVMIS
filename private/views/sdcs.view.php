<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>


<style>
/* Global Styles */

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: 'Open Sans', sans-serif;
    font-size: 16px;
    line-height: 1.5;
    color: #333;
    background-color: #f9f9f9;
}

h1, h2, h3, h4, h5, h6 {
    font-weight: bold;
    color: #333;
}

h1 {
    font-size: 36px;
    margin-bottom: 20px;
}

h2 {
    font-size: 24px;
    margin-bottom: 15px;
}

h3 {
    font-size: 18px;
    margin-bottom: 10px;
}

h4 {
    font-size: 16px;
    margin-bottom: 5px;
}

h5 {
    font-size: 14px;
    margin-bottom: 5px;
}

h6 {
    font-size: 12px;
    margin-bottom: 5px;
}

/* Dashboard Container */

.dashboard-container {
    max-width: 1650px;
    margin: 40px auto;
    padding: 20px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

/* Card Styles */

.card {
   
    padding: 20px;
    margin: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.card:hover {
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
    transform: translateY(-5px);
}

.card-body {
    font-family: 'Open Sans', sans-serif;
}

.card-title {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
}

.card-text {
    font-size: 14px;
    color: #666;
    margin-bottom: 20px;
}

/* Table Styles */

table {
    border-collapse: collapse;
    width: 100%;
    margin-bottom: 20px;
}

table th, table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}



/* Print Header Styles */

.print-header {
    text-align: center;
    margin-bottom: 20px;
}

.print-header img {
    width: 100px;
    height: 95px;
    margin-right: 10px;
    float: left;
}

.print-header h4 {
    margin-bottom: -20px;
}

.print-header hr {
    margin-top: 0;
}

/* No Print Styles */

.no-print {
    display: none;
}

/* Responsive Design */

@media (max-width: 768px) {
    .dashboard-container {
        margin: 20px;
    }
}

@media (max-width: 480px) {
    .dashboard-container {
        margin: 10px;
    }
    .card {
        margin: 10px;
    }
}

.print-button {
    position: absolute;
    top: 60px;
    right: 45px;
    background-color: #4CAF50;
    color: #fff;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 10%;
}

.print-button:hover {
    background-color: #3e8e41;
}

.print-button i {
    margin-right: 5px;
}

.violation-button {
    position: absolute;
    top: 60px;
    right: 45px;
    background-color: #4CAF50;
    color: #fff;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 10%;
    transition: background-color 0.3s ease;
    z-index: 1000;
}

.print-button {
    position: absolute;
    top: 60px;
    right: 45px;
    background-color: #4CAF50;
    color: #fff;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 10%;
    transition: background-color 0.3s ease;
    z-index: 1001;
}
.card {
    background: linear-gradient(135deg, #ffffff, #f9f9f9);
    padding: 20px;
    margin: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.btn {
    background-color: #007bff; /* Primary color */
    color: white;
    border: none;
    border-radius: 5px;
    padding: 12px 24px; /* Increased padding for a more substantial look */
    font-size: 16px; /* Increased font size for better readability */
    font-weight: 600; /* Bold font for emphasis */
    text-transform: uppercase; /* Uppercase text for a modern touch */
    letter-spacing: 1px; /* Spacing between letters for a cleaner look */
    transition: background-color 0.3s, transform 0.2s, box-shadow 0.3s; /* Smooth transitions */
    cursor: pointer;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
}

.btn:hover {
    background-color: #0056b3; /* Darker shade on hover */
    transform: translateY(-2px); /* Lift effect on hover */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); /* Enhanced shadow on hover */
}

.btn:active {
    transform: translateY(1px); /* Pressed effect */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Reduced shadow when pressed */
}

/* Additional styles for specific button types */
.btn-secondary {
    background-color: #6c757d; /* Secondary color */
}

.btn-secondary:hover {
    background-color: #5a6268; /* Darker shade for secondary button on hover */
}

</style>



<div class="dashboard-container mt-4" style="background: linear-gradient(135deg, #ffffff, #f9f9f9); max-width: 1650px; margin: 40px auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">

<a href="reports" class="btn btn-secondary border" style="background-color: white; border: none; cursor: pointer; padding: 10px; font-size: 16px; color: black">Violation</a>
<a href="sdcs" class="btn btn-secondary border" style="background-color: white; border: none; cursor: pointer; padding: 10px; font-size: 16px; color: black">Notice</a>
<a href="goodmoral" class="btn btn-secondary border" style="background-color: white; border: none; cursor: pointer; padding: 10px; font-size: 16px; color: black">Good Moral Report</a>
<a href="comparative" class="btn btn-secondary border" style="background-color: white; border: none; cursor: pointer; padding: 10px; font-size: 16px; color: black">Comparative Analysis</a>


<h1>Notice Report</h1>

        <h2>Total Results: <?php echo count($recentViolators); ?></h2>

        <button class="print-button" style="background-color: white;" onclick="printContent()">
    <i class="fas fa-print text-dark"><h4>Print</h4></i>
</button>


        <!-- Filter Form -->
        <form method="GET" action="">
            <div class="row mb-3" style="margin-left: 220px;">
            <div class="col-md-2">
            <label for="student_id" class="form-label">Student ID</label>
            <input type="text" id="student_id" name="student_id" class="form-control" value="<?php echo htmlspecialchars($filters['student_id'] ?? ''); ?>">
        </div>
                <div class="col-md-2">
                    <label for="year_level_id" class="form-label">Year Level</label>
                    <select id="year_level_id" name="year_level_id" class="form-select">
                        <option value="">All</option>
                        <!-- Add your year levels here -->
                        <option value="1st" <?php echo $filters['year_level_id'] == '1st' ? 'selected' : ''; ?>>1st Year</option>
                        <option value="2nd" <?php echo $filters['year_level_id'] == '2nd' ? 'selected' : ''; ?>>2nd Year</option>
                        <option value="3rd" <?php echo $filters['year_level_id'] == '3rd' ? 'selected' : ''; ?>>3rd Year</option>
                        <option value="4th" <?php echo $filters['year_level_id'] == '4th' ? 'selected' : ''; ?>>4th Year</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="course" class="form-label">Course</label>
                    <select id="course" name="course" class="form-select">
                        <option value="">All</option>
                        <option value="BSBA" <?php echo $filters['course'] == 'BSBA' ? 'selected' : ''; ?>>BSBA</option>
                        <option value="BSIT" <?php echo $filters['course'] == 'BSIT' ? 'selected' : ''; ?>>BSIT</option>
                        <option value="TEP" <?php echo $filters['course'] == 'TEP' ? 'selected' : ''; ?>>TEP</option>
                    </select>
                </div>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
        <div class="col-md-2">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" id="start_date" name="start_date" class="form-control" value="<?php echo $filters['start_date']; ?>">
        </div>
        <div class="col-md-2">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" id="end_date" name="end_date" class="form-control" value="<?php echo $filters['end_date']; ?>">
        </div>

            </div>
            <center><button type="submit" class="btn btn-secondary" style="width: 10%; color: white; font-weight: 600">Apply Filters</button></center>
        </form>

        <!-- Display count of each status -->
<?php
$statuses = array_column($recentViolators, 'status');
$statusCounts = array_count_values($statuses);
?>

<div class="row">
    <div class="col-md-4">
        <div class="card" style="padding: 20px; margin: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
            <div class="card-body">
                <h5 class="card-title">Total Resolved</h5>
                <p class="card-text"><?php echo $statusCounts['Solved'] ?? 0; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow" style="padding: 20px; margin: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
            <div class="card-body">
                <h5 class="card-title">Total Unresolved</h5>
                <p class="card-text"><?php echo $statusCounts['Unresolved'] ?? 0; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card" style="padding: 20px; margin: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
            <div class="card-body">
                <h5 class="card-title">Total Referred to SDC</h5>
                <p class="card-text"><?php echo $statusCounts['Referred to SDC'] ?? 0; ?></p>
            </div>
        </div>
    </div>
</div>
<div class="row">
        <!-- Display count of each course -->
<!-- Display count of each course -->
<?php
$courses = array_column($recentViolators, 'course');
$courseCounts = array_count_values($courses);
?>

<div class="card col-md-5" style="background-color: white; margin-left: 80px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); ">
    <div class="card-body">
        <h5 class="card-title"><i class="fas fa-chart-pie"></i> Course Counts</h5>
        <p class="card-text">This graph shows the distribution of notices across different courses.</p>
        <ul style="list-style: none; padding: 0; margin: 0;">
    <?php foreach ($courseCounts as $course => $count): ?>
        <li style="display: inline; margin-right: 15px;"><?php echo $course . ': ' . $count; ?></li>
    <?php endforeach; ?>
</ul>

        <!-- Add a canvas element for the graph -->
        <canvas id="course-count-graph" style="width: 300px; height: 300px; background-color: white"></canvas>
    </div>
</div>

<?php
$yearLevels = array_column($recentViolators, 'year_level_id');
$yearLevelCounts = array_count_values($yearLevels);
?>

<div class="card col-md-5" style=" background-color: white; padding: 20px; margin-left: 80px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
    <div class="card-body">
        <h5 class="card-title"><i class="fas fa-chart-pie"></i> Year Level Counts</h5>
        <p class="card-text">This graph shows the distribution of notice across different year levels.</p>
        <ul style="list-style: none; padding: 0; margin: 0;">
    <?php foreach ($yearLevelCounts as $yearLevel => $count): ?>
        <li style="display: inline; margin-right: 15px;"><?php echo $yearLevel . ': ' . $count; ?></li>
    <?php endforeach; ?>
</ul>

        <!-- Add a canvas element for the graph -->
        <canvas id="year-level-count-graph" style=" background-color: white"></canvas>
    </div>
</div>
</div>

        <!-- Display Tables -->
        <div class="mt-4">
            <!--<h2>Total Violations: <?php echo $totalViolations; ?></h2>
            <h2>Total Violators: <?php echo $totalViolators; ?></h2>
            <h2>Total Notices: <?php echo $totalNotices; ?></h2>

            <!-- Recent Violators Table -->
            
            <?php if (!empty($recentViolators)): ?>
                <table class="table table-bordered table-hovered table-striped" id="table">
        <thead style="background-color: black;">
            <tr>
                <th class="text-light">Student ID</th>
                <th class="text-light">Complaint</th>
                <th class="text-light">Date</th>
                <th class="text-light">First Name</th>
                <th class="text-light">Middle Name</th>
                <th class="text-light">Last Name</th>
                <th class="text-light">Course</th>
                <th class="text-light">Year Level</th>
                <th class="text-light">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recentViolators as $violator): ?>
                <tr>
                    <td><?php echo htmlspecialchars($violator->std_id); ?></td>
                    <td><?php echo htmlspecialchars($violator->complaint); ?></td>
                    <td><?php echo htmlspecialchars(get_date($violator->date)); ?></td>
                    <td><?php echo htmlspecialchars($violator->firstname); ?></td>
                    <td><?php echo htmlspecialchars($violator->middlename); ?></td>
                    <td><?php echo htmlspecialchars($violator->lastname); ?></td>
                    <td><?php echo htmlspecialchars($violator->course); ?></td>
                    <td><?php echo htmlspecialchars($violator->year_level_id); ?></td>
                    <td><?php echo htmlspecialchars($violator->status); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No records found.</p>
<?php endif; ?>

    </div>

   
    <!-- Printable Section -->
    


    




       

<!-- Add the JavaScript code to create the graph -->
<script>
   const ctx = document.getElementById('course-count-graph').getContext('2d');
const courseLabels = <?php echo json_encode(array_keys($courseCounts)); ?>;
const courseCounts = <?php echo json_encode(array_values($courseCounts)); ?>;

new Chart(ctx, {
    type: 'pie',
    data: {
        labels: courseLabels,
        datasets: [{
            label: 'Course Counts',
            data: courseCounts,
            backgroundColor: [
               
    '#3498db', // blue
    '#f1c40f', // yellow
    '#2ecc71', // green
    '#e74c3c', // red
    '#9b59b6', // purple
    '#1abc9c' // teal
            ],
            borderColor: [
                '#3498db', '#f1c40f', '#2ecc71', '#e74c3c', '#9b59b6', '#1abc9c'
            ],
            borderWidth: 2,
            hoverOffset: 20, // Makes the segment "pop out" on hover
            hoverBackgroundColor: [
                'rgba(52, 152, 219, 0.9)',
                'rgba(241, 196, 15, 0.9)',
                'rgba(46, 204, 113, 0.9)',
                'rgba(231, 76, 60, 0.9)',
                'rgba(155, 89, 182, 0.9)',
                'rgba(26, 188, 156, 0.9)'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            tooltip: {
                enabled: true,
                backgroundColor: 'rgba(34, 34, 34, 0.8)',
                titleFont: { size: 16, weight: 'bold' },
                bodyFont: { size: 14 },
                bodyColor: '#fff',
                borderColor: '#444',
                borderWidth: 1,
                displayColors: false
            },
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    font: {
                        size: 14,
                        weight: 'bold'
                    },
                    boxWidth: 20,
                    boxHeight: 20,
                    padding: 15
                },
                align: 'center',
                direction: 'row'
            }
        },
        animation: {
            duration: 2000,
            easing: 'easeOutBounce'
        },
        layout: {
            padding: {
                left: 30,
                right: 30,
                top: 30,
                bottom: 30
            }
        }
    }
});

</script>

<!-- Display count of each year level -->


<!-- Add the JavaScript code to create the graph -->
<script>
    const ctx3 = document.getElementById('year-level-count-graph').getContext('2d');
const yearLevelLabels = <?php echo json_encode(array_keys($yearLevelCounts)); ?>;
const yearLevelCounts = <?php echo json_encode(array_values($yearLevelCounts)); ?>;

new Chart(ctx3, {
    type: 'bar',
    data: {
        labels: yearLevelLabels,
        datasets: [{
            label: 'Year Level Counts',
            data: yearLevelCounts,
            backgroundColor: [
                'linear-gradient(135deg, rgba(52, 152, 219, 0.7), rgba(41, 128, 185, 0.7))',
                'linear-gradient(135deg, rgba(241, 196, 15, 0.7), rgba(243, 156, 18, 0.7))',
                'linear-gradient(135deg, rgba(46, 204, 113, 0.7), rgba(39, 174, 96, 0.7))',
                'linear-gradient(135deg, rgba(231, 76, 60, 0.7), rgba(192, 57, 43, 0.7))',
                'linear-gradient(135deg, rgba(155, 89, 182, 0.7), rgba(142, 68, 173, 0.7))',
                'linear-gradient(135deg, rgba(26, 188, 156, 0.7), rgba(22, 160, 133, 0.7))'
            ],
            borderColor: [
                '#3498db', '#f1c40f', '#2ecc71', '#e74c3c', '#9b59b6', '#1abc9c'
            ],
            borderWidth: 2,
            hoverBackgroundColor: [
                'rgba(52, 152, 219, 0.9)',
                'rgba(241, 196, 15, 0.9)',
                'rgba(46, 204, 113, 0.9)',
                'rgba(231, 76, 60, 0.9)',
                'rgba(155, 89, 182, 0.9)',
                'rgba(26, 188, 156, 0.9)'
            ],
            borderRadius: 10, // Rounded corners for bars
            barPercentage: 0.6 // Slimmer bars for a clean look
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: {
                grid: {
                    display: false
                },
                ticks: {
                    font: {
                        size: 14,
                        weight: 'bold'
                    },
                    color: '#444'
                }
            },
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0, 0, 0, 0.05)',
                    borderDash: [3, 3]
                },
                ticks: {
                    font: {
                        size: 14,
                        weight: 'bold'
                    },
                    color: '#444'
                }
            }
        },
        plugins: {
            tooltip: {
                enabled: true,
                backgroundColor: 'rgba(34, 34, 34, 0.8)',
                titleFont: { size: 16, weight: 'bold' },
                bodyFont: { size: 14 },
                bodyColor: '#fff',
                borderColor: '#444',
                borderWidth: 1,
                displayColors: false
            },
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    font: {
                        size: 14,
                        weight: 'bold'
                    },
                    boxWidth: 20,
                    boxHeight: 20,
                    padding: 15
                }
            }
        },
        animation: {
            duration: 2000,
            easing: 'easeOutBounce'
        },
        layout: {
            padding: {
                left: 30,
                right: 30,
                top: 30,
                bottom: 30
            }
        }
    }
});

</script>    

<script>
    function printContent() {
    // Hide no-print elements
    document.querySelectorAll('.no-print').forEach(el => el.style.display = 'none');

    // Get the table to print
    var printContent = document.querySelector('.table.table-bordered.table-hovered.table-striped');

    // Get the cards to print
    var cards = document.querySelectorAll('.card');

    // Get the charts to print
    var charts = document.querySelectorAll('.card-body canvas');

    // Create a new header for the print
    var header = `
        <div style="text-align: center; margin-bottom: 0;">
            <img src="assets/nbsc1.png" alt="University Logo" style="width: 100px; height: 95px; margin-right: 10px; float: left;">
            <img src="assets/nbsc1.png" alt="University Logo" style="width: 100px; height: 95px; margin-right: 10px; float: right;">
            <h4 style="margin-bottom: -20px;">Republic of the Philippines</h4>
            <h4 style="margin-bottom: -20px;"><b>NORTHERN BUKIDNON STATE COLLEGE</b></h4>
            <h4 style="margin-bottom: -20px;"><i>(Formerly Northern Bukidnon Community College)</i> R.A.11284</h4>
            <h4 style="margin-bottom: -5px;"><i>Creando futura, Transformationis vitae, Ductae a Deo</i></h4> 
            <hr>
        </div>
    `;

    // Create a new table with border
    var table = printContent.outerHTML;
    table = table.replace('<table', '<table border="1" cellpadding="5" cellspacing="0"','<th class="text-light">', '<th style="color: white;">');

    // Convert the cards to HTML
    var cardsHtml = '';
    var cardCount = 0;
    cards.forEach(card => {
        if (cardCount < 3) {
            cardsHtml += card.outerHTML;
            cardCount++;
        }
    });

    // Wrap the cards in a container to display them side by side
    var cardsContainer = `
        <div style="display: flex; justify-content: space-around;">
            ${cardsHtml}
        </div>
    `;

    // Convert the charts to images
    var chartsHtml = '';
    var chartsPromises = [];
    charts.forEach(chart => {
        chartsPromises.push(
            html2canvas(chart).then(canvas => {
                chartsHtml += `<img src="${canvas.toDataURL()}" style="width: 100%; height: auto;">`;
            }).catch(err => {
                console.error('Error capturing chart:', err); // Log any errors
            })
        );
    });

    // Wait for all chart images to be generated, then proceed to print
    Promise.all(chartsPromises).then(() => {
        // Wrap the charts in a container to display them side by side
        var chartsContainer = `
            <div style="display: flex; justify-content: space-around;">
                ${chartsHtml}
            </div>
        `;

        var printHtml = header + cardsContainer + chartsContainer + table;

        var windowUrl = 'about:blank';
        var windowName = 'Print';
        var windowFeatures = 'width=800,height=600,left=100,top=100';
        var windowOpen = window.open(windowUrl, windowName, windowFeatures);

        if (windowOpen) { // Check if windowOpen is not null
            windowOpen.document.write(printHtml);
            windowOpen.document.close();
            windowOpen.focus();
            windowOpen.print();
        } else {
            console.error("Failed to open the print window. Please check your browser settings.");
        }
    });
}

</script>

<?php $this->view('includes/footer'); ?>
