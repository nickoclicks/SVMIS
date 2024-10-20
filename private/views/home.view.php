<?php 
// Include the necessary headers and navigation
$this->view('includes/header'); 
$this->view('includes/navigation'); 
?>

<style> 


.dashboard-container {
  background: linear-gradient(135deg, rgba(240, 240, 240, 0.5), rgba(250, 250, 250, 0.5));
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease;
}

.stat-card {
  background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(245, 245, 245, 0.9));
  border-radius: 10px;
  padding: 20px;
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15); /* Increase shadow for more depth */
  color: #333; /* Ensure text is readable against the background */
  transition: transform 0.3s ease;
}

.stat-card:hover {
  transform: translateY(-5px); /* Slight lift on hover for interactivity */
}
</style>
<!-- Dashboard Container -->

<?php 
// Include the necessary headers and navigation
$this->view('includes/header'); 
$this->view('includes/navigation'); 

?>


<div class="dashboard-container">

 <!-- Stats Section -->
  <div class="stat-row">
    <div class="stat-card">
      <div class="icon"><i class="fas fa-exclamation-triangle"></i></div>
      <h5>Total Number of Rules</h5>
      <p><?= $totalViolations ?></p>
    </div>
    <div class="stat-card">
    <div class="icon"><i class="fas fa-user"></i></div>
    <h5>Total Violators</h5>
    <p><?= $totalViolators ?></p>
</div>
    <div class="stat-card">
      <div class="icon"><i class="fas fa-user-check"></i></div>
      <h5>Referred to SDC</h5>
      <p><?= $totalSdcs ?></p>
    </div>
    <div class="stat-card">
      <div class="icon"><i class="fas fa-file-alt"></i></div>
      <h5>Notices</h5>
      <p><?= $totalNotices ?></p>
    </div>
  </div>

  <script>
document.getElementById('toggle-analysis').addEventListener('click', function() {
    var analysisSection = document.getElementById('comparative-analysis');
    if (analysisSection.style.display === 'none') {
        analysisSection.style.display = 'block';
        this.textContent = 'Hide Comparative Analysis'; // Change button text
    } else {
        analysisSection.style.display = 'none';
        this.textContent = 'Show Comparative Analysis'; // Change button text
    }
});
</script>

  <!-- Charts Section -->
  <div class="chart-row">
    <div class="chart-wrapper">
      
      <h6><i class="fas fa-chart-pie"></i> Violations Distribution</h6>
      <canvas id="pieChart"></canvas>
      
    </div>


  <div class="col-md-9">
  <div class="chart-wrapper">
    <h6><i class="fas fa-chart-line"></i> Violators Trend</h6>
    <canvas id="violatorsChart"></canvas>
    <div class="chart-options">
      <select id="time-period">
        <option value="week" selected>This Week</option>
        <option value="day">Per Day</option>
        <option value="month">This Month</option>
        <option value="year">This Year</option>
      </select>
    </div>
    </div>
  </div>
  </div>

  <div class="chart-row">
    <div class="chart-wrapper">
      
      <h6><i class="fas fa-chart-bar"></i> Violations by Department</h6>
      <canvas id="barChart"></canvas>
    </div>
    <div class="chart-wrapper">
      <h6><i class="fas fa-chart-bar"></i> Violation Status Distribution</h6>
      <canvas id="statusChart"></canvas>
    </div>
  </div>

<!-- Chart.js Script for Charts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Pass violators data from PHP to JavaScript
  var chartLabels = <?= json_encode($chartLabels) ?>;
var chartData = <?= json_encode($chartData) ?>;
var pieLabels = <?= json_encode($pieLabels) ?>;
var pieData = <?= json_encode($pieData) ?>;


var ctxLine = document.getElementById('violatorsChart').getContext('2d');

