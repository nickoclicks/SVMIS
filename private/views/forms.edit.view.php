<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

<style>

</style>

<div class="container-fluid shadow mx-auto" style="max-width: 800px;">
    <?php if ($row): ?>
        <div class="card">
            <div class="card-body">
                <h3 class="text-center mb-4">Complaint Details</h3>

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
                    <div class="row">
                        <div class="col-md-6">
                    <div class="mb-4">
                        <label for="complaint" class="form-label">Complaint</label>
                        <input id="complaint" class="form-control" type="text" value="<?= esc(get_var('complaint', $row->complaint)) ?>" name="complaint" readonly>
                    </div>
                    </div>
                        <div class="col-md-6">
                    <div class="mb-4">
                        <label for="resp_id" class="form-label">Respondent ID</label>
                        <input id="resp_id" class="form-control" type="text" value="<?= esc(get_var('resp_id', $row->resp_id)) ?>" name="resp_id" readonly>
                    </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                    <div class="mb-4">
                        <label for="resp_name" class="form-label">Name</label>
                        <input id="resp_name" class="form-control" type="text" value="<?= esc(get_var('resp_name', $row->resp_name)) ?>" name="resp_name" readonly>
                    </div>
                    </div>

                    <div class="col-md-6">
                    <div class="mb-4">
                        <label for="resp_email" class="form-label">Email</label>
                        <input id="resp_email" class="form-control" type="text" value="<?= esc(get_var('compensation', $row->resp_email)) ?>" name="resp_email" readonly>
                    </div>
                    </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="date" class="form-label">Date</label>
                        <input id="date" class="form-control" type="date" value="<?= esc(get_var('date', $row->date)) ?>" name="date">
                    </div>
                    
                    
                    <div class="mb-4">
    <label for="status" class="form-label">Status</label>
    <select id="status" class="form-control" name="status">
        <option value="Unresolved" <?= esc(get_var('status', $row->status)) == 'Unresolved' ? 'selected' : '' ?>>Unresolved</option>
        <option value="Referred to SDC" <?= esc(get_var('status', $row->status)) == 'Referred to SDC' ? 'selected' : '' ?>>Referred to SDC</option>
        <option value="Resolved" <?= esc(get_var('status', $row->status)) == 'Resolved' ? 'selected' : '' ?>>Resolved</option>
    </select>
</div>


                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="<?= ROOT ?>/profile/<?= $row->user_id ?>" class="btn btn-warning text-white">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    <?php else: ?>
        <div class="text-center">
            <h3>That violator was not found</h3>
            <a href="<?= ROOT ?>/violators" class="btn btn-warning text-white mt-3">Back to Violators</a>
        </div>
    <?php endif; ?>
</div>

<?php $this->view('includes/footer'); ?>
