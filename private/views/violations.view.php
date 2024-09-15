<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

<div class="container-fluid p-4 mx-auto shadow-sm" style="max-width: 1400px; margin-top: 30px; background-color: #f8f9fa;">
    <div class="row mb-4">
        <div class="col text-center">
            <h2 class="fw-bold text-primary">Violations</h2>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <input type="text" class="form-control" id="search" placeholder="Search Violations" onkeyup="filterTable()" aria-label="Search Violations" style="width: 300px;">
        </div>
        <div class="col-md-6 text-end">

        <?php if (Auth::canPerformAction()): ?>
            <a href="<?= ROOT ?>/violations/add" class="btn btn-success">
                <i class="fa fa-plus"></i> Add New Violation
            </a>
            <?php endif ?>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle text-center">
                <thead class="table-dark table-striped table-hover">
                    <tr>
                        <th style="width: 50px;">Deatails</th>
                        <th>Violation Name</th>
                        <th>Created by</th>
                        <th>Date</th>
                        <?php if (Auth::canPerformAction()): ?>
                        <th style="width: 200px;">Actions</th>
                        <?php endif ?>
                    </tr>
                </thead>
                <tbody id="violationTable">
                    <?php
                    $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;

                    if ($rows): ?>
                        <?php foreach ($rows as $row): ?>
                            <tr>
                                <td>
                                    <a href="<?= ROOT ?>/single_violations/<?= $row->violation_id ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="fa fa-chevron-right"></i>
                                    </a>
                                </td>
                                <td><?= $row->violation ?></td>
                                <td><?= $row->user->firstname ?> <?= $row->user->lastname ?></td>
                                <td><?= get_date($row->date) ?></td>

                                <?php if (Auth::canPerformAction()): ?>
                                <td>
                                    <a href="<?= ROOT ?>/violations/edit/<?= $row->id ?>" class="vbtn btn btn-sm btn-info text-white">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="<?= ROOT ?>/violations/delete/<?= $row->id ?>" class="vbtn btn btn-sm btn-danger">
                                        <i class="fa fa-trash-alt"></i>
                                    </a>
                                    <?php if ($user_id): ?>
                                        <a href="<?= ROOT ?>/violations/assign/<?= $row->id ?>?user_id=<?= $user_id ?>" class="vbtn btn btn-sm btn-success">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <?php endif ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">
                                <div class="alert alert-warning text-center">
                                    No Violations were found at this time.
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Message to show when no search results are found -->
            <div id="noResultsMessage" class="alert alert-info text-center" style="display: none;">
                No recorded violations match your search.
            </div>
        </div>
    </div>
</div>

<script>
    function filterTable() {
        const searchInput = document.getElementById('search').value.toUpperCase();
        const table = document.getElementById('violationTable');
        const rows = table.getElementsByTagName('tr');
        let hasMatch = false;

        for (let i = 0; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            let match = false;

            for (let j = 1; j < cells.length - 1; j++) {
                if (cells[j].textContent.toUpperCase().includes(searchInput)) {
                    match = true;
                    break;
                }
            }

            if (match) {
                rows[i].style.display = '';
                hasMatch = true;
            } else {
                rows[i].style.display = 'none';
            }
        }

        const noResultsMessage = document.getElementById('noResultsMessage');
        if (!hasMatch) {
            noResultsMessage.style.display = 'block';
        } else {
            noResultsMessage.style.display = 'none';
        }
    }
</script>

<?php $this->view('includes/footer'); ?>
