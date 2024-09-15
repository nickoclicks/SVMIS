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
      <h5>Total Violations</h5>
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
      <p><?= $totalUserViolations ?></p>
    </div>
    
    <div class="stat-card">
    <div class="icon"><i class="fas fa-file-alt"></i></div>
      <h5>Notices</h5>
      <p><?= $totalNotices ?></p>
    </div>
  </div>

  <!-- Charts Section -->
  <div class="chart-row">
    <div class="chart-wrapper">
      <h6><i class="fas fa-chart-line"></i> Violators Trend</h6>
      <canvas id="violatorsChart"></canvas>
    </div>
    
    <div class="chart-wrapper">
      <h6><i class="fas fa-chart-pie"></i> Violations Distribution</h6>
      <canvas id="pieChart"></canvas>
    </div>
  </div>

  <div class="chart-row">
  <div class="chart-wrapper">
  <h6><i class="fas fa-chart-bar"></i>Violations by Course</h6>
  <canvas id="barChart"></canvas>
</div>


<div class="chart-wrapper">
  <h6><i class="fas fa-chart-bar"></i> Violation Status Distribution</h6>
  <canvas id="statusChart"></canvas>
</div>
</div>
  <!-- Tables Row: Recently Added Violations & Violators -->
  <div class="table-row">
  <div class="table-wrapper">
    <h6><i class="fas fa-list-alt"></i> Recently Added Violations</h6>
    <table class="table table-hover">
      <thead>
        <tr>
          <th class="table-dark">Violation</th>
          <th class="table-dark">Date</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($recentViolations): ?>
          <?php foreach ($recentViolations as $violation): ?>
            <tr>
              <td><?= $violation->violation ?></td>
              <td><?= get_date($violation->date) ?></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="2">No recent violations found.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
  
  <div class="table-wrapper">
    <h6><i class="fas fa-users"></i> Recently Added Violators</h6>
    <table class="table table-hover">
      <thead>
        <tr>
          <th class="table-dark">Name</th>
          <th class="table-dark">Date</th>
          <th class="table-dark">Course</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($recentViolators): ?>
          <?php foreach ($recentViolators as $violator): ?>
            <tr>
              <td><?= $violator->firstname . ' ' . $violator->lastname ?></td>
              <td><?= get_date($violator->date) ?></td>
              <td><?= $violator->course ?></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="3">No recent violators found.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
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
var violatorsChart = new Chart(ctxLine, {
  type: 'line',
  data: {
    labels: chartLabels,
    datasets: [{
      label: 'Number of Violators',
      data: chartData,
      borderColor: '#4e73df', // Primary color for the line
      backgroundColor: 'rgba(78, 115, 223, 0.1)', // Light background color under the line
      borderWidth: 3, // Thicker border for better visibility
      fill: true,
      tension: 0.4, // Smooth curves
      pointBorderColor: '#4e73df', // Border color for points
      pointBackgroundColor: '#ffffff', // Background color for points
      pointBorderWidth: 2, // Border width for points
      pointRadius: 5, // Radius of the points
      pointHoverRadius: 7 // Radius of the points on hover
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 20,
        right: 20,
        top: 20,
        bottom: 20
      }
    },
    scales: {
      x: {
        title: {
          display: true,
          text: 'Date',
          color: '#5a5c69', // Title color
          font: {
            size: 14, // Font size for the title
            weight: 'bold' // Font weight for the title
          }
        },
        grid: {
          color: '#e0e0e0', // Light grid color
          borderColor: '#d1d3e2' // Border color for X-axis
        },
        ticks: {
          color: '#6e6e6e', // X-axis ticks color
          font: {
            size: 12 // Font size for X-axis ticks
          }
        }
      },
      y: {
        title: {
          display: true,
          text: 'Number of Violators',
          color: '#5a5c69', // Title color
          font: {
            size: 14, // Font size for the title
            weight: 'bold' // Font weight for the title
          }
        },
        grid: {
          color: '#e0e0e0', // Light grid color
          borderColor: '#d1d3e2' // Border color for Y-axis
        },
        ticks: {
          color: '#6e6e6e', // Y-axis ticks color
          font: {
            size: 12 // Font size for Y-axis ticks
          }
        }
      }
    },
    plugins: {
      legend: {
        display: false // Hide the legend if not needed
      },
      tooltip: {
        backgroundColor: '#ffffff', // Background color for tooltip
        titleColor: '#333', // Title color for tooltip
        bodyColor: '#666', // Body color for tooltip
        borderColor: '#ddd', // Border color for tooltip
        borderWidth: 2, // Border width for tooltip
        caretSize: 8, // Size of the tooltip caret
        titleFont: {
          size: 14, // Title font size
          weight: 'bold' // Title font weight
        },
        bodyFont: {
          size: 12 // Body font size
        },
        callbacks: {
          label: function(tooltipItem) {
            return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
          }
        }
      }
    }
  }
});


  // Pass bar chart data from PHP to JavaScript
  var barChartLabels = <?= json_encode($barChartLabels) ?>;
