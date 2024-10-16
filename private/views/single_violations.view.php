<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

<style>
  /* Card Styles */
.table-bordered th, .table-bordered td {
    border: 1px solid #dee2e6;
}

/* Tab Styles */
.nav-tabs .nav-link.active {
    color: #495057;
    background-color: #e9ecef;
    border-color: #dee2e6 #dee2e6 #fff;
}

/* Spacing and Alignment */
.mb-4 {
    margin-bottom: 1.5rem;
}

.text-center {
    text-align: center;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .container-fluid {
        padding-left: 1rem;
        padding-right: 1rem;
    }
}

.chart-container {
    width: 800px;
    height: 400px;
    margin: 40px auto;
    padding: 20px;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.chart-container canvas {
    width: 100%;
    height: 100%;
}

</style>
<div class="dashboard-container-fluid p-4 shadow mx-auto" style="max-width: 1700px;">

    <?php if ($row): ?>
        <div class="row mb-4">
            <div class="col-12">
                

                <table class="table table-hover table-striped table-bordered">
                    <tbody>
                        <tr>
                            <th>Violation Name:</th>
                            <td><?= htmlspecialchars($row->violation) ?></td>
                        </tr>
                        <tr>
                            <th>Created by:</th>
                            <td><?= htmlspecialchars($row->user->firstname) ?> <?= htmlspecialchars($row->user->lastname) ?></td>
                        </tr>
                        <tr>
                            <th>Date Created:</th>
                            <td><?= htmlspecialchars(get_date($row->user->date)) ?></td>
                        </tr>
                        <tr>
                            <th>Level:</th>
                            <td><?= htmlspecialchars($row->level) ?></td>
                        </tr>
                        <tr>
                            <th>Category:</th>
                            <td><?= htmlspecialchars($row->category) ?></td>
                        </tr>
                        <tr>
                            <th>Description:</th>
                            <td><?= nl2br(htmlspecialchars($row->description)) ?></td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>

        <hr class="my-4">

        <div class="row">
            <div class="col-md-6">
        <?php if ($violation_frequencies): ?>
    <div class="chart-container">
        <canvas id="violationChart" width="800" height="400"></canvas>
    </div>
            </div>
            <div class="col-md-6">
        <div class="chart-container">
        <canvas id="courseChart" width="800" height="400"></canvas>
    </div>
        </div>
        </div>

    <script>
  // Prepare data for Chart.js
var courseLabels = [];
var courseFrequencies = [];

<?php foreach ($course_frequencies as $frequency): ?>
    courseLabels.push('<?= htmlspecialchars($frequency->course) ?>');
    courseFrequencies.push(<?= $frequency->frequency ?>);
<?php endforeach; ?>

var ctxBar = document.getElementById('courseChart').getContext('2d');

// Create gradient for the bars
var gradient = ctxBar.createLinearGradient(0, 0, 0, 400);
gradient.addColorStop(0, 'rgba(78, 115, 223, 1)');  // Start color
gradient.addColorStop(1, 'rgba(78, 115, 223, 0.5)');  // End color

var barChart = new Chart(ctxBar, {
    type: 'bar',
    data: {
        labels: courseLabels,
        datasets: [{
            label: 'Number of Violations',
            data: courseFrequencies,
            backgroundColor: gradient, // Apply gradient to bars
            borderColor: '#4e73df', // Border color
            borderWidth: 3, // Thicker borders
            barPercentage: 0.7, // Slimmer bars
            borderRadius: 15, // Rounded corners
            hoverBackgroundColor: '#2e59d9', // Hover color
            hoverBorderColor: '#1d72b8', // Hover border color
            borderSkipped: false, // Ensure all borders appear
            shadowOffsetX: 4, // Shadow to give depth
            shadowOffsetY: 4,
            shadowBlur: 10,
            shadowColor: 'rgba(0, 0, 0, 0.15)'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        layout: {
            padding: {
                left: 30,
                right: 30,
                top: 30,
                bottom: 30
            }
        },
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Courses',
                    color: '#333', // Stylish color for the title
                    font: {
                        size: 18, // Increase font size
                        weight: 'bold',
                        family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif" // Professional font
                    }
                },
                grid: {
                    display: false // Hide grid lines for clarity
                },
                ticks: {
                    color: '#5a5c69', // Stylish X-axis ticks
                    font: {
                        size: 15
                    }
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'Number of Violations',
                    color: '#333',
                    font: {
                        size: 18,
                        weight: 'bold',
                        family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif"
                    }
                },
                grid: {
                    color: '#e5e5e5', // Subtle grid color
                    borderColor: '#dcdcdc', // Subtle border color
                    borderDash: [5, 5] // Dotted grid lines for elegance
                },
                ticks: {
                    color: '#5a5c69', // Stylish Y-axis ticks
                    font: {
                        size: 15
                    },
                    stepSize: 1 // Ensure better granularity
                }
            }
        },
        plugins: {
            legend: {
                display: true, // Show legend for clarity
                labels: {
                    color: '#333', // Legend color
                    font: {
                        size: 14,
                        weight: 'bold'
                    }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.7)', // Dark background for tooltip
                titleColor: '#ffffff', // White title
                bodyColor: '#ffffff', // White body text
                borderColor: '#ffffff', // Light border for tooltip
                borderWidth: 1,
                caretSize: 6, // Smaller caret for tooltip
                titleFont: {
                    size: 14,
                    weight: 'bold'
                },
                bodyFont: {
                    size: 13
                },
                padding: 12, // Add padding for a more spacious look
                displayColors: false, // Disable dataset color display in tooltips
                callbacks: {
                    title: function(tooltipItem) {
                        return 'Course: ' + tooltipItem[0].label; // Add custom label for the course
                    },
                    label: function(tooltipItem) {
                        return 'Violations: ' + tooltipItem.raw; // Customize label for clarity
                    }
                }
            }
        },
        animation: {
            duration: 1500, // Smooth and slow animations for rendering
            easing : 'easeInOutQuart' // Easing function for smooth animations
        }
    }
});
    </script>
    
        
    
    <script>
       // Prepare data for Chart.js
