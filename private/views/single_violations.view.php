<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

<style>
  /* Card Styles */
.table-bordered th, .table-bordered td {
    border: 1px solid #dee2e6;
}

/* Tab Styles */
.nav-tabs .nav-link.active {
    color: #495057;
    background-color: #e9ecef;
    border-color: #dee2e6 #dee2e6 #fff;
}

/* Spacing and Alignment */
.mb-4 {
    margin-bottom: 1.5rem;
}

.text-center {
    text-align: center;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .container-fluid {
        padding-left: 1rem;
        padding-right: 1rem;
    }
}

</style>
<div class="container-fluid p-4 shadow mx-auto" style="max-width: 1000px; margin-top: 30px;">

    <?php if ($row): ?>
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="text-center mb-4"><?= ucwords($row->violation) ?></h4>

                <table class="table table-hover table-striped table-bordered">
                    <tbody>
                        <tr>
                            <th>Violation Name:</th>
                            <td><?= htmlspecialchars($row->violation) ?></td>
                        </tr>
                        <tr>
                            <th>Created by:</th>
                            <td><?= htmlspecialchars($row->user->firstname) ?> <?= htmlspecialchars($row->user->lastname) ?></td>
                        </tr>
                        <tr>
                            <th>Date Created:</th>
                            <td><?= htmlspecialchars(get_date($row->user->date)) ?></td>
                        </tr>
                        <tr>
                            <th>Description:</th>
                            <td><?= nl2br(htmlspecialchars($row->description)) ?></td>
                        </tr>
                        <tr>
                            <th>SHB Article:</th>
                            <td><?= htmlspecialchars($row->shb_article) ?></td>
                        </tr>
                        <tr>
                            <th>Compensation</th>
                            <td><?= htmlspecialchars($row->compensation) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <hr class="my-4">

        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link <?= $page_tab == 'violators' ? 'active' : ''; ?>" href="<?= ROOT ?>/single_violations/<?= $row->violation_id ?>?tab=violators">Violators</a>
            </li>
            <!-- Add other tabs if needed -->
        </ul>

        <div class="tab-content">
            <?php
            switch ($page_tab) {
                case 'violators':
                    include(views_path('violations-tab-violators'));
                    break;
                case 'violators-add':
                    include(views_path('violations-tab-violators-add'));
                    break;
                case 'violators-remove':
                    include(views_path('violations-tab-violators-remove'));
                    break;
                // Add other cases if needed
            }
            ?>
        </div>

    <?php else: ?>
        <h4 class="text-center">That violation's details were not found!</h4>
    <?php endif; ?>
</div>

<?php $this->view('includes/footer'); ?>
