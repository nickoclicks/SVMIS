<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

<style>
    /* Font family and sizes */
    body {
        font-family: 'Open Sans', sans-serif;
    }
    h5 {
        font-size: 22px;
        font-weight: bold;
    }
    .table td, .table th {
        font-size: 20px;
        font-weight: 400;
    }

    /* Line height and margins */
    .table td, .table th {
        line-height: 1.5;
        padding: 0.5rem;
    }
  

    /* Other styles */
    .badge {
        font-size: 15px;
        font-weight: bold;
        padding: 0.2rem 0.5rem;
        border-radius: 0.2rem;
    }
    .navbar {
  background: linear-gradient(to bottom, rgba(255, 255, 255, 1), rgba(255, 255, 255, 1)) !important;
  background-image: linear-gradient(to bottom, #f7f7f7, #ffffff) !important;
}

.btn-outline-primary:hover {
    background-color: rgba(0, 123, 255, 0.1); /* Light blue background on hover */
}

.btn-outline-success:hover {
    background-color: rgba(40, 167, 69, 0.1); /* Light green background on hover */
}

.btn-outline-danger:hover {
    background-color: rgba(220, 53, 69, 0.1); /* Light red background on hover */
}

.btn-success:hover {
    background-color: #218838; /* Darker green on hover */
}

</style>

<div class="dashboard-container p-4 mx-auto" style="max-width: 1700px;">



    <div class="row mb-4 sticky-top">
    <nav class="navbar bg-body-tertiary shadow" style="background-color: gray; border-radius: 10px">
    <div class="col-md-2">
    <div class="input-group">
    <span class="input-group-text" style="margin-left: 10px"><i class="fa fa-search"></i></span>
        <input type="text" class="form-control" id="search" placeholder="Search Violations" onkeyup="filterTable()" aria-label="Search Violations" style="width: 200px;">
    </div>
</div>

<div class="col-md-8 text-center">
<h5>Based on Article 8 Section 10 of NBSC Students Handbook</h5>
</div>

        <div class="col-md-2 text-end">

        <?php if (Auth::canPerformAction()): ?>
            <a href="<?= ROOT ?>/violations/add" class="btn">
                <i class="fa fa-plus"></i> Add New Violation
            </a>
            <?php endif ?>
        </div>
    </div>



<div class="card p-3 bg-body-tertiary shadow" style="background-color: gray; border-radius: 10px">
    <div class="border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle text-center">
            <thead class="table-dark table-striped table-hover text-light" style="background: linear-gradient(45deg, #343a40, #495057);">
                    <tr>
                        <th class="text-light" style="width: 50px;">Details</th>
                        <th class="text-light">Violation Name</th>
                        <th class="text-light">Level</th>
                        <th class="text-light">Category</th>
                        <th class="text-light">Created by</th>
                        <th class="text-light">Date</th>
                        <?php if (Auth::canPerformAction()): ?>
                        <th style="width: 200px;" class="text-light">Actions</th>
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
                <i class="fa fa-chevron-right fa-lg text-primary"></i>
            </a>
        </td>
        <td><?= $row->violation ?></td>
        <td>
    <span <?= ($row->level == 'Major') ? 'class="badge bg-danger"' : 'class="badge bg-warning"' ?>>
        <i class="fa fa-tag"></i> <?= $row->level ?>
    </span>
</td>
        <td><?= $row->category ?></td>
        <td><?= $row->user->firstname ?> <?= $row->user->lastname ?></td>
        <td><?= get_date($row->date) ?></td>

        <?php if (Auth::canPerformAction()): ?>
    <td>
        <?php if ($user_id): ?>
            <a href="<?= ROOT ?>/violations/assign/<?= $row->id ?>?user_id=<?= $user_id ?>" 
            class="btn btn-outline-success btn-sm"  
               onclick="return confirmAddViolation(event)">
                <i class="fa fa-plus fa-lg text-success"></i>
                
            </a>
        <?php else: ?>
            <a href="<?= ROOT ?>/violations/edit/<?= $row->id ?>" class="btn btn-outline-success btn-sm">
                <i class="fa fa-edit fa-lg text-success"></i>
            </a>
            <a href="<?= ROOT ?>/violations/delete/<?= $row->id ?>" class="btn btn-outline-danger btn-sm">
                <i class="fa fa-trash-alt fa-lg text-danger"></i>
            </a>
        <?php endif; ?>
    </td>
<?php endif ?>
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
</div>


<script>
    function confirmAddViolation(event) {

     
    event.preventDefault(); // Prevent the default behavior of the link
    Swal.fire({
        title: 'Add Violation',
        text: 'Are you sure you want to add this violation?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Add',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
    }).then((result) => {
        if (result.isConfirmed) {
            // Add the violation logic here
            // You can use the event.target.href to get the href attribute of the link
            window.location.href = event.target.href;
        }
    });
}
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
