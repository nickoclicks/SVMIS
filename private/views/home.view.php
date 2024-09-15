<?php 
// wala nani labot, gi forward na nako sa sdc ang view para sa home kay gi integrate na ang home ug analytics
$this->view('includes/header'); 
$this->view('includes/navigation'); 
?>

<style>
  /* Main container styling */
  .dashboard-container {
    padding: 30px;
    background-color: #f4f6f9;
    min-height: 100vh;
  }

  /* Flexbox for stats */
  .stat-row {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 30px;
  }

  /* Stat card styling */
  .stat-card {
    background-color: #ffffff;
    border: 1px solid #d1d3e2;
    padding: 20px;
    border-radius: 8px;
    flex: 1;
    min-width: 200px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: box-shadow 0.3s, transform 0.3s;
    text-align: center;
    position: relative;
  }

  .stat-card .icon {
    font-size: 2em;
    color: #4e73df;
    position: absolute;
    top: 20px;
    right: 20px;
  }

  .stat-card:hover {
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    transform: translateY(-5px);
  }

  /* Titles and stats */
  .stat-card h5 {
    font-size: 1.2em;
    color: #5a5c69;
    margin-bottom: 10px;
  }

  .stat-card p {
    font-size: 2em;
    font-weight: 600;
    color: #4e73df;
    margin: 0;
  }

  /* Flexbox for charts */
  .chart-row {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 30px;
  }

  .chart-wrapper {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    flex: 1;
    min-width: 300px;
  }

  canvas {
    width: 100% !important;
    height: 300px !important;
  }

  /* Flexbox container for tables */
  .table-row {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 30px;
  }

  /* Individual table styling */
  .table-wrapper {
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    flex: 1;
    min-width: 300px;
    margin-right: 20px;
  }

  /* Remove margin from the last table */
  .table-wrapper:last-child {
    margin-right: 0;
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .stat-row, .chart-row, .table-row {
      flex-direction: column;
    }

    .table-wrapper {
      margin-right: 0;
      margin-bottom: 20px;
    }
  }
</style>

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
  </div>

  <!-- Tables Row: Recently Added Violations & Violators -->
  <div class="table-row">
    <div class="table-wrapper">
      <h6><i class="fas fa-list-alt"></i> Recently Added Violations</h6>
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Violation</th>
            <th>Date</th>
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
            <th>Name</th>
            <th>Date</th>
            <th>Course</th>
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

<!-- Chart.js Script for Violators Graph -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Pass violators data from PHP to JavaScript
  var chartLabels = <?= json_encode($chartLabels) ?>;
  var chartData = <?= json_encode($chartData) ?>;

  var ctxLine = document.getElementById('violatorsChart').getContext('2d');
  var violatorsChart = new Chart(ctxLine, {
    type: 'line',
    data: {
      labels: chartLabels,
      datasets: [{
        label: 'Number of Violators',
        data: chartData,
        borderColor: '#4e73df',
        backgroundColor: 'rgba(78, 115, 223, 0.1)',
        borderWidth: 2,
        fill: true,
        tension: 0.4
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        x: {
          title: {
            display: true,
            text: 'Date'
          },
          grid: {
            display: false
          }
        },
        y: {
          title: {
            display: true,
            text: 'Number of Violators'
          },
          grid: {
            display: true
          }
        }
      },
      plugins: {
        legend: {
          display: false
        },
        tooltip: {
          callbacks: {
            label: function(tooltipItem) {
              return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
            }
          }
        }
      },
      elements: {
        point: {
          radius: 5,
          hoverRadius: 7
        }
      }
    }
  });
</script>

<?php 
// Include the footer
$this->view('includes/footer'); 
?>
