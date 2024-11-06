<?php 
$this->view('includes/header'); 
$this->view('includes/navigation'); 
?>

<style>
 
  .notification {
    position: fixed;
    top: 20px; /* Position it at the top */
    left: 50%; /* Center it horizontally */
    transform: translateX(-50%); /* Adjust to center */
    background-color: rgba(0, 123, 255, 0.5); /* Semi-transparent background */
    color: white;
    padding: 15px;
    border-radius: 5px;
    z-index: 1000; /* Ensure it's on top of other elements */
    display: none; /* Initially hidden */
    opacity: 0; /* Start with opacity 0 */
    transition: opacity 0.5s ease;
  }

  /* Fade in animation */
  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }

  /* Fade out animation */
  @keyframes fadeOut {
    from { opacity: 1; }
    to { opacity: 0; }
  }
</style>
<div class="dashboard-container" style="margin-left: -150px;">
<div id="notification" class="notification">
    <h6>Please check your notification for appointments today.</h6>
</div>

<script>
    // Show the notification
    function showNotification() {
        var notification = document.getElementById('notification');
        notification.style.display = 'block'; // Show the notification
        notification.style.animation = 'fadeIn 0.5s forwards'; // Fade in animation

        // Hide the notification after 2 seconds
        setTimeout(function() {
            notification.style.animation = 'fadeOut 0.5s forwards'; // Fade out animation
            setTimeout(function() {
                notification.style.display = 'none'; // Hide after fade out
            }, 500); // Wait for fade out transition to complete
        }, 2000); // 2 seconds
    }

    // Call the function to show the notification
    window.onload = showNotification;
</script>

  <div class="stat-row">
    <div class="stat-card">
    <div class="icon" style="color: rgba(0, 0, 255, 0.8);"><i class="fas fa-file-alt"></i></div>
      <h5 style="color: rgba(0, 0, 255, 0.8);">Total Number of Rules</h5>
      <p style="color: rgba(0, 0, 255, 0.8);"><?= $totalViolations ?></p>
    </div>
    <div class="stat-card">
    <div class="icon" style="color: rgba(0, 0, 255, 0.8);"><i class="fas fa-user"></i></div>
    <h5 style="color: rgba(0, 0, 255, 0.8);">Total Violators</h5>
    <p style="color: rgba(0, 0, 255, 0.8);"><?= $totalViolators ?></p>
</div>
    <div class="stat-card">
      <div class="icon" style="color: rgba(0, 0, 255, 0.8);"><i class="fas fa-user-check"></i></div>
      <h5 style="color: rgba(0, 0, 255, 0.8);">Referred to SDC</h5>
      <p style="color: rgba(0, 0, 255, 0.8);"><?= $totalSdcs ?></p>
    </div>
    <div class="stat-card">
    <div class="icon" style="color: rgba(0, 0, 255, 0.8);"><i class="fas fa-exclamation-triangle"></i></div>
      <h5 style="color: rgba(0, 0, 255, 0.8);">Notices</h5>
      <p style="color: rgba(0, 0, 255, 0.8);"><?= $totalNotices ?></p>
    </div>
  </div>


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
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
var chartLabels = <?= json_encode($chartLabels) ?>;
var chartData = <?= json_encode($chartData) ?>;
var pieLabels = <?= json_encode($pieLabels) ?>;
var pieData = <?= json_encode($pieData) ?>;

var ctxLine = document.getElementById('violatorsChart').getContext('2d');

var gradientLine = ctxLine.createLinearGradient(0, 0, 0, 400);
gradientLine.addColorStop(0, 'rgba(78, 11, 111, 0.2)'); // Start color
gradientLine.addColorStop(1, 'rgba(78, 115, 223, 0)'); // End color

