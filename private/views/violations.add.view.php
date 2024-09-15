<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

<style>
  /* Enhancing Card Appearance */
.card {
    border-radius: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

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
<div class="container-fluid p-4 shadow mx-auto" style="max-width: 650px; margin-top: 30px;">
    <div class="card">
        <div class="card-body">
            <h3 class="text-center mb-4">Add New Violation</h3>

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
                    <input id="violation" class="form-control" type="text" value="<?= esc(get_var('violation')) ?>" name="violation" placeholder="Violation Name">
                </div>

                <div class="mb-3">
                    <label for="shb_article" class="form-label">Student Handbook Article Number</label>
                    <input id="shb_article" class="form-control" type="text" value="<?= esc(get_var('shb_article')) ?>" name="shb_article" placeholder="Student Handbook Article Number">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" class="form-control" name="description" placeholder="Description" rows="6"><?= esc(get_var('description')) ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="compensation" class="form-label">Compensation</label>
                    <textarea id="compensation" class="form-control" name="compensation" placeholder="Compensation" rows="6"><?= esc(get_var('compensation')) ?></textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="<?= ROOT ?>/violations" class="btn btn-warning text-white">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->view('includes/footer'); ?>
