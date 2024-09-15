<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

<div class="container-fluid shadow mx-auto">
    <?php if ($row): ?>
        <div class="card">
            <div class="card-body">
                <h3 class="text-center mb-4">Update Violator Info</h3>

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
                        <input id="user_id" class="form-control" type="text" value="<?= esc(get_var('user_id', $row->user_id)) ?>" name="user_id" placeholder="User ID" hidden>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                    <div class="mb-3">
                        <label for="user_name" class="form-label">Name</label>
                        <input id="user_name" class="form-control" type="text" value="<?= esc($userName->firstname . ' ' . $userName->lastname) ?>" name="user_name" placeholder="User Name" readonly>
                    </div>
                    </div>
                    
                    <div class="col-md-6">
                    <div class="mb-3">
                        <label for="violation_id" class="form-label">Violation</label>
                        <input id="violation_id" class="form-control" type="text" value="<?= esc(get_var('violation', $violationName)) ?>" name="violation" placeholder="Violation Name" readonly>
                    </div>
                    </div>
                    </div>

                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input id="date" class="form-control" type="datetime-local" value="<?= esc(get_var('date', $row->date)) ?>" name="date" placeholder="Date" readonly>
                    </div>
                    
                    <?php 
$selectedCompensation = get_var('compensation', $row->compensation);
$communityServiceHours = isset($row->community_service_hours) ? get_var('community_service_hours', $row->community_service_hours) : '';
$suspensionDuration = isset($row->suspension_duration) ? get_var('suspension_duration', $row->suspension_duration) : '';
$manualDays = isset($row->manual_days) ? get_var('manual_days', $row->manual_days) : '';
$office = isset($office) ? $office : ''; // Default to an empty string if not set

?>

<div class="mb-3">
    <label for="compensation" class="form-label">Sanctions</label>
    
    <div class="row">
    <div class="col-md-3">
    <div class="form-check">
        <input type="radio" class="form-check-input" name="compensation" value="Community Service" id="communityService" <?= $selectedCompensation == 'Community Service' ? 'checked' : '' ?>>
        <label class="form-check-label" for="communityService">Community Service</label>
    </div>

    <div class="mb-3" id="compensationDetails" style="display: none; margin-left: 20px;">
    <div id="hoursInput">
    <label for="communityServiceHours" class="form-label">Number of Hours</label>
    <input type="number" class="form-control" id="communityServiceHours" name="duration" value="<?= esc($row->duration) ?>">
</div>
<div id="office" style="margin-top: 10px;">
    <label for="office" class="form-label">Office</label>
    <input type="text" class="form-control" id="office" name="office" value="<?= esc($row->office) ?>">
</div>
    </div>