// Create gradient for the line chart background
var gradientLine = ctxLine.createLinearGradient(0, 0, 0, 400);
gradientLine.addColorStop(0, 'rgba(78, 115, 223, 0.2)'); // Start color
gradientLine.addColorStop(1, 'rgba(78, 115, 223, 0)'); // End color

var violatorsChart = new Chart(ctxLine, {
  type: 'line',
  data: {
    labels: <?= json_encode($chartLabels) ?>,
    datasets: [{
      label: 'Number of Violators',
      data: <?= json_encode($chartData) ?>,
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
          text: 'Number of Violators',
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
        padding: 12, // Extra padding for tooltip
        callbacks: {
          label: function(tooltipItem) {
            return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
          }
        }
      }
    },
    animation: {
      duration: 1500, // Smooth animation
      easing: 'easeOutCubic' // Smooth easing for animation
    }
  }
});


// Event listener for the time period dropdown
document.getElementById('time-period').addEventListener('change', function() {
  var selectedTimePeriod = this.value;
  var chartData = [];
  var chartLabels = [];

  // Update chart data based on the selected time period
  if (selectedTimePeriod === 'week') {
    chartData = <?= json_encode($chartDataWeek) ?>;
    chartLabels = <?= json_encode($chartLabelsWeek) ?>;
  } else if (selectedTimePeriod === 'month') {
    chartData = <?= json_encode($chartDataMonth) ?>;
    chartLabels = <?= json_encode($chartLabelsMonth) ?>;
  }
  else if (selectedTimePeriod === 'year') {
    chartData = <?= json_encode($chartDataYear) ?>;
    chartLabels = <?= json_encode($chartLabelsYear) ?>;
  }else if (selectedTimePeriod === 'day') {
    chartData = <?= json_encode($chartDataDay) ?>;
    chartLabels = <?= json_encode($chartLabelsDay) ?>;
  }

  // Update the chart with the new data
  violatorsChart.data.labels = chartLabels;
  violatorsChart.data.datasets[0].data = chartData;
  violatorsChart.update();

  
});


  // Pass bar chart data from PHP to JavaScript
  var barChartLabels = <?= json_encode($barChartLabels) ?>;
var barChartData = <?= json_encode($barChartData) ?>;

var ctxBar = document.getElementById('barChart').getContext('2d');

// Create gradient for the bars
var gradient = ctxBar.createLinearGradient(0, 0, 0, 400);
gradient.addColorStop(0, 'rgba(78, 115, 223, 1)');  // Start color
gradient.addColorStop(1, 'rgba(78, 115, 223, 0.5)');  // End color

var barChart = new Chart(ctxBar, {
  type: 'bar',
  data: {
    labels: barChartLabels,
    datasets: [{
      label: 'Number of Violations',
      data: barChartData,
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
          text: 'Students',
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
            return 'Student: ' + tooltipItem[0].label; // Add custom label for the student
          },
          label: function(tooltipItem) {
            return 'Violations: ' + tooltipItem.raw; // Customize label for clarity
          }
        }
      }
    },
    animation: {
      duration: 1500, // Smooth and slow animations for rendering
      easing: 'easeOutBounce' // Use bounce effect for a top-tier feel
    }
  }
});


var statusLabels = <?= json_encode($statusLabels) ?>;
var statusData = <?= json_encode($statusData) ?>;

var ctxStatus = document.getElementById('statusChart').getContext('2d');

// Create gradient for the bars
var gradientStatus = ctxStatus.createLinearGradient(0, 0, 0, 400);
gradientStatus.addColorStop(0, 'rgba(28, 200, 138, 1)'); // Start color (green)
gradientStatus.addColorStop(1, 'rgba(28, 200, 138, 0.5)'); // End color (lighter green)