var violatorsChart = new Chart(ctxLine, {
  type: 'line',
  data: {
    labels: <?= json_encode($chartLabels) ?>,
    datasets: [{
      label: 'Number of Violators',
      data: <?= json_encode($chartData) ?>,
      borderColor: 'orange', 
      backgroundColor: gradientLine,
      borderWidth: 3,
      fill: true,
      tension: 0.4,
      pointBorderColor: 'red',
      pointBackgroundColor: '#ffffff',
      pointBorderWidth: 3,
      pointRadius: 6,
      pointHoverRadius: 8,
      pointHoverBackgroundColor: '#4e73df',
      pointHoverBorderColor: '#fff'
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
          color: '#5a5c69',
          font: {
            size: 16,
            weight: 'bold'
          }
        },
        grid: {
          color: '#e6e6e6',
          borderColor: '#d1d3e2'
        },
        ticks: {
          color: 'black',
          font: {
            size: 18
          }
        }
      },
      y: {
        title: {
          display: true,
          text: 'Number of Violators',
          color: 'black',
          font: {
            size: 18,
            weight: 'bold'
          }
        },
        grid: {
          color: '#e6e6e6',
          borderColor: 'black'
        },
        ticks: {
          color: 'black',
          font: {
            size: 18
          }
        }
      }
    },
    plugins: {
      legend: {
        display: false
      },
      tooltip: {
        backgroundColor: 'rgba(255, 255, 255, 0.8)',
        titleColor: '#333',
        bodyColor: '#5a5c69',
        borderColor: '#d1d3e2', 
        borderWidth: 1,
        caretSize: 8,
        titleFont: {
          size: 14,
          weight: 'bold'
        },
        bodyFont: {
          size: 12
        },
        padding: 12,
        callbacks: {
          label: function(tooltipItem) {
            return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
          }
        }
      }
    },
    animation: {
      duration: 1500,
      easing: 'easeOutCubic'
    }
  }
});

document.getElementById('time-period').addEventListener('change', function() {
  var selectedTimePeriod = this.value;
  var chartData = [];
  var chartLabels = [];

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

  violatorsChart.data.labels = chartLabels;
  violatorsChart.data.datasets[0].data = chartData;
  violatorsChart.update();

  
});

var barChartLabels = <?= json_encode($barChartLabels) ?>;
var barChartData = <?= json_encode($barChartData) ?>;

var ctxBar = document.getElementById('barChart').getContext('2d');

var gradient = ctxBar.createLinearGradient(0, 0, 0, 400);
gradient.addColorStop(0, 'rgba(78, 115, 223, 1)'); 
gradient.addColorStop(1, 'rgba(78, 115, 223, 0.5)');

var barChart = new Chart(ctxBar, {
    type: 'bar',
    data: {
        labels: barChartLabels,
        datasets: [{
            label: 'Number of Violations',
            data: barChartData,
            backgroundColor: [
                'rgba(78, 115, 223, 1)', 
                'rgba(28, 200, 138, 1)',
                'rgba(255, 206, 86, 1)', 
                
            ],
            borderColor: '#4e73df',
            borderWidth: 3,
            barPercentage: 0.7,
            borderRadius: 15,
            hoverBackgroundColor: '#2e59d9',
            hoverBorderColor: '#1d72b8',
            borderSkipped: false,
            shadowOffsetX: 4,
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
                    color: 'black',
                    font: {
                        size: 14,
                       
                        family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif"
                    }
                },
                grid: {
                    display: false
                },
                ticks: {
                    color: 'black',
                    font: {
                        size: 18
                    }
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'Number of Violations',
                    color: 'black',
                    font: {
                        size: 18,
                        weight: 'bold',
                        family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif"
                    }
                },
                grid: {
                    color: '#e5e5e5',
                    borderColor: '#dcdcdc',
                    borderDash: [5, 5]
                },
                ticks: {
                    color: 'black',
                    font: {
                        size: 18
                    },
                    stepSize: 1
                }
            }
        },
        plugins: {
            legend: {
                display: true,
                labels: {
                    color: 'black',
                    font: {
                        size: 18,
                       
                    }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.7)',
                titleColor: '#ffffff',
                bodyColor: '#ffffff',
                borderColor: '#ffffff', 
                borderWidth: 1,
                caretSize: 6,
                titleFont: {
                    size: 14,
                    weight: 'bold'
                },
                bodyFont: {
                    size: 13
                },
                padding: 12,
                displayColors: false, 
                callbacks: {
                    label: function(tooltipItem) {
                        var totalValue = barChartData.reduce((acc, val) => acc + val, 0);
                        var percentage = (tooltipItem.raw / totalValue * 100).toFixed(2); 
                        return `Violations: ${tooltipItem.raw} (${percentage}%)`; 
                    }
                }
            }
        },
        animation: {
            duration: 1500,
            easing: 'easeOutBounce'
        }
    }
});

var statusLabels = <?= json_encode($statusLabels) ?>;
var statusData = <?= json_encode($statusData) ?>;

var ctxStatus = document.getElementById('statusChart').getContext('2d');

var gradientStatus = ctxStatus.createLinearGradient(0, 0, 0, 400);
gradientStatus.addColorStop(0, 'rgba(28, 200, 138, 1)'); 
gradientStatus.addColorStop(1, 'rgba(28, 200, 138, 0.5)'); 