</div>
   
    
    <div class="col-md-3">
    <div class="form-check">
        <input type="radio" class="form-check-input" name="compensation" value="Refer to Guidance" id="referToGuidance" <?= $selectedCompensation == 'Refer to Guidance' ? 'checked' : '' ?>>
        <label class="form-check-label" for="referToGuidance">Refer to Guidance</label>
    </div>
    </div>
    
    <div class="col-md-3">
    <div class="form-check">
        <input type="radio" class="form-check-input" name="compensation" value="Character Probation" id="characterProbation" <?= $selectedCompensation == 'Character Probation' ? 'checked' : '' ?>>
        <label class="form-check-label" for="characterProbation">Character Probation</label>
    </div>
    </div>
    
    <div class="col-md-3">
    <div class="form-check">
        <input type="radio" class="form-check-input" name="compensation" value="Final Character Probation" id="finalCharacterProbation" <?= $selectedCompensation == 'Final Character Probation' ? 'checked' : '' ?>>
        <label class="form-check-label" for="finalCharacterProbation">Final Character Probation</label>
    </div>
    </div>
    </div>
    
    <div class="row">
        <div class="col-md-3">
    <div class="form-check">
        <input type="radio" class="form-check-input" name="compensation" value="Suspension" id="suspension" <?= $selectedCompensation == 'Suspension' ? 'checked' : '' ?>>
        <label class="form-check-label" for="suspension">Suspension</label>
    </div>

    <!-- Suspension duration choices -->
    <div class="mb-3" id="suspensionOptions" style="display: none; margin-left: 20px;">
        <label class="form-label">Suspension Duration</label>
        
        <div class="form-check">
            <input type="radio" class="form-check-input" name="duration" value="1 Week" id="oneWeek" <?= $row->duration == '1 Week' ? 'checked' : '' ?>>
            <label class="form-check-label" for="oneWeek">1 Week</label>
        </div>
        
        <div class="form-check">
            <input type="radio" class="form-check-input" name="duration" value="2 Weeks" id="twoWeeks" <?= $row->duration == '2 Weeks' ? 'checked' : '' ?>>
            <label class="form-check-label" for="twoWeeks">2 Weeks</label>
        </div>
        
        <div class="form-check">
            <input type="radio" class="form-check-input" name="duration" value="3 Weeks" id="threeWeeks" <?= $row->duration == '3 Weeks' ? 'checked' : '' ?>>
            <label class="form-check-label" for="threeWeeks">3 Weeks</label>
        </div>
        
        <div class="form-check">
            <input type="radio" class="form-check-input" name="duration" value="Other" id="otherDuration" <?= $row->duration == 'Other' ? 'checked' : '' ?>>
            <label class="form-check-label" for="otherDuration">Other</label>
        </div>
        
        <!-- Manual days input for Other -->
        <div class="mb-3" id="manualDaysInput" style="display: none; margin-left: 20px;">
            <div class="form-check">
            <input type="number" class="form-control" id="manualDays" name="manual_days" value="<?= esc($manualDays) ?>">
            <label for="manualDays" class="form-label">Enter Number of Days</label>
        </div>
        </div>
    </div>
        </div>

        <div class="col-md-3">
    <div class="form-check">
        <input type="radio" class="form-check-input" name="compensation" value="Non Re-admission" id="nonReadmission" <?= $selectedCompensation == 'Non Re-admission' ? 'checked' : '' ?>>
        <label class="form-check-label" for="nonReadmission">Non Re-admission</label>
    </div>
        </div>

        <div class="col-md-3">
    <div class="form-check">
        <input type="radio" class="form-check-input" name="compensation" value="Exclusion" id="exclusion" <?= $selectedCompensation == 'Exclusion' ? 'checked' : '' ?>>
        <label class="form-check-label" for="exclusion">Exclusion</label>
    </div>
        </div>

        <div class="col-md-3">
    <div class="form-check">
        <input type="radio" class="form-check-input" name="compensation" value="Expulsion" id="expulsion" <?= $selectedCompensation == 'Expulsion' ? 'checked' : '' ?>>
        <label class="form-check-label" for="expulsion">Expulsion</label>
    </div>
        </div>
    </div>
</div>

<div class="row">

<div class="col-md-6">
<div class="mb-3">
                        <label for="remarks" class="form-label">Remarks</label>
                        <input id="remarks" class="form-control" type="text" value="<?= esc($row->remarks) ?>" name="remarks" placeholder="Remarks">
                    </div>
    </div>

    <div class="col-md-6">
    <div class="mb-3">
    <label for="status" class="form-label">Status</label>
    <select id="status" class="form-control" name="status" <?= !$isEditable ? 'disabled' : '' ?>>
        <option value="Unresolved" <?= esc(get_var('status', $row->status)) == 'Unresolved' ? 'selected' : '' ?>>Unresolved</option>
        <option value="Resolved" <?= esc(get_var('status', $row->status)) == 'Resolved' ? 'selected' : '' ?>>Resolved</option>
    </select>
    </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
    const communityServiceRadio = document.getElementById('communityService');
    const suspensionRadio = document.getElementById('suspension');
    const office = document.getElementById('office');
    const hoursInput = document.getElementById('hoursInput');
    const compensationDetails = document.getElementById('compensationDetails');
    const suspensionOptions = document.getElementById('suspensionOptions');
    const otherDurationRadio = document.getElementById('otherDuration');
    const manualDaysInput = document.getElementById('manualDaysInput');

    function toggleInputs() {
    if (communityServiceRadio.checked) {
        compensationDetails.style.display = 'block';
    } else {
        compensationDetails.style.display = 'none';
    }
    suspensionOptions.style.display = suspensionRadio.checked ? 'block' : 'none';
    manualDaysInput.style.display = otherDurationRadio.checked ? 'block' : 'none';
}

    // Add event listeners
    communityServiceRadio.addEventListener('change', toggleInputs);
    suspensionRadio.addEventListener('change', toggleInputs);
    document.getElementById('referToGuidance').addEventListener('change', toggleInputs);
    document.getElementById('characterProbation').addEventListener('change', toggleInputs);
    document.getElementById('finalCharacterProbation').addEventListener('change', toggleInputs);
    otherDurationRadio.addEventListener('change', toggleInputs);
    document.getElementById('oneWeek').addEventListener('change', toggleInputs);
    document.getElementById('twoWeeks').addEventListener('change', toggleInputs);
    document.getElementById('threeWeeks').addEventListener('change', toggleInputs);

    // Initial toggle based on preselected values
    if (communityServiceRadio.checked) {
        compensationDetails.style.display = 'block';
        hoursInput.style.display = 'block';
        office.style.display = 'block';
    }
    toggleInputs();
});
</script>




                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary me-2">Save</button>
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
