<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

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
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Details</h2>


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
    


        <!-- ... existing code ... -->

<!-- Complaints Section -->
<div class="card shadow-lg mb-5" style="border-radius: 15px;">
    <div class="card-header bg-primary text-white" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
        <h6 class="font-weight-bold">
            <i class="fas fa-comment-alt"></i> Your Complaints
        </h6>
    </div>
    <div class="card-body p-4">
        <table class="table table-hover table-responsive-sm">
            <thead class="thead-light">
                <tr>
                    <th><i class="fas fa-comment-alt"></i> Complaint</th>
                    <th>Respondent</th>
                    <th><i class="fas fa-calendar-alt"></i> Date</th>
                    <th><i class="fas fa-status"></i>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($complaints): ?>
                    <?php foreach ($complaints as $complaint): ?>
                        <tr class="table-row-hover" style="cursor: pointer;">
                            <td><?= htmlspecialchars($complaint->complaint) ?></td>
                            <td><?= htmlspecialchars($complaint->resp_name) ?></td>
                            <td><?= htmlspecialchars(get_date($complaint->date)) ?></td>
                            <td><?= htmlspecialchars($complaint->status) ?></td>
                            
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2" class="text-center text-muted">No complaints recorded.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Notices Section -->
<div class="card shadow-lg mb-5" style="border-radius: 15px;">
    <div class="card-header bg-primary text-white" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
        <h6 class="font-weight-bold">
            <i class="fas fa-bell"></i> Your Notices
        </h6>
    </div>
    <div class="card-body p-4">
        <table class="table table-hover table-responsive-sm">
            <thead class="thead-light">
                <tr>
                    <th><i class="fas fa-bell"></i> Notice</th>
                    <th><i class="fas fa-calendar-alt"></i> Date</th>
                    <th>Complainant</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($notices): ?>
                    <?php foreach ($notices as $notice): ?>
                        <tr class="table-row-hover" style="cursor: pointer;">
                            <td><?= htmlspecialchars($notice->complaint) ?></td>
                            <td><?= ucwords(str_replace('.',' ',esc($notice->user_id))) ?></td>
                            <td><?= htmlspecialchars(get_date($notice->date)) ?></td>
                            
                            
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2" class="text-center text-muted">No notices recorded.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
    </div>
<!-- ... existing code ... -->

    
<?php $this->view('includes/footer'); ?>