var statusChart = new Chart(ctxStatus, {
  type: 'bar',
  data: {
    labels: statusLabels,
    datasets: [{
      label: 'Number of Violations by Status',
      data: statusData,
      backgroundColor: [
        'rgba(28, 200, 138, 1)',
        'rgba(231, 74, 59, 1)',
      ],
      borderColor: '#1cc88a',
      borderWidth: 3, 
      barPercentage: 0.7,
      borderRadius: 15,
      hoverBackgroundColor: '#17a673',
      hoverBorderColor: '#148a5f',
      borderSkipped: false, 
      shadowOffsetX: 4, 
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
          text: 'Status',
          color: 'black',
          font: {
            size: 14,
           
            family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif"
          }
        },
        grid: {
          display: false
        },
        ticks: {
          color: 'black', 
          font: {
            size: 18
          }
        }
      },
      y: {
        title: {
          display: true,
          text: 'Number of Violations',
          color: 'black', 
          font: {
            size: 18,
            weight: 'bold',
            family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif"
          }
        },
        grid: {
          color: '#e5e5e5', 
          borderColor: '#dcdcdc', 
          borderDash: [5, 5]
        },
        ticks: {
          color: 'black',
          font: {
            size: 18
          },
          stepSize: 1 
        }
      }
    },
    plugins: {
      legend: {
        display: true, 
        labels: {
          color: 'black', 
          font: {
            size: 18,
            
          }
        }
      },
      tooltip: {
        backgroundColor: 'rgba(0, 0, 0, 0.7)', 
        titleColor: '#ffffff', 
        bodyColor: '#ffffff', 
        borderColor: '#ffffff', 
        borderWidth: 1,
        caretSize: 6, 
        titleFont: {
          size: 14,
          weight: 'bold'
        },
        bodyFont: {
          size: 13
        },
        padding: 12, 
        displayColors: false,
        callbacks: {
          title: function(tooltipItem) {
            return 'Status: ' + tooltipItem[0].label; 
          },
          label: function(tooltipItem) {
            var totalValue = statusData.reduce((acc, val) => acc + val, 0); 
            var percentage = (tooltipItem.raw / totalValue * 100).toFixed(2);
            return `Violations: ${tooltipItem.raw} (${percentage}%)`; 
          }
        }
      }
    },
    animation: {
      duration: 1500,
      easing: 'easeOutBounce' 
    }
  }
});

var ctxPie = document.getElementById('pieChart').getContext('2d');

var colors = [
  'rgba(231, 74, 59, 0.9)',  
  'rgba(246, 194, 62, 0.9)',
];

var hoverColors = [
  'rgba(231, 74, 59, 1)',
  'rgba(246, 194, 62, 1)',
];


var totalValue = pieData.reduce((acc, val) => acc + val, 0);
var totalPercentage = 100;

var pieChart = new Chart(ctxPie, {
  type: 'pie',
  data: {
    labels: pieLabels,
    datasets: [{
      data: pieData,
      backgroundColor: colors,
      hoverBackgroundColor: hoverColors,
      borderWidth: 2, 
      borderColor: '#fff' 
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        position: 'top',
        labels: {
          color: 'black', 
          font: {
            size: 18,
            
          }
        }
      },
      tooltip: {
    backgroundColor: 'rgba(255, 255, 255, 0.9)', 
    titleColor: '#333',
    bodyColor: '#666',
    borderColor: '#ddd', 
    borderWidth: 1,
    caretSize: 6, 
    padding: 12, 
    callbacks: {
        label: function(tooltipItem) {
            var totalValue = pieData.reduce((acc, val) => acc + val, 0); 
            var percentage = (tooltipItem.raw / totalValue * 100).toFixed(2); 
            return `${tooltipItem.label}: ${tooltipItem.raw} (${percentage}%)`;
        }
    }
}
    },
    cutout: '60%',
    elements: {
      arc: {
        borderWidth: 0, 
        hoverBorderWidth: 2,
        hoverBorderColor: '#fff', 
        shadowOffsetX: 0,
        shadowOffsetY: 0,
        shadowBlur: 12,
        shadowColor: 'rgba(0, 0, 0, 0.15)' 
      }
    },
    animation: {
      animateScale: true, 
      animateRotate: true 
    }
  },
  plugins: []
});


</script>

<?php 

$this->view('includes/footer'); 
?>