var barChartData = <?= json_encode($barChartData) ?>;

var ctxBar = document.getElementById('barChart').getContext('2d');
var barChart = new Chart(ctxBar, {
  type: 'bar',
  data: {
    labels: barChartLabels,
    datasets: [{
      label: 'Number of Violations',
      data: barChartData,
      backgroundColor: '#4e73df', // Primary color
      borderColor: '#2e59d9', // Darker shade for borders
      borderWidth: 2, // Slightly thicker borders
      barPercentage: 0.8,
      borderRadius: 10, // More rounded corners for bars
      hoverBackgroundColor: '#2e59d9', // Hover color
      hoverBorderColor: '#1d72b8', // Hover border color
      borderSkipped: 'bottom' // Skips border at the bottom for a smoother look
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 20,
        right: 20,
        top: 20,
        bottom: 20
      }
    },
    scales: {
      x: {
        title: {
          display: true,
          text: 'Students',
          color: '#4e73df', // Primary color for title
          font: {
            size: 16, // Larger title font size
            weight: 'bold' // Bold title font weight
          }
        },
        grid: {
          display: false // Remove grid lines for a cleaner look
        },
        ticks: {
          color: '#6e6e6e', // Darker color for X-axis ticks
          font: {
            size: 14 // Larger font size for X-axis ticks
          }
        }
      },
      y: {
        title: {
          display: true,
          text: 'Number of Violations',
          color: '#4e73df', // Primary color for title
          font: {
            size: 16, // Larger title font size
            weight: 'bold' // Bold title font weight
          }
        },
        grid: {
          color: '#e0e0e0', // Light grid color for better contrast
          borderColor: '#d1d3e2', // Light border color for Y-axis
          borderWidth: 1
        },
        ticks: {
          color: '#6e6e6e', // Darker color for Y-axis ticks
          font: {
            size: 14 // Larger font size for Y-axis ticks
          },
          stepSize: 1 // Step size for Y-axis ticks
        }
      }
    },
    plugins: {
      legend: {
        display: false // Hide legend if not needed
      },
      tooltip: {
        backgroundColor: '#ffffff', // Background color for tooltip
        titleColor: '#333', // Dark title color for tooltip
        bodyColor: '#666', // Dark body color for tooltip
        borderColor: '#ddd', // Light border color for tooltip
        borderWidth: 2, // Slightly thicker border
        caretSize: 8, // Larger size of the tooltip caret
        titleFont: {
          size: 14, // Larger title font size
          weight: 'bold' // Bold title font weight
        },
        bodyFont: {
          size: 12 // Font size for tooltip body
        },
        callbacks: {
          label: function(tooltipItem) {
            return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
          }
        }
      }
    }
  }
});


var statusLabels = <?= json_encode($statusLabels) ?>;
var statusData = <?= json_encode($statusData) ?>;