var labels = [];
var frequencies = [];

<?php foreach ($violation_frequencies as $frequency): ?>
    labels.push('<?= $frequency->date ?>');
    frequencies.push(<?= $frequency->frequency ?>);
<?php endforeach; ?>

var ctx = document.getElementById('violationChart').getContext('2d');

// Create gradient for the line chart background
var gradientLine = ctx.createLinearGradient(0, 0, 0, 400);
gradientLine.addColorStop(0, 'rgba(78, 115, 223, 0.2)'); // Start color
gradientLine.addColorStop(1, 'rgba(78, 115, 223, 0)'); // End color

var violationChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Frequency of Violation: <?= htmlspecialchars($row->violation) ?>',
            data: frequencies,
            borderColor: '#4e73df', // Primary line color
            backgroundColor: gradientLine, // Gradient background color under the line
            borderWidth: 3, // Thicker line for better visibility
            fill: true,
            tension: 0.4, // Smooth curves
            pointBorderColor: '#4e73df', // Border color for points
            pointBackgroundColor: '#ffffff', // White background for points
            pointBorderWidth: 3, // Thicker point border
            pointRadius: 6, // Slightly larger points
            pointHoverRadius: 8, // Larger points on hover
            pointHoverBackgroundColor: '#4e73df', // Background color on hover
            pointHoverBorderColor: '#fff' // Border color on hover
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        layout: {
            padding: {
                left: 30,
                right: 30,
                top: 30,
                bottom: 30
            }
        },
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Date',
                    color: '#5a5c69', // Stylish color for title
                    font: {
                        size: 16, // Increased font size
                        weight: 'bold' // Bold for emphasis
                    }
                },
                grid: {
                    color: '#e6e6e6', // Subtle grid color
                    borderColor: '#d1d3e2' // Lighter border for X-axis
                },
                ticks: {
                    color: '#5a5c69', // Stylish X-axis ticks
                    font: {
                        size: 14 // Font size for ticks
                    }
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'Number of Violations',
                    color: '#5a5c69', // Stylish color for title
                    font: {
                        size: 16, // Increased font size
                        weight: 'bold' // Bold for emphasis
                    }
                },
                grid: {
                    color: '#e6e6e6', // Subtle grid color
                    borderColor: '#d1d3e2' // Lighter border for Y-axis
                },
                ticks: {
                    color: '#5a5c69', // Stylish Y-axis ticks
                    font: {
                        size: 14 // Font size for ticks
                    }
                }
            }
        },
        plugins: {
            legend: {
                display: false // Hide legend for cleaner look
            },
            tooltip: {
                backgroundColor: 'rgba(255, 255, 255, 0.8)', // Slightly transparent background
                titleColor: '#333', // Darker title for contrast
                bodyColor: '#5a5c69', // Body text color
                borderColor: '#d1d3e2', // Light border for tooltip
                borderWidth: 1,
                caretSize: 8, // Larger caret for tooltip
                titleFont: {
                    size: 14, // Font size for title
                    weight: 'bold'
                },
                bodyFont: {
                    size: 12 // Font size for body
                },
                padding: 12 // Add padding for a more spacious look
            }
        }
    }
});
    </script>
<?php else: ?>
    <h4 class="text-center">No violation frequency found!</h4>
<?php endif; ?>

        

    <?php else: ?>
        <h4 class="text-center">That violation's details were not found!</h4>
    <?php endif; ?>
</div>

<?php $this->view('includes/footer'); ?>