var statusChart = new Chart(ctxStatus, {
  type: 'bar',
  data: {
    labels: statusLabels,
    datasets: [{
      label: 'Number of Violations by Status',
      data: statusData,
      backgroundColor: gradientStatus, // Apply gradient to bars
      borderColor: '#1cc88a', // Border color
      borderWidth: 3, // Thicker borders
      barPercentage: 0.7, // Slightly narrower bars
      borderRadius: 15, // Rounded corners for bars
      hoverBackgroundColor: '#17a673', // Hover color
      hoverBorderColor: '#148a5f', // Hover border color
      borderSkipped: false, // Ensure all borders appear
      shadowOffsetX: 4, // Add shadow for depth
      shadowOffsetY: 4,
      shadowBlur: 10,
      shadowColor: 'rgba(0, 0, 0, 0.15)' // Shadow color
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
          text: 'Status',
          color: '#333', // Stylish color for the title
          font: {
            size: 18, // Increased font size
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
          color: '#333', // Stylish color for the title
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
          stepSize: 1 // Step size for Y-axis ticks
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
            return 'Status: ' + tooltipItem[0].label; // Custom label for the status
          },
          label: function(tooltipItem) {
            return 'Violations: ' + tooltipItem.raw; // Customize label for clarity
          }
        }
      }
    },
    animation: {
      duration: 1500, // Smooth and slow animations for rendering
      easing: 'easeOutBounce' // Use bounce effect for a top-tier feel
    }
  }
});


var ctxPie = document.getElementById('pieChart').getContext('2d');

// Define vibrant colors for the chart
var colors = [
  'rgba(28, 200, 138, 0.9)', // Green
  'rgba(54, 185, 204, 0.9)', // Blue
  'rgba(246, 194, 62, 0.9)', // Yellow
  'rgba(231, 74, 59, 0.9)'   // Red
];

var hoverColors = [
  'rgba(28, 200, 138, 1)',
  'rgba(54, 185, 204, 1)',
  'rgba(246, 194, 62, 1)',
  'rgba(231, 74, 59, 1)'
];

// Calculate total percentage
var totalValue = pieData.reduce((acc, val) => acc + val, 0);
var totalPercentage = 100; // Since we're displaying the entire chart

var pieChart = new Chart(ctxPie, {
  type: 'pie',
  data: {
    labels: pieLabels,
    datasets: [{
      data: pieData,
      backgroundColor: colors,
      hoverBackgroundColor: hoverColors,
      borderWidth: 2, // Thicker border to make it pop
      borderColor: '#fff' // White border for separation between slices
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        position: 'top', // Keep legend on top for better layout
        labels: {
          color: '#5a5c69', // Text color
          font: {
            size: 14, // Font size
            weight: 'bold' // Bold for readability
          }
        }
      },
      tooltip: {
        backgroundColor: 'rgba(255, 255, 255, 0.9)', // Light tooltip background
        titleColor: '#333', // Darker title
        bodyColor: '#666', // Subtle body color
        borderColor: '#ddd', // Light border
        borderWidth: 1,
        caretSize: 6, // Caret size for clarity
        padding: 12, // Padding for better tooltip spacing
        callbacks: {
          label: function(tooltipItem) {
            var percentage = (tooltipItem.raw / totalValue * 100).toFixed(2);
            return `${tooltipItem.label}: ${percentage}%`;
          }
        }
      }
    },
    cutout: '60%', // Larger hole for a modern look
    elements: {
      arc: {
        borderWidth: 0, // Cleaner look by default
        hoverBorderWidth: 2, // Slight border on hover for emphasis
        hoverBorderColor: '#fff', // White hover border for slice contrast
        shadowOffsetX: 0,
        shadowOffsetY: 0,
        shadowBlur: 12, // Soft shadow for a 3D effect
        shadowColor: 'rgba(0, 0, 0, 0.15)' // Light shadow color
      }
    },
    animation: {
      animateScale: true, // Scale animation for smooth entry
      animateRotate: true // Rotation animation for smooth transition
    }
  },
  plugins: []
});


</script>

<?php 
// Include the footer
$this->view('includes/footer'); 
?>