var ctxStatus = document.getElementById('statusChart').getContext('2d');
var statusChart = new Chart(ctxStatus, {
  type: 'bar',
  data: {
    labels: statusLabels,
    datasets: [{
      label: 'Number of Violations by Status',
      data: statusData,
      backgroundColor: [
        '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'
      ],
      borderColor: '#ffffff',
      borderWidth: 2, // Slightly thicker borders for better contrast
      barPercentage: 0.7, // Slightly narrower bars
      borderRadius: 10, // Rounded corners for bars
      hoverBackgroundColor: '#17a673', // Hover color
      hoverBorderColor: '#148a5f' // Hover border color
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 15,
        right: 15,
        top: 15,
        bottom: 15
      }
    },
    scales: {
      x: {
        title: {
          display: true,
          text: 'Status',
          color: '#343a40', // Darker color for better visibility
          font: {
            size: 16, // Increased font size for better readability
            weight: 'bold' // Bold title for emphasis
          }
        },
        grid: {
          display: false // Remove grid lines for a cleaner look
        },
        ticks: {
          color: '#495057', // Darker color for X-axis ticks
          font: {
            size: 14 // Increased font size for ticks
          }
        }
      },
      y: {
        title: {
          display: true,
          text: 'Number of Violations',
          color: '#343a40', // Darker color for better visibility
          font: {
            size: 16, // Increased font size for better readability
            weight: 'bold' // Bold title for emphasis
          }
        },
        grid: {
          color: '#e0e0e0', // Light grid color for subtle separation
          borderColor: '#ced4da', // Light border color for Y-axis
          borderWidth: 1
        },
        ticks: {
          color: '#495057', // Darker color for Y-axis ticks
          font: {
            size: 14 // Increased font size for ticks
          },
          stepSize: 1 // Step size for Y-axis ticks
        }
      }
    },
    plugins: {
      legend: {
        display: false // Hide legend if not needed
      },
      tooltip: {
        backgroundColor: '#ffffff', // Background color for tooltip
        titleColor: '#343a40', // Darker color for tooltip title
        bodyColor: '#495057', // Darker color for tooltip body
        borderColor: '#ced4da', // Border color for tooltip
        borderWidth: 1,
        caretSize: 6, // Size of the tooltip caret
        callbacks: {
          label: function(tooltipItem) {
            return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
          }
        }
      }
    }
  }
});


var ctxPie = document.getElementById('pieChart').getContext('2d');
var pieChart = new Chart(ctxPie, {
  type: 'pie',
  data: {
    labels: pieLabels,
    datasets: [{
      data: pieData,
      backgroundColor: ['#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
      hoverOffset: 4
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        position: 'top',
        labels: {
          color: '#5a5c69' // Legend text color
        }
      },
      tooltip: {
        callbacks: {
          label: function(tooltipItem) {
            var total = tooltipItem.dataset.data.reduce((acc, val) => acc + val, 0); // Calculate total
            var percentage = (tooltipItem.raw / total * 100).toFixed(2); // Calculate percentage
            return `${tooltipItem.label}: ${percentage}%`; // Show percentage in tooltip
          }
        },
        backgroundColor: '#ffffff', // Tooltip background color
        titleColor: '#333', // Tooltip title color
        bodyColor: '#666', // Tooltip body color
        borderColor: '#ddd', // Tooltip border color
        borderWidth: 1, // Tooltip border width
        caretSize: 6 // Tooltip caret size
      },
      datalabels: {
        color: '#ffffff', // Data label color
        formatter: (value, ctx) => {
          var total = ctx.chart.data.datasets[0].data.reduce((acc, val) => acc + val, 0); // Calculate total
          var percentage = (value / total * 100).toFixed(2); // Calculate percentage
          return `${percentage}%`; // Show percentage inside pie chart
        },
        font: {
          weight: 'bold' // Font weight for data labels
        },
        align: 'center' // Align data labels in the center of the segments
      }
    }
  }
});

</script>

<?php 
// Include the footer
$this->view('includes/footer'); 
?>
