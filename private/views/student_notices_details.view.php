<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

<style>
    

    /* Additional responsive table styling */
    @media (max-width: 768px) {
        .table-responsive-sm {
            font-size: 13px;
        }
    }

    /* Aligning icon styles with dashboard */
    .fa-exclamation-triangle, .fa-calendar-alt, .fa-status, .fa-comment-alt, .fa-bell {
        color: #4e73df;
    }

    .mb-5 {
        margin-bottom: 1.5rem;
    }
</style>
<div class="dashboard-container-fluid p-4 shadow-lg mx-auto bg-light" style="max-width: 1700px; border-radius: 10px;">
<!-- Violations Section 
<div class="card shadow-lg mb-5">
    <div class="card-header bg-primary text-white">
        <h6 class="font-weight-bold">
            <i class="fas fa-list-alt"></i> Your Violations
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
        <table class="table table-hover table-sm">
            <thead class="thead-light">
                <tr>
                    <th><i class="fas fa-exclamation-triangle"></i> Violation</th>
                    <th><i class="fas fa-calendar-alt"></i> Date</th>
                    <th><i class="fas fa-status"></i> Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($violationsCommitted): ?>
                    <?php foreach ($violationsCommitted as $violation): ?>
                        <tr>
                            <td><?= htmlspecialchars($violation->violation) ?></td>
                            <td><?= htmlspecialchars(get_date($violation->date)) ?></td>
                            <td><?= htmlspecialchars($violation->status) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center text-muted">No violations recorded.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</div>
</div>

    <!-- Complaints Section
    <div class="card shadow-lg mb-5">
        <div class="card-header">
            <h6 class="font-weight-bold">
                <i class="fas fa-comment-alt"></i> Your Complaints
            </h6>
        </div>
        <div class="card-body">
            <table class="table table-hover table-responsive-sm">
                <thead>
                    <tr>
                        <th><i class="fas fa-comment-alt"></i> Complaint</th>
                        <th>Respondent</th>
                        <th><i class="fas fa-calendar-alt"></i> Date</th>
                        <th><i class="fas fa-status"></i> Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($complaints): ?>
                        <?php foreach ($complaints as $complaint): ?>
                            <tr class="table-row-hover">
                                <td><?= htmlspecialchars($complaint->complaint) ?></td>
                                <td><?= htmlspecialchars($complaint->resp_name) ?></td>
                                <td><?= htmlspecialchars(get_date($complaint->date)) ?></td>
                                <td><?= htmlspecialchars($complaint->status) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted">No complaints recorded.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Notices Section -->
    <div class="card shadow-lg mb-5">
        <div class="card-header">
            <h6 class="font-weight-bold">
                <i class="fas fa-bell"></i> Your Notices
            </h6>
        </div>
        <div class="card-body">
            <table class="table table-hover table-responsive-sm">
                <thead>
                    <tr>
                        <th><i class="fas fa-bell"></i> Notice</th>
                        <th><i class="fas fa-calendar-alt"></i> Date</th>
                        <th>Complainant</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($notices): ?>
                        <?php foreach ($notices as $notice): ?>
                            <tr class="table-row-hover">
                                <td><?= htmlspecialchars($notice->complaint) ?></td>
                                <td><?= htmlspecialchars(get_date($notice->date)) ?></td>
                                <td><?= ucwords(str_replace('.',' ',esc($notice->user_id))) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center text-muted">No notices recorded.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->view('includes/footer'); ?>
