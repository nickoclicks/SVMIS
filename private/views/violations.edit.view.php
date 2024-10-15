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
.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    transition: background-color 0.3s, border-color 0.3s;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #004080;
}

.btn-warning {
    background-color: #ffc107;
    border-color: #ffc107;
    transition: background-color 0.3s, border-color 0.3s;
}

.btn-warning:hover {
    background-color: #e0a800;
    border-color: #d39e00;
}

/* Alert Styles */
.alert {
    border-radius: 10px;
    margin-bottom: 1rem;
}

.alert .btn-close {
    position: absolute;
    top: 0.5rem;
    right: 1rem;
}

/* Form Control Styles */
.form-control {
    border-radius: 8px;
    box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
}

.form-control:focus {
    box-shadow: none;
    border-color: #007bff;
}

</style>
<div class="dashboard-container-fluid p-4 bg-light shadow mx-auto" style="max-width: 1700px;">

    <?php if ($row): ?>
        <div class="card">
            <div class="card-body">
                <h3 class="text-center mb-4">Edit Violation</h3>

                <?php if (count($errors) > 0): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Error:</strong>
                        <?php foreach ($errors as $error): ?>
                            <br><?php echo esc($error); ?>
                        <?php endforeach; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form method="post">
                    <div class="mb-3">
                        <label for="violation" class="form-label">Violation Name</label>
                        <input id="violation" class="form-control" type="text" value="<?= esc(get_var('violation', $row->violation)) ?>" name="violation" placeholder="Violation Name">
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary me-2">Save</button>
                        <a href="<?= ROOT ?>/violations" class="btn btn-warning text-white">Cancel</a>
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
