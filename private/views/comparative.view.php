<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>


<style>
    canvas {
        max-width: 600px;
        margin: auto;
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
    <div class="p-3 border rounded shadow-sm bg-light" style="margin: 10px;">
    <h5 class="text-center mb-3">Past Records</h5>
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
           
    </div>

    <div class="col-md-6">
    <div class="p-3 border rounded shadow-sm bg-light" style="margin: 10px;">
    <h5 class="text-center mb-3">Current Records</h5>
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
        <div class="card" style="margin: 10px;">
    <canvas id="status-chart" width="400" height="200"></canvas>
    </div>
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
<div class="card">
<canvas id="date-chart" width="400" height="200"></canvas>
</div>
    </div>
    <div class="col-md-6">
    <?php
$yearLevelpresent = array_column($recentViolators1, 'year_level');
$YearLevelPresentCounts = array_count_values($yearLevelpresent);
?>
<div class="card" style="margin: 10px;">
<canvas id="statuspresent-chart" width="400" height="200"></canvas>
</div>
    

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
    <div class="card">
    <canvas id="datepresent-chart" width="400" height="200"></canvas>
    </div>
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
                'linear-gradient(135deg, rgba(0, 255, 127, 0.7), rgba(0, 128, 0, 0.7))',  
                'linear-gradient(135deg, rgba(255, 69, 58, 0.7), rgba(255, 0, 0, 0.7))',   
                'linear-gradient(135deg, rgba(54, 162, 235, 0.7), rgba(0, 128, 255, 0.7))', 
                'linear-gradient(135deg, rgba(255, 206, 86, 0.7), rgba(255, 159, 64, 0.7))'
            ],
            borderColor: [
                'rgba(0, 128, 0, 1)',
                'rgba(255, 0, 0, 1)',
                'rgba(0, 128, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 2,
            borderRadius: 10,
            barPercentage: 0.5,
            hoverBackgroundColor: [
                'rgba(0, 255, 127, 0.9)', 
                'rgba(255, 69, 58, 0.9)',  
                'rgba(54, 162, 235, 0.9)', 
                'rgba(255, 206, 86, 0.9)'
            ],
            hoverBorderColor: [
                'rgba(0, 128, 0, 1)',
                'rgba(255, 0, 0, 1)',
                'rgba(0, 128, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            shadowOffsetX: 3,
            shadowOffsetY: 3,
            shadowBlur: 8,
            shadowColor: 'rgba(0, 0, 0, 0.2)'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: {
                grid: {
                    display: true, // Enable grid lines on the x-axis
                    color: 'rgba(0, 0, 0, 0.05)', // Light grid lines for a subtle effect
                    borderDash: [4, 4] // Dotted grid lines for a more appealing style
                },
                ticks: {
                    font: {
                        size: 18, // Increased font size for better readability
                        weight: 'bold'
                    },
                    color: '#444',
                    padding: 10,
                    maxRotation: 45,
                    minRotation: 0
                }
            },
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0, 0, 0, 0.1)', // Slightly darker lines on the y-axis for more visibility
                    borderDash: [5, 5], // Dashed lines to give a polished look
                },
                ticks: {
                    font: {
                        size: 18,
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
                caretPadding: 10,
                displayColors: false
            },
            legend: {
                labels: {
                    font: {
                        size: 16,
                        weight: 'bold'
                    },
                    color: '#444',
                    padding: 20
                },
                position: 'top'
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


const ctx1 = document.getElementById('date-chart').getContext('2d');
const chart1 = new Chart(ctx1, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($uniqueDayNamesViolation); ?>,
        datasets: [{
            label: 'Violation Status Counts',
            data: <?php echo json_encode($uniqueDayCountsViolation); ?>,
            fill: true, // Enable fill under the line for a more modern look
            backgroundColor: 'rgba(75, 192, 192, 0.2)', // Subtle fill color under the line
            borderColor: 'rgba(75, 192, 192, 1)', // Line color
            pointBackgroundColor: 'rgba(54, 162, 235, 1)', // Color for the data points
            pointBorderColor: '#fff', // White border around points for contrast
            pointHoverBackgroundColor: '#fff',
            pointHoverBorderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 3, // Thicker line for better visibility
            tension: 0.4, // Smooth curves between points
            pointRadius: 5, // Bigger points for better visibility
            pointHoverRadius: 7 // Larger hover effect for points
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: {
                grid: {
                    display: true,
                    color: 'rgba(0, 0, 0, 0.05)', // Light grid lines
                    borderDash: [4, 4] // Dotted grid lines on x-axis
                },
                ticks: {
                    font: {
                        size: 16, // Increased font size
                        weight: 'bold'
                    },
                    color: '#444',
                    padding: 10,
                    maxRotation: 45, // Prevent overlapping labels
                    minRotation: 0
                }
            },
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0, 0, 0, 0.1)', // Light dashed grid lines
                    borderDash: [5, 5],
                },
                ticks: {
                    font: {
                        size: 16,
                        weight: 'bold'
                    },
                    color: '#444'
                }
            }
        },
        plugins: {
            tooltip: {
                enabled: true,
                backgroundColor: 'rgba(34, 34, 34, 0.8)', // Dark tooltip background
                titleFont: { size: 16, weight: 'bold' }, // Enhanced tooltip font
                bodyFont: { size: 14 },
                bodyColor: '#fff', // White tooltip text for better contrast
                borderColor: '#444',
                borderWidth: 1,
                caretPadding: 10,
                displayColors: false
            },
            legend: {
                labels: {
                    font: {
                        size: 16,
                        weight: 'bold'
                    },
                    color: '#444',
                    padding: 20 // More space between legend items
                },
                position: 'top'
            }
        },
        animation: {
            duration: 2000,
            easing: 'easeOutBounce' // Bounce effect on load
        },
        layout: {
            padding: {
                left: 30,
                right: 30,
                top: 30,
                bottom: 30
            }
        },
        elements: {
            line: {
                tension: 0.4 // Smooth line curves
            },
            point: {
                radius: 5, // Make points more prominent
                hitRadius: 10,
                hoverRadius: 7
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
                'linear-gradient(135deg, rgba(255, 99, 132, 0.7), rgba(255, 69, 58, 0.7))',   // Gradient red
                'linear-gradient(135deg, rgba(54, 162, 235, 0.7), rgba(0, 128, 255, 0.7))',  // Gradient blue
                'linear-gradient(135deg, rgba(255, 206, 86, 0.7), rgba(255, 159, 64, 0.7))', // Gradient yellow
                'linear-gradient(135deg, rgba(75, 192, 192, 0.7), rgba(0, 206, 209, 0.7))',  // Gradient green/blue
                'linear-gradient(135deg, rgba(153, 102, 255, 0.7), rgba(128, 0, 255, 0.7))', // Gradient purple
                'linear-gradient(135deg, rgba(255, 159, 64, 0.7), rgba(255, 99, 132, 0.7))'  // Gradient orange/pink
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 2,
            borderRadius: 10,
            barPercentage: 0.5,
            hoverBackgroundColor: [
                'rgba(255, 99, 132, 0.9)', 
                'rgba(54, 162, 235, 0.9)',  
                'rgba(255, 206, 86, 0.9)', 
                'rgba(75, 192, 192, 0.9)',  
                'rgba(153, 102, 255, 0.9)', 
                'rgba(255, 159, 64, 0.9)'   
            ],
            hoverBorderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            shadowOffsetX: 3,
            shadowOffsetY: 3,
            shadowBlur: 8,
            shadowColor: 'rgba(0, 0, 0, 0.2)' // Subtle shadow for 3D effect
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: {
                grid: {
                    display: true, // Enable grid lines on the x-axis
                    color: 'rgba(0, 0, 0, 0.05)', // Light grid lines for a subtle effect
                    borderDash: [4, 4] // Dotted grid lines for a more appealing style
                },
                ticks: {
                    font: {
                        size: 18, // Increased font size for better readability
                        weight: 'bold'
                    },
                    color: '#444',
                    padding: 10,
                    maxRotation: 45,
                    minRotation: 0
                }
            },
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0, 0, 0, 0.1)', // Slightly darker lines on the y-axis for more visibility
                    borderDash: [5, 5], // Dashed lines to give a polished look
                },
                ticks: {
                    font: {
                        size: 16,
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
                caretPadding: 10,
                displayColors: false
            },
            legend: {
                labels: {
                    font: {
                        size: 16,
                        weight: 'bold'
                    },
                    color: '#444',
                    padding: 20
                },
                position: 'top'
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


        
const ctx3 = document.getElementById('datepresent-chart').getContext('2d');
const chart3 = new Chart(ctx3, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($uniqueDayNames); ?>,
        datasets: [{
            label: 'Violation Status Counts Per Day',
            data: <?php echo json_encode($uniqueDayCounts); ?>,
            fill: true, // Enable fill under the line for consistency
            backgroundColor: 'rgba(75, 192, 192, 0.2)', // Subtle fill color under the line
            borderColor: 'rgba(75, 192, 192, 1)', // Line color
            pointBackgroundColor: 'rgba(54, 162, 235, 1)', // Color for the data points
            pointBorderColor: '#fff', // White border around points for contrast
            pointHoverBackgroundColor: '#fff',
            pointHoverBorderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 3, // Thicker line for better visibility
            tension: 0.4, // Smooth curves between points
            pointRadius: 5, // Bigger points for better visibility
            pointHoverRadius: 7 // Larger hover effect for points
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: {
                grid: {
                    display: true,
                    color: 'rgba(0, 0, 0, 0.05)', // Light grid lines
                    borderDash: [4, 4] // Dotted grid lines on x-axis
                },
                ticks: {
                    font: {
                        size: 14, // Increased font size
                        weight: 'bold'
                    },
                    color: '#444',
                    padding: 10,
                    maxRotation: 45, // Prevent overlapping labels
                    minRotation: 0
                }
            },
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0, 0, 0, 0.1)', // Light dashed grid lines
                    borderDash: [5, 5],
                },
                ticks: {
                    font: {
                        size: 16,
                        weight: 'bold'
                    },
                    color: '#444'
                }
            }
        },
        plugins: {
            tooltip: {
                enabled: true,
                backgroundColor: 'rgba(34, 34, 34, 0.8)', // Dark tooltip background
                titleFont: { size: 16, weight: 'bold' }, // Enhanced tooltip font
                bodyFont: { size: 14 },
                bodyColor: '#fff', // White tooltip text for better contrast
                borderColor: '#444',
                borderWidth: 1,
                caretPadding: 10,
                displayColors: false
            },
            legend: {
                labels: {
                    font: {
                        size: 16,
                        weight: 'bold'
                    },
                    color: '#444',
                    padding: 20 // More space between legend items
                },
                position: 'top'
            }
        },
        animation: {
            duration: 2000,
            easing: 'easeOutBounce' // Bounce effect on load
        },
        layout: {
            padding: {
                left: 30,
                right: 30,
                top: 30,
                bottom: 30
            }
        },
        elements: {
            line: {
                tension: 0.4 // Smooth line curves
            },
            point: {
                radius: 5, // Make points more prominent
                hitRadius: 10,
                hoverRadius: 7
            }
        }
    }
});

    </script>

</div>
</div>


<?php $this->view('includes/footer'); ?>