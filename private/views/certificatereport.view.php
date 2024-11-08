<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

<style>
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
    transition: background-color 0.3s;
}

.print-button:hover {
    background-color: #3e8e41;
}

.print-button i {
    margin-right: 5px;
}
h4 {
    font-size: 16px;
    margin-bottom: 5px;
}

</style>

<div style="margin-left: -150px;">
<div class="dashboard-container p-4 mx-auto" style="max-width: 1700px; margin-top: -10px">

<center style="margin-bottom: 20px;">
    <a href="reports" class="btn btn-secondary border" style="background-color: white; border: none; cursor: pointer; padding: 10px; font-size: 16px; color: black; width: 270px;">Violation</a>
    <a href="sdcs" class="btn btn-secondary border" style="background-color: white; border: none; cursor: pointer; padding: 10px; font-size: 16px; color: black; width: 270px">Complaints</a>
    <a href="goodmoral" class="btn btn-secondary border" style="background-color: #007bff; border: none; cursor: pointer; padding: 10px; font-size: 16px; color: white; width: 270px">Certificate Report</a>
    <a href="comparative" class="btn btn-secondary border" style="background-color: white; border: none; cursor: pointer; padding: 10px; font-size: 16px; color: black; width: 270px">Comparative Analysis</a>
</center>
<center><h2 style="font-size: 18px;">Certificate Report</h2></center>

<button class="print-button" style="background-color: white;" onclick="printGraphs()">
    <i class="fas fa-print text-dark"><h4>Print</h4></i>
</button>

<?php
// Assuming this code is at the top of your page where you handle form submissions
$filters = [
    'start_date' => isset($_GET['start_date']) ? $_GET['start_date'] : '',
    'end_date' => isset($_GET['end_date']) ? $_GET['end_date'] : ''
];
?>

<div class="p-3  rounded shadow-sm" style="margin: 10px;">
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
            <center><button type="submit" class="btn btn-secondary" style="width: 10%; color: white; font-weight: 600; margin-bottom: 10px">Apply Filters</button></center>
        </form>

<div id="graphs-container">
<div class="row">
<?php
$datepresent = array_column($recentActivity, 'date');
    $DatePresentCounts = array_count_values($datepresent);

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
</div>
</div>



<div class="row">
    <div class="col-md-6">
        <?php if (!empty($recentActivity)): ?>
            <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped" id="table" hidden>
                <thead style="background-color: black;">
                    <tr>
                        <th class="text-light">Activity Name</th>
                        <th class="text-light">Date</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentActivity as $activity): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($activity->log_name); ?></td>
                            <td><?php echo htmlspecialchars($activity->date); ?></td>
                            
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No records found.</p>
        <?php endif; ?>
    </div>
</div>
    <script>
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
    <script>
    function printGraphs() {
        // Hide no-print elements
        document.querySelectorAll('.no-print').forEach(el => el.style.display = 'none');

        // Get the charts to print
        var charts = document.querySelectorAll('#graphs-container canvas');

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

        // Prepare to convert the charts to images
        var chartsHtml = '';
        var chartsPromises = [];

        charts.forEach(chart => {
            chartsPromises.push(new Promise((resolve) => {
                // Use toDataURL to get the image of the chart
                var chartImage = chart.toDataURL();
                chartsHtml += `<img src="${chartImage}" style="width: 100%; height: auto; margin: 10px;">`;
                resolve();
            }));
        });

        // Wait for all charts to be converted to images
        Promise.all(chartsPromises).then(() => {
            // Wrap the charts in a container
            var chartsContainer = `
                <div style="display: flex; flex-direction: column; align-items: center;">
                    ${chartsHtml}
                </div>
            `;

            var printHtml = header + chartsContainer;

            // Create a new window for printing
            var printWindow = window.open('', 'Print', 'width=800,height=600,left=100,top=100');
            if (printWindow) {
                printWindow.document.write(printHtml);
                printWindow.document.close();
                printWindow.focus();

                // Wait for the new window to load before printing
                printWindow.onload = function() {
                    printWindow.print();
                    printWindow.close(); // Close the print window after printing
                };
            } else {
                console.error("Failed to open the print window. Please check your browser settings.");
            }
        });
    }
</script>

<?php $this->view('includes/footer'); ?>
