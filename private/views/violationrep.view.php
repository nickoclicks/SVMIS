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
</style>


<div class="dashboard-container mt-4">

<a href="sdcs" class="btn btn-secondary border" style="background-color: white; border: none; cursor: pointer; padding: 10px; font-size: 16px; color: black">Notice</a>
<a href="reports" class="btn btn-secondary border" style="background-color: white; border: none; cursor: pointer; padding: 10px; font-size: 16px; color: black">Violation</a>

<h1>Violation Report</h1>
<h2>Total Results: <?php echo count($recentViolators); ?></h2>

<button class="print-button" style="background-color: white;" onclick="printContent()">
    <i class="fas fa-print text-dark"><h4>Print</h4></i>
</button>


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

<?php
$statuses = array_column($recentViolators, 'status');
$statusCounts = array_count_values($statuses);
?>
<div class="row">
    <div class="col-md-6">
        <div class="card" style="padding: 20px; margin: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
            <div class="card-body">
                <h5 class="card-title">Total Resolved</h5>
                <p class="card-text"><?php echo $statusCounts['Resolved'] ?? 0; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow" style="padding: 20px; margin: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
            <div class="card-body">
                <h5 class="card-title">Total Unresolved</h5>
                <p class="card-text"><?php echo $statusCounts['Unresolved'] ?? 0; ?></p>
            </div>
        </div>
    </div>
    
</div>

<?php if (!empty($recentViolators)): ?>
                <table class="table table-bordered table-hovered table-striped" id="table">
        <thead style="background-color: black;">
            <tr>
                <th class="text-light">Student ID</th>
                <th class="text-light">Violation</th>
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
                    <td><?php echo htmlspecialchars($violator->violation); ?></td>
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


<div class="row">
    <div class="col-md-6">
        <canvas id="chart" width="400" height="200"></canvas>
    </div>
    <div class="col-md-6">
    <canvas id="year-level-chart" width="400" height="200"></canvas>
</div>
</div>


<script>
    const ctx = document.getElementById('chart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Resolved', 'Unresolved'],
        datasets: [{
            label: 'Violations',
            data: [<?php echo $statusCounts['Resolved'] ?? 0; ?>, <?php echo $statusCounts['Unresolved'] ?? 0; ?>],
            backgroundColor: [
                'linear-gradient(135deg, rgba(0, 255, 127, 0.7), rgba(0, 128, 0, 0.7))', // Gradient green
                'linear-gradient(135deg, rgba(255, 69, 58, 0.7), rgba(255, 0, 0, 0.7))'  // Gradient red
            ],
            borderColor: [
                'rgba(0, 128, 0, 1)',
                'rgba(255, 0, 0, 1)'
            ],
            borderWidth: 2,
            borderRadius: 10, // Larger rounded corners for a smoother look
            barPercentage: 0.5, // Slimmer bars for a modern feel
            hoverBackgroundColor: [
                'rgba(0, 255, 127, 0.9)', // Lighter hover effect for green
                'rgba(255, 69, 58, 0.9)'  // Lighter hover effect for red
            ],
            hoverBorderColor: [
                'rgba(0, 128, 0, 1)',
                'rgba(255, 0, 0, 1)'
            ],
            shadowOffsetX: 3,
            shadowOffsetY: 3,
            shadowBlur: 8,
            shadowColor: 'rgba(0, 0, 0, 0.2)' // Subtle shadow for 3D effect
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false, // Adjust for responsiveness
        scales: {
            x: {
                grid: {
                    display: false, // Cleaner look without grid lines
                },
                ticks: {
                    font: {
                        size: 16,
                        weight: 'bold',
                    },
                    color: '#444', // Darker text for modern aesthetics
                }
            },
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0, 0, 0, 0.05)', // Very light grid lines for minimalism
                    borderDash: [3, 3], // Shorter dashes for subtle effect
                },
                ticks: {
                    font: {
                        size: 16,
                        weight: 'bold',
                    },
                    color: '#444'
                }
            }
        },
        plugins: {
            tooltip: {
                enabled: true,
                backgroundColor: 'rgba(34, 34, 34, 0.8)', // Sleek dark tooltip background
                titleFont: { size: 16, weight: 'bold' },
                bodyFont: { size: 14 },
                bodyColor: '#fff',
                borderColor: '#444',
                borderWidth: 1,
                caretPadding: 10, // Padding for a polished look
                displayColors: false // Remove box color indicators for a cleaner tooltip
            },
            legend: {
                labels: {
                    font: {
                        size: 16,
                        weight: 'bold'
                    },
                    color: '#444',
                    padding: 20, // Adds space between legend items
                },
                position: 'top', // Legend at the top for a modern look
            },
        },
        animation: {
            duration: 2000, // Slower, smoother animation
            easing: 'easeOutBounce', // Stylish bounce animation for the bars
        },
        layout: {
            padding: {
                left: 30,
                right: 30,
                top: 30,
                bottom: 30, // More spacious padding around the chart
            }
        }
    }
});

</script>

<!-- Add a new canvas element for the year level chart -->

<script>
 const yearLevelCtx = document.getElementById('year-level-chart').getContext('2d');
