<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>


<div class="dashboard-container mt-4" style="background: linear-gradient(135deg, #ffffff, #f9f9f9); max-width: 1650px; margin: 40px auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">

<a href="reports" class="btn btn-secondary border" style="background-color: white; border: none; cursor: pointer; padding: 10px; font-size: 16px; color: black">Violation</a>
<a href="sdcs" class="btn btn-secondary border" style="background-color: white; border: none; cursor: pointer; padding: 10px; font-size: 16px; color: black">Notice</a>
<a href="goodmoral" class="btn btn-secondary border" style="background-color: white; border: none; cursor: pointer; padding: 10px; font-size: 16px; color: black">Good Moral Report</a>

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
            backgroundColor: [
                'rgba(75, 192, 192, 0.8)', 
                'rgba(54, 162, 235, 0.8)', 
                'rgba(255, 206, 86, 0.8)', 
                'rgba(255, 159, 64, 0.8)', 
                'rgba(153, 102, 255, 0.8)', 
                'rgba(255, 99, 132, 0.8)'
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 99, 132, 1)'
            ],
            borderWidth: 2,
            hoverBorderWidth: 3,
            hoverBackgroundColor: [
                'rgba(75, 192, 192, 1)', 
                'rgba(54, 162, 235, 1)', 
                'rgba(255, 206, 86, 1)', 
                'rgba(255, 159, 64, 1)', 
                'rgba(153, 102, 255, 1)', 
                'rgba(255, 99, 132, 1)'
            ]
        }]
    },
    options: {
        plugins: {
            title: {
                display: true,
                text: 'Print Activities Overview',
                font: {
                    size: 28,
                    weight: 'bold',
                    family: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
                },
                padding: {
                    top: 20,
                    bottom: 30
                },
                color: '#333',
            },
            legend: {
                display: true,
                position: 'top',
                labels: {
                    boxWidth: 20,
                    padding: 20,
                    font: {
                        size: 14
                    },
                    color: '#666',
                }
            },
            tooltip: {
                enabled: true,
                backgroundColor: 'rgba(0,0,0,0.7)',
                titleFont: {
                    size: 16
                },
                bodyFont: {
                    size: 14
                },
                padding: 10,
                borderColor: '#ccc',
                borderWidth: 1,
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Number of Activities',
                    font: {
                        size: 18,
                        weight: 'bold'
                    },
                    color: '#333'
                },
                grid: {
                    color: 'rgba(200, 200, 200, 0.3)',
                },
                ticks: {
                    color: '#333',
                    font: {
                        size: 14
                    }
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Activity Type',
                    font: {
                        size: 18,
                        weight: 'bold'
                    },
                    color: '#333'
                },
                grid: {
                    color: 'rgba(200, 200, 200, 0.3)',
                },
                ticks: {
                    color: '#333',
                    font: {
                        size: 14
                    }
                }
            }
        },
        animation: {
            duration: 1500,
            easing: 'easeOutBounce'
        },
        responsive: true,
        maintainAspectRatio: false
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
            backgroundColor: [
                'rgba(54, 162, 235, 0.8)', 
                'rgba(255, 99, 132, 0.8)', 
                'rgba(255, 206, 86, 0.8)', 
                'rgba(75, 192, 192, 0.8)', 
                'rgba(153, 102, 255, 0.8)', 
                'rgba(255, 159, 64, 0.8)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 2,
            hoverBorderWidth: 3,
            hoverBackgroundColor: [
                'rgba(54, 162, 235, 1)', 
                'rgba(255, 99, 132, 1)', 
                'rgba(255, 206, 86, 1)', 
                'rgba(75, 192, 192, 1)', 
                'rgba(153, 102, 255, 1)', 
                'rgba(255, 159, 64, 1)'
            ]
        }]
    },
    options: {
        plugins: {
            title: {
                display: true,
                text: 'Print Activities for Good Moral Certificate',
                font: {
                    size: 28,
                    weight: 'bold',
                    family: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
                },
                padding: {
                    top: 20,
                    bottom: 30
                },
                color: '#333',
            },
            legend: {
                display: true,
                position: 'top',
                labels: {
                    boxWidth: 20,
                    padding: 20,
                    font: {
                        size: 14
                    },
                    color: '#666',
                }
            },
            tooltip: {
                enabled: true,
                backgroundColor: 'rgba(0,0,0,0.7)',
                titleFont: {
                    size: 16
                },
                bodyFont: {
                    size: 14
                },
                padding: 10,
                borderColor: '#ccc',
                borderWidth: 1,
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Number of Activities',
                    font: {
                        size: 18,
                        weight: 'bold'
                    },
                    color: '#333'
                },
                grid: {
                    color: 'rgba(200, 200, 200, 0.3)',
                },
                ticks: {
                    color: '#333',
                    font: {
                        size: 14
                    }
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Activity Type',
                    font: {
                        size: 18,
                        weight: 'bold'
                    },
                    color: '#333'
                },
                grid: {
                    color: 'rgba(200, 200, 200, 0.3)',
                },
                ticks: {
                    color: '#333',
                    font: {
                        size: 14
                    }
                }
            }
        },
        animation: {
            duration: 1500,
            easing: 'easeOutBounce'
        },
        responsive: true,
        maintainAspectRatio: false
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
