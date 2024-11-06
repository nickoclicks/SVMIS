<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

<style>

</style>

<div style="margin-left: -150px;">
<div class="dashboard-container shadow mx-auto" style="max-width: 1700px;">
    <?php if ($row): ?>
        <div class="card">
            <div class="card-body">
                <h3 class="text-center mb-4">Complaint Resolution Form</h3>

                <?php if (count($errors) > 0): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Error:</strong>
                        <?php foreach ($errors as $error): ?>
                            <br><?php echo esc($error); ?>
                        <?php endforeach; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form id="complaintForm" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="complaint" class="form-label">Complaint</label>
                                <input id="complaint" class="form-control" type="text" value="<?= esc(get_var('complaint', $row->complaint)) ?>" name="complaint" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="appt_date" class="form-label">Date of Hearing</label>
                                <input id="appt_date" class="form-control" type="text" value="<?= esc(get_var('appt_date', $row->appt_date)) ?>" name="appt_date" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="id" class="form-label">Complaint Number</label>
                                <input id="id" class="form-control" type="text" value="<?= esc(get_var('id', $row->id)) ?>" name="id" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="violations" class="form-label">Violations</label>
                                <input id="violations" class="form-control" type="text" value="<?= esc(get_var('violations', $row->violations)) ?>" name="violations" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="user_id" class="form-label">Complainant</label>
                                <input id="user_id" class="form-control" type="text" value="<?= esc(get_var('user_id', $row->user_id)) ?>" name="user_id" readonly>
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
                                <label for="resp_name" class="form-label">Respondent</label>
                                <input id="resp_name" class="form-control" type="text" value="<?= esc(get_var('resp_name', $row->resp_name)) ?>" name="resp_name" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="resp_email" class="form-label">Email</label>
                                <input id="resp_email" class="form-control" type="text" value="<?= esc(get_var('resp_email', $row->resp_email)) ?>" name="resp_email" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class=col-md-6>
                        
                                <label for="status" class="form-label">Status</label>
                                <select id="status" class="form-control" name="status">
                                <option value="Dismissed" <?= esc(get_var('status', $row->status)) == 'Dismissed' ? 'selected' : '' ?>>Dismissed</option>
                                <option value="Settled amicably" <?= esc(get_var('status', $row->status)) == 'Settled amicably' ? 'selected' : '' ?>>Settled amicably</option>
                                    <option value="Unresolved" <?= esc(get_var('status', $row->status)) == 'Unresolved' ? 'selected' : '' ?>>Unresolved</option>
                                    <option value="Referred to SDC" <?= esc(get_var('status', $row->status)) == 'Referred to SDC' ? 'selected' : '' ?>>Referred to SDC</option>
                                    <option value="Resolved" <?= esc(get_var('status', $row->status)) == 'Resolved' ? 'selected' : '' ?>>Resolved</option>
                                </select>
                            </div>
                    
                        
                        <div class="col-md-6 mb-4">
    <label for="sanction_party" class="form-label">Sanction on:</label>
    <div class="mt-4">
        <label>
            <input type="radio" name="sanction_party" value="Complainant" 
            <?= esc(get_var('sanction_party', $row->sanction_party)) == 'Complainant' ? 'checked' : '' ?>> Complainant
        </label>
        <label>
            <input type="radio" name="sanction_party" value="Respondent" 
            <?= esc(get_var('sanction_party', $row->sanction_party)) == 'Respondent' ? 'checked' : '' ?>> Respondent
        </label>
        <label>
            <input type="radio" name="sanction_party" value="Both" 
            <?= esc(get_var('sanction_party', $row->sanction_party)) == 'Both' ? 'checked' : '' ?>> Both Parties
        </label>
        <label>
            <input type="radio" name="sanction_party" value="Not Applicable" 
            <?= esc(get_var('sanction_party', $row->sanction_party)) == 'Not Applicable' ? 'checked' : '' ?>> Not Applicable
        </label>
    </div>
</div>
                    </div>