const courseLabels = <?php echo json_encode($courseLabels); ?>;
const courseCounts = <?php echo json_encode($courseCounts); ?>;

const yearLevelChart = new Chart(yearLevelCtx, {
    type: 'bar',
    data: {
        labels: courseLabels,
        datasets: [{
            label: 'Violations per Course',
            data: courseCounts,
            backgroundColor: [
                '#3498db', // blue
                '#f1c40f', // yellow
                '#2ecc71', // green
                '#e74c3c', // red
                '#9b59b6', // purple
                '#1abc9c', // teal
                'pink'
            ],
            borderColor: [
                'rgba(0, 128, 0, 1)',
                'rgba(255, 0, 0, 1)'
            ],
            borderWidth: 2,
            borderRadius: 10, // Rounded corners for sleek bars
            barPercentage: 0.5, // Slimmer bars
            hoverBackgroundColor: [
                'rgba(0, 255, 127, 0.9)', // Lighter hover effect for green
                'rgba(255, 69, 58, 0.9)'  // Lighter hover effect for red
            ],
            hoverBorderColor: [
                'rgba(0, 128, 0, 1)',
                'rgba(255, 0, 0, 1)'
            ],
            shadowOffsetX: 3,
            shadowOffsetY: 3,
            shadowBlur: 8,
            shadowColor: 'rgba(0, 0, 0, 0.2)' // Subtle shadow for 3D effect
        }]
    },
    options: {
        plugins: {
            datalabels: {
                display: true,
                formatter: (value, context) => {
                    const percentage = (value / context.dataset.data.reduce((a, b) => a + b, 0)) * 100;
                    return `${percentage.toFixed(2)}%`;
                }
            }
        },
        responsive: true,
        maintainAspectRatio: false, // For better responsiveness
        scales: {
            x: {
                grid: {
                    display: false, // Cleaner look without grid lines
                },
                ticks: {
                    font: {
                        size: 16,
                        weight: 'bold',
                    },
                    color: '#444', // Darker labels for modern look
                }
            },
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0, 0, 0, 0.05)', // Light grid lines for minimalism
                    borderDash: [3, 3], // Subtle dashed grid lines
                },
                ticks: {
                    font: {
                        size: 16,
                        weight: 'bold',
                    },
                    color: '#444' // Darker ticks for better readability
                }
            }
        },
        plugins: {
            tooltip: {
                enabled: true,
                backgroundColor: 'rgba(34, 34, 34, 0.8)', // Sleek dark tooltip background
                titleFont: { size: 16, weight: 'bold' },
                bodyFont: { size: 14 },
                bodyColor: '#fff',
                borderColor: '#444',
                borderWidth: 1,
                caretPadding: 10, // Padding for a polished look
                displayColors: false // Remove color boxes for a clean tooltip
            },
            legend: {
                labels: {
                    font: {
                        size: 16,
                        weight: 'bold'
                    },
                    color: '#444',
                    padding: 20 // Adds spacing around the legend
                },
                position: 'top', // Legend at the top for modern design
            },
        },
        animation: {
            duration: 2000, // Smooth and slow animation
            easing: 'easeOutBounce', // Adds a bounce effect to the bars
        },
        layout: {
            padding: {
                left: 30,
                right: 30,
                top: 30,
                bottom: 30 // Spacious padding for a cleaner look
            }
        }
    }
});

</script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
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
    table = table.replace('<table', '<table border="1" cellpadding="5" cellspacing="0"');

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
            setTimeout(() => {
                windowOpen.print();
            }, 1000); // Add a 1-second delay before printing
        } else {
            console.error("Failed to open the print window. Please check your browser settings.");
        }
    });
}

</script>

<script>
  // Function to update the chart data and re-render the chart
// Function to update the charts data and re-render the charts
// Function to update the charts data and re-render the charts
function updateCharts() {
    // Get the filter values
    var studentId = document.getElementById('student_id').value;
    var yearLevel = document.getElementById('year_level').value;
    var course = document.getElementById('course').value;
    var startDate = document.getElementById('start_date').value;
    var endDate = document.getElementById('end_date').value;

    // Update the Violations chart data
    chart.data.labels = ['Resolved', 'Unresolved'];
    chart.data.datasets[0].data = [<?php echo $statusCounts['Resolved'] ?? 0; ?>, <?php echo $statusCounts['Unresolved'] ?? 0; ?>];
    chart.update();

    // Update the Violations per Course chart data
    var courseLabels = <?php echo json_encode($courseLabels); ?>;
    var courseCounts = <?php echo json_encode($courseCounts); ?>;
    yearLevelChart.data.labels = courseLabels;
    yearLevelChart.data.datasets[0].data = courseCounts;
    yearLevelChart.update();
}

// Call the updateCharts function whenever the filter changes
filterElement.addEventListener('change', updateCharts);

// Call the updateCharts function whenever the filter changes
filterElement.addEventListener('change', updateCharts);

// Call the updateChart function whenever the filter changes
filterElement.addEventListener('change', updateChart);
</script>




<?php $this->view('includes/footer'); ?>
