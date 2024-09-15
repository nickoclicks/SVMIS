<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

<style>
  /* Card Styles */
.card {
    border-radius: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

/* Card Body Styles */
.card-body {
    padding: 2rem;
}

/* Button Styles */
.btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
    transition: background-color 0.3s, border-color 0.3s;
}

.btn-danger:hover {
    background-color: #c82333;
    border-color: #bd2130;
}

.btn-success {
    background-color: #28a745;
    border-color: #28a745;
    transition: background-color 0.3s, border-color 0.3s;
}

.btn-success:hover {
    background-color: #218838;
    border-color: #1e7e34;
}

/* Alert Styles */
.alert {
    border-radius: 10px;
    margin-bottom: 1rem;
}

/* Form Control Styles */
.form-control {
    border-radius: 8px;
    box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
}

.form-control:disabled {
    background-color: #e9ecef;
    opacity: 1;
}

/* Layout Styles */
.text-center {
    text-align: center;
}

.d-flex {
    display: flex;
}

.justify-content-end {
    justify-content: flex-end;
}

</style>

<div class="container-fluid p-4 shadow mx-auto" style="max-width: 1000px;">

    <?php if ($row): ?>
        <div class="card">
            <div class="card-body">
                <h3 class="text-center mb-4">Confirm Deletion</h3>

                <form method="post">
                    <div class="mb-3">
                        <label for="violation" class="form-label">Violation Name</label>
                        <input id="violation" class="form-control" type="text" value="<?= esc(get_var('violations', $row->violation)) ?>" name="violation" placeholder="Violation Name" disabled>
                    </div>

                    <input type="hidden" name="id" value="<?= esc($row->id) ?>">

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-danger me-2">Delete</button>
                        <a href="<?= ROOT ?>/violations" class="btn btn-success text-white">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    <?php else: ?>
        <div class="text-center">
            <h3>That violation was not found</h3>
            <a href="<?= ROOT ?>/violations" class="btn btn-warning text-white mt-3">Back to Violations</a>
        </div>
    <?php endif; ?>
</div>

<?php $this->view('includes/footer'); ?>