<div class="mb-4">
    <label for="sanction_type" class="form-label">Sanction:</label>
    <div class="mt-4">
        <label>
            <input type="radio" name="sanction_type" value="Community Service" 
            <?= (esc(get_var('sanction_type', $row->sanction_type)) === 'Community Service') ? 'checked' : '' ?> 
            onclick="setPartyType('Community Service')"> Community Service
        </label>
        <label>
            <input type="radio" name="sanction_type" value="Character Probation" 
            <?= (esc(get_var('sanction_type', $row->sanction_type)) === 'Character Probation') ? 'checked' : '' ?> 
            onclick="setPartyType('Character Probation')"> Character Probation
        </label>
        <label>
            <input type="radio" name="sanction_type" value="Final Character Probation" 
            <?= (esc(get_var('sanction_type', $row->sanction_type)) === 'Final Character Probation') ? 'checked' : '' ?> 
            onclick="setPartyType('Final Character Probation')"> Final Character Probation
        </label>
        <label>
            <input type="radio" name="sanction_type" value="Guidance Counseling" 
            <?= (esc(get_var('sanction_type', $row->sanction_type)) === 'Guidance Counseling') ? 'checked' : '' ?> 
            onclick="setPartyType('Guidance Counseling')"> Guidance Counseling
        </label>
        <label>
            <input type="radio" name="sanction_type" value="Not Applicable" 
            <?= esc(get_var('sanction_type', $row->sanction_party)) == 'Not Applicable' ? 'checked' : '' ?>> Not Applicable
        </label>
    </div>
</div>

<!-- Additional Fields for Community Service -->
 
<div id="communityServiceFields" style="display: none;">
<div class="row">
    <div class="col-md-6">
    <div class="mb-4">
        <label for="hours" class="form-label">Hours:</label>
        <input id="hours" class="form-control" type="number" name="hours" 
        value="<?= esc(get_var('hours', $row->hours)) ?>">
    </div>
    </div>
    <div class="col-md-6">
    <div class="mb-4">
        <label for="comm_date" class="form-label">Date:</label>
        <input id="comm_date" class="form-control" type="date" name="comm_date" 
        value="<?= esc(get_var('comm_date', $row->comm_date)) ?>">
    </div>
    </div>
    <div class="col-md-6">
    <div class="mb-4">
        <label for="comm_time" class="form-label">Time:</label>
        <input id="comm_time" class="form-control" type="time" name="comm_time" 
        value="<?= esc(get_var('comm_time', $row->comm_time)) ?>">
    </div>
    </div>
    <div class="col-md-6">
    <div class="mb-4">
        <label for="office" class="form-label">Office:</label>
        <input id="office" class="form-control" type="text" name="office" 
        value="<?= esc(get_var('office', $row->office)) ?>">
    </div>
</div>
</div>
</div>

<script>
function setPartyType(selectedType) {
    const communityServiceFields = document.getElementById('communityServiceFields');
    if (selectedType === 'Community Service') {
        communityServiceFields.style.display = 'block'; // Show fields
    } else {
        communityServiceFields.style.display = 'none'; // Hide fields
    }
}
</script>


                    </div>

                    <div class="mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="remarks" class="form-label">Remarks</label>
                                <input id="remarks" class="form-control" type="text" value="<?= esc(get_var('remarks', $row->remarks)) ?>" name="remarks" placeholder="Remarks">
                            </div>
                        
                        
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a id="cancelButton" class="btn btn-warning text-white" href="<?= ROOT ?>/profile/<?= $row->user_id ?>">Cancel</a>


                    </div>
                </form>
            </div>
        </div>
    <?php else: ?>
        <div class="text-center">
            <h3>That complaint was not found</h3>
            <a href="<?= ROOT ?>/profile" class="btn btn-warning text-white mt-3">Back to Profile</a>
        </div>
    <?php endif; ?>
</div>

<script>
    // Wait for the DOM to load
 // Listen for the cancel button click
 const cancelButton = document.getElementById('cancelButton');
    cancelButton.addEventListener('click', function(e) {
        // Before navigating away, store the active tab as 'complaints' in sessionStorage
        sessionStorage.setItem('activeTab', 'complainant');
    });

  
    const complaintForm = document.getElementById('complaintForm');
    complaintForm.addEventListener('submit', function(e) {
        // Store the active tab 'complainant' in sessionStorage before form submission
        sessionStorage.setItem('activeTab', 'complainant');
    });


</script>



<?php $this->view('includes/footer'); ?>
