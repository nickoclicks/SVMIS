<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

<div class="container-fluid p-4 shadow-lg mx-auto bg-light" style="max-width: 1200px; margin-top: 30px; border-radius: 10px;">
    <!-- Student Dashboard Content -->
    <div class="container">
        

        <div class="row text-center ">
        <div class="col-md-4">
    <div class="card bg-secondary text-white shadow-sm" style="border-radius: 20px;">
        <div class="card-body">
            <h3 style="text-align: left;">Total Violations</h3>
            <hr>
            <h4 class="display-4 font-weight-bold" style="text-align: right; font-size: 35px; margin-right: 20px;">
                <?= $totalUserViolations ?>
            </h4>
            <a href="<?= ROOT ?>/studentdashboard/details" class="icon-link" style="position: absolute; bottom: 15px; right: 20px;">
                <i class="fas fa-arrow-right" style="font-size: 25px; color: white;margin-bottom: 83px"></i>
            </a>
        </div>
    </div>
</div>


<div class="col-md-4">
    <div class="card bg-secondary text-white shadow-sm" style="border-radius: 20px; position: relative;">
        <div class="card-body">
            <h3 style="text-align: left;">Total Complaints Filed</h3>
            <hr>
            <h4 class="display-4 font-weight-bold" style="text-align: right; font-size: 35px; margin-right: 20px;">
                <?= $totalComplaints ?>
            </h4>
            <a href="<?= ROOT ?>/studentdashboard/details" class="icon-link" style="position: absolute; bottom: 15px; right: 20px;">
                <i class="fas fa-arrow-right" style="font-size: 25px; color: white;margin-bottom: 83px"></i>
            </a>
        </div>
    </div>
</div>


<div class="col-md-4">
    <div class="card bg-secondary text-white shadow-sm" style="border-radius: 20px;">
        <div class="card-body">
            <h3 style="text-align: left;">Total Notices</h3>
            <hr>
            <h4 class="display-4 font-weight-bold" style="text-align: right; font-size: 35px; margin-right: 20px;">
                <?= $totalNotices ?>
            </h4>
            <a href="<?= ROOT ?>/studentdashboard/details" class="icon-link" style="position: absolute; bottom: 15px; right: 20px;">
                <i class="fas fa-arrow-right" style="font-size: 25px; color: white;margin-bottom: 83px"></i>
            </a>
        </div>
    </div>
</div>

        </div>
<!---
        <div class="card shadow-lg mb-5" style="border-radius: 15px;">
            <div class="card-header bg-primary text-white" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                <h6 class="font-weight-bold">
                    <i class="fas fa-list-alt"></i> Your Violations
                </h6>
            </div>
            <div class="card-body p-4">
                <table class="table table-hover table-responsive-sm">
                    <thead class="thead-light">
                        <tr>
                            <th><i class="fas fa-exclamation-triangle"></i> Violation</th>
                            <th><i class="fas fa-calendar-alt"></i> Date</th>
                            <th><i class="fas fa-status"></i>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($violationsCommitted): ?>
                            <?php foreach ($violationsCommitted as $violation): ?>
                                <tr class="table-row-hover" style="cursor: pointer;">
                                    <td><?= htmlspecialchars($violation->violation) ?></td>
                                    <td><?= htmlspecialchars(get_date($violation->date)) ?></td>
                                    <td><?= htmlspecialchars($violation->status) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="2" class="text-center text-muted">No violations recorded.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>-->
</div>

<?php $this->view('includes/footer'); ?>

<style>
    body {
  font-family: 'Open Sans', sans-serif;
}

h2 {
  font-weight: bold;
  font-size: 24px;
}

.card-header h6 {
  font-weight: bold;
  font-size: 18px;
}

.table th, .table td {
  font-size: 16px;
}
   .container {
  padding: 20px;
}

.card {
  margin-bottom: 30px;
}

.card-body {
  padding: 30px;
}

.table {
  margin-bottom: 20px;
}
.card-header {
  background-color: #87CEEB;
  color: #FFFFFF;
}

.table thead th {
  background-color: #F7DC6F;
}
.card-header {
  background-image: linear-gradient(to bottom, #87CEEB, #87CEEB);
  background-color: #87CEEB;
  color: #FFFFFF;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.card {
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}
.table th, .table td {
  padding: 12px;
}

.table-sm {
  font-size: 14px;
}
.table-row-hover:hover {
  background-color: #F1F1F1;
  transition: background-color 0.3s ease;
}
</style>

<script>
    // Add optional interactivity
    document.addEventListener('DOMContentLoaded', function () {
        const rows = document.querySelectorAll('.table-row-hover');

        rows.forEach(function (row) {
            row.addEventListener('click', function () {
                alert('More details will be displayed here!');
            });
        });
    });
</script>


<?php $this->view('includes/footer'); ?>