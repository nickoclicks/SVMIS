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
</style>

<div class="dashboard-container mt-4" style="background: linear-gradient(135deg, #ffffff, #f9f9f9); max-width: 1650px; margin: 40px auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">

<a href="reports" class="btn btn-secondary border" style="background-color: white; border: none; cursor: pointer; padding: 10px; font-size: 16px; color: black">Violation</a>
<a href="sdcs" class="btn btn-secondary border" style="background-color: white; border: none; cursor: pointer; padding: 10px; font-size: 16px; color: black">Notice</a>
<a href="goodmoral" class="btn btn-secondary border" style="background-color: white; border: none; cursor: pointer; padding: 10px; font-size: 16px; color: black">Certificate Report</a>
<a href="comparative" class="btn btn-secondary border" style="background-color: white; border: none; cursor: pointer; padding: 10px; font-size: 16px; color: black">Comparative Analysis</a>

<h1>Certificate Report</h1>

<button onclick="printGraphs()" class="btn btn-secondary border" style="margin-bottom: 20px; background-color: white; border: none; cursor: pointer; padding: 10px; font-size: 16px; color: black">Print Graphs</button>

<div id="graphs-container">
<div class="row">
<select id="timePeriod" onchange="updateGraph()">
    <option value="day">Per Day</option>
    <option value="month">Per Month</option>
    <option value="year">Per Year</option>
</select>
        <div class="col-md-6">
            <canvas id="chartPrintActivities1"></canvas>
        </div>
        <div class="col-md-6">
            <canvas id="chartPrintActivities"></canvas>
        </div>
    </div>
</div>
    <script>
        const ctxPrintActivities1 = document.getElementById('chartPrintActivities1').getContext('2d');
const chartPrintActivities1 = new Chart(ctxPrintActivities1, {
    type: 'line',
    data: {
        labels: <?= json_encode($printActivityLabels1) ?>,
        datasets: [{
            label: 'Print Activities For Violation Slip',
            data: <?= json_encode($printActivityCounts1) ?>,
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

 

const ctxPrintActivities = document.getElementById('chartPrintActivities').getContext('2d');
const chartPrintActivities = new Chart(ctxPrintActivities, {
    type: 'line',
    data: {
        labels: <?= json_encode($printActivityLabels) ?>,
        datasets: [{
            label: 'Print Activities For Good Moral Certificate',
            data: <?= json_encode($printActivityCounts) ?>,
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

    // Convert the charts to images
    var chartsHtml = '';
    var chartsPromises = [];
    
    charts.forEach(chart => {
        // Use toDataURL to get the image of the chart
        var chartImage = chart.toDataURL();
        chartsHtml += `<img src="${chartImage}" style="width: 100%; height: auto; margin: 10px;">`;
    });

    // Wrap the charts in a container to display them side by side
    var chartsContainer = `
        <div style="display: flex; flex-direction: column; align-items: center;">
            ${chartsHtml}
        </div>
    `;

    var printHtml = header + chartsContainer;

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
}
    </script>

<?php $this->view('includes/footer'); ?>
