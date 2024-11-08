<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

<style>
    #community-service-details {
    display: none;
}
textarea {
    width: 100%;
    margin-top: 5px;
    margin-bottom: 15px; 
    padding: 5px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px; 
}
</style>

<div style="margin-left: -150px;">
<div class="row dashboard-container mx-auto" style="width: 1700px;">
    <div class="col-md-8">

<div class="mx-auto">
    <?php if ($row): ?>
        <div class="card" style="height: 820px; overflow:scroll">
            <div class="m-3">
                

                <?php if (count($errors) > 0): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Error:</strong>
                        <?php foreach ($errors as $error): ?>
                            <br><?php echo esc($error); ?>
                        <?php endforeach; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                        <center><h3 style="font-size: 20px;">Violation Details</h3></center>
                <form method="post">
                    <div class="mb-3">
                        <input id="user_id" class="form-control" type="text" value="<?= esc(get_var('user_id', $row->user_id)) ?>" name="user_id" placeholder="User ID" hidden>
                    </div>

                    <div class="row">
                    <div class="col-md-6">
  <div class="mb-3">
    <label for="user_name" class="form-label">Violator Name:</label>
    <input id="user_name" type="text" class="form-control" value="<?= htmlspecialchars($userName->firstname . ' ' . $userName->lastname) ?>" name="user_name" placeholder="User Name" style="background-color: white; border: white; font-size: 20px; font-weight: bold;" readonly>
  </div>
</div>
                    
                    <div class="col-md-6">
                    <div class="mb-3">
                        <label for="violation_id" class="form-label">Violation Committed:</label>
                        <input id="violation_id" class="form-control" type="text" value="<?= htmlspecialchars(get_var('violation', $violationName)) ?>" name="violation" placeholder="Violation Name" style="background-color: white; border: white; font-size: 20px; font-weight: bold;" readonly>
                
                       
                    </div>
                    </div>

                            
                    </div>

                    <div class="row">
                       <div class="col-md-6">
                    <div class="mb-3">
                        <label for="date" class="form-label">Date Committed:</label>
                        <input id="date" class="form-control" type="date" value="<?= htmlspecialchars(get_var('date', $row->date)) ?>" name="date" placeholder="Date" style="background-color: white; border: white; font-size: 20px; font-weight: bold;" readonly>
                    </div>
                        </div>
                    </div>


                    <hr>

                    <div class="row">

                    <div class="col-md-6">
    <div class="mb-3">
        <label for="status" class="form-label">Violation Status <b style="color: red;">*</b></label>
        <select id="status" class="form-control" style="background-color: white; border: white; font-size: 22px; font-weight: bold;" name="status" <?= !$isEditable ? 'disabled' : '' ?> required>
            <option value="Unresolved" <?= htmlspecialchars(get_var('status', $row->status)) == 'Unresolved' ? 'selected' : '' ?>>Unresolved</option>
            <option value="Resolved" <?= htmlspecialchars(get_var('status', $row->status)) == 'Resolved' ? 'selected' : '' ?>>Resolved</option>
        </select>
    </div>
</div>

<div class="col-md-6">
<div class="mb-3">
    <label for="remarks" class="form-label">Remarks</label>
    <textarea id="remarks" class="form-control" style="background-color: white; border: white; font-size: 22px; font-weight: bold;" name="remarks" placeholder="Remarks"><?= htmlspecialchars($row->remarks) ?></textarea>
</div>
    </div>

</div>
                    
                    <?php 
$selectedCompensation = get_var('compensation', $row->compensation);
$communityServiceHours = isset($row->community_service_hours) ? get_var('community_service_hours', $row->community_service_hours) : '';
$suspensionDuration = isset($row->suspension_duration) ? get_var('suspension_duration', $row->suspension_duration) : '';
$manualDays = isset($row->manual_days) ? get_var('manual_days', $row->manual_days) : '';
$office = isset($office) ? $office : ''; // Default to an empty string if not set

?>

<div class="col-md-6">
    <div class="mb-3">
        <label for="compensation" class="form-label" required>Sanction Imposed <b style="color: red;">*</b></label>
        <select id="otherSanctions" class="form-select" style="background-color: white; border: black; font-size: 22px; font-weight: bold;" name="compensation" required>
            <option value="">Select Sanction</option>
            <?php if ($showViolationSlip) { ?>
                <option value="Violation Slip" <?= $selectedCompensation == 'Violation Slip' ? 'selected' : '' ?>>Violation Slip</option>
            <?php } ?>
            <?php if ($showWarningSlip) { ?>
                <option value="Warning Slip" <?= $selectedCompensation == 'Warning Slip' ? 'selected' : '' ?>>Warning Slip</option>
            <?php } ?>
            <?php if ($showWrittenApology) { ?>
                <option value="Written Apology" <?= $selectedCompensation == 'Written Apology' ? 'selected' : '' ?>>Written Apology</option>
            <?php } ?>
            <?php if ($showConference) { ?>
                <option value="Conference with Student" <?= $selectedCompensation == 'Conference with Student' ? 'selected' : '' ?>>Conference with Student</option>
            <?php } ?>
            <?php if ($showViolationReport) { ?>
                <option value="Violation Report" <?= $selectedCompensation == 'Violation Report' ? 'selected' : '' ?>>Violation Report</option>
            <?php } ?>
            <?php if ($showCounseling) { ?>
                <option value="Counseling" <?= $selectedCompensation == 'Counseling' ? 'selected' : '' ?>>Counseling</option>
            <?php } ?>
            <?php if ($showReportPolice) { ?>
                <option value="Report to Police Authority" <?= $selectedCompensation == 'Report to Police Authority' ? 'selected' : '' ?>>Report to Police Authority</option>
            <?php } ?>
            <?php if ($showRefer) { ?>
                <option value="Refer to Guidance" <?= $selectedCompensation == 'Refer to Guidance' ? 'selected' : '' ?>>Refer to Guidance</option>
            <?php } ?>
            <?php if ($showCharacter) { ?>
                <option value="Character Probation" <?= $selectedCompensation == 'Character Probation' ? 'selected' : '' ?>>Character Probation</option>
            <?php } ?>
            <?php if ($showFinalchar) { ?>
                <option value="Final Character Probation" <?= $selectedCompensation == 'Final Character Probation' ? 'selected' : '' ?>>Final Character Probation</option>
            <?php } ?>
            <?php if ($showNonre) { ?>
                <option value="Non Re-admission" <?= $selectedCompensation == 'Non Re-admission' ? 'selected' : '' ?>>Non Re-admission</option>
            <?php } ?>
            <?php if ($showExclusion) { ?>
                <option value="Exclusion" <?= $selectedCompensation == 'Exclusion' ? 'selected' : '' ?>>Exclusion</option>
            <?php } ?>
            <?php if ($showExpulsion) { ?>
                <option value="Expulsion" <?= $selectedCompensation == 'Expulsion' ? 'selected' : '' ?>>Expulsion</option>
            <?php } ?>
            <?php if ($showCommunityService) { ?>
                <option value="Community Service" <?= $selectedCompensation == 'Community Service' ? 'selected' : '' ?>>Community Service</option>
            <?php } ?>
        </select>
    </div>
</div>



<div id="community-service-details" style="display: none;">
            <!-- Use a single row for side-by-side positioning -->
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="duration" class="form-label">Number of Hours</label>
                        <input id="duration" class="form-control rounded-pill px-3 py-2" type="number" name="duration" value="<?= $row->duration ?>">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="office" class="form-label">Office</label>
                        <select id="office" class="form-select rounded-pill px-3 py-2" name="office">
                            <option value="SAS" <?= $row->office == 'SAS' ? 'selected' : '' ?>>SAS</option>
                            <option value="Guidance" <?= $row->office == 'Guidance' ? 'selected' : '' ?>>Guidance</option>
                            <option value="Covered Court" <?= $row->office == 'Covered Court' ? 'selected' : '' ?>>Covered Court</option>
                            <option value="Prefect Office" <?= $row->office == 'Prefect Office' ? 'selected' : '' ?>>Prefect Office</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
    <div class="col-md-6">
        <div class="mb-3">
        <label for="time_start" class="form-label">Start Time:</label>
        <input type="time" name="time_start" class="form-control" value="<?= $row->time_start ?>">
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="time_end" class="form-label">End Time</label>
            <input type="time" name="time_end" class="form-control" value="<?= $row->time_end ?>">
        </div>
    </div>
            </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="comp_date" class="form-label">Completion Date</label>
            <input type="date" name="comp_date" class="form-control" value="<?= $row->comp_date ?>">
        </div>
    </div>
</div>

<div id="printContent" style="display: none;">
    <div style="text-align: center; margin-bottom: 0;">
        <img src="assets/nbsc1.png" alt="University Logo" style="width: 100px; height: 95px; margin-right: 10px; float: left;">
        <img src="assets/nbsc1.png" alt="University Logo" style="width: 100px; height: 95px; margin-right: 10px; float: right;">
        <h4 style="margin-bottom: -20px;">Republic of the Philippines</h4>
        <h4 style="margin-bottom: -20px;"><b>NORTHERN BUKIDNON STATE COLLEGE</b></h4>
        <h4 style="margin-bottom: -20px;"><i>(Formerly Northern Bukidnon Community College)</i> R.A.11284</h4>
        <h4 style="margin-bottom: -5px;"><i>Creando futura, Transformationis vitae, Ductae a Deo</i></h4>
        <hr>
    </div>
    <center><b><h4>VIOLATION SLIP</h4></b></center>
    <div class="row d-flex justify-content-between">
    <div class="col-md-6">
        <h5>Student ID No: <?= htmlspecialchars(get_var('std_id', $userName->std_id)) ?></h5>
        <h5>Date of Violation: <?= htmlspecialchars(get_var('date', $row->date)) ?></h5>
    </div>
    <div class="col-md-6">
    <h5>Year/Course: <?= htmlspecialchars(get_var('year_level', $userName->year_level . ' ' . $userName->course)) ?></h5>
    <h5>Student Name: <?= htmlspecialchars(get_var('user_name', $userName->firstname . ' ' . $userName->lastname)) ?></h5>
    <h5>Violation Name: <?= htmlspecialchars(get_var('violation', is_object($violationName) ? $violationName->violation : $violationName)) ?></h5>
    

    <div>
    <hr style="border: 1px solid #000; margin: 0; width: 180px; margin-top: 150px"/> <!-- Line above the heading -->
    <h4>Student's Signature</h4>
   <!-- Line for signature -->
</div>

<div>
<hr style="border: 1px solid #000; margin: 0; width: 180px; margin-top: 60px"/> 
    <h4>Prefect of Students</h4>
    
</div>
    
    </div>
</div>



<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $log_name = $_post['log_name'];

    log_activity($log_name);
}
?>

</div>
<div id="printViolationSlipButton" style="display: none;">
<form action="" method="POST">
<input type="hidden" name="log_name" value="Printed Good Moral Certificate">
    <button type="button" class="btn btn-secondary" onclick="printViolationSlip()">Print Violation Slip</button>
    <?= log_activity("Printed violation slip for " . $userName->firstname ) ?>
</form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sanctionsSelect = document.getElementById('otherSanctions');
        const printButton = document.getElementById('printViolationSlipButton');

        sanctionsSelect.addEventListener('change', function () {
            if (this.value === 'Violation Slip') {
                printButton.style.display = 'block';
            } else {
                printButton.style.display = 'none';
            }
        });

        // Initial toggle based on preselected values
        if (sanctionsSelect.value === 'Violation Slip') {
            printButton.style.display = 'block';
        }
    });

    function printViolationSlip() {
        // Create a new window for printing
        const printWindow = window.open('', '', 'height=500,width=800');
        printWindow.document.write('<html><head><title>Violation Slip</title>');
        printWindow.document.write('<style>body { font-family: Arial, sans-serif; }</style>');
        printWindow.document.write('</head><body>');
        printWindow.document.write(document.getElementById('printContent').innerHTML);
        printWindow.document.write('</body></html>');
        printWindow.print();
        printWindow.close();
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sanctionsSelect = document.getElementById('otherSanctions');
        const printButton = document.getElementById('printViolationSlipButton');

        sanctionsSelect.addEventListener('change', function () {
            if (this.value === 'Violation Slip') {
                printButton.style.display = 'block';
            } else {
                printButton.style.display = 'none';
            }
        });

        // Initial toggle based on preselected values
        if (sanctionsSelect.value === 'Violation Slip') {
            printButton.style.display = 'block';
        }
    });


    document.addEventListener('DOMContentLoaded', function () {
    const communityServiceSelect = document.getElementById('otherSanctions');
    const communityServiceDetailsDiv = document.getElementById('community-service-details');

    communityServiceSelect.addEventListener('change', function () {
        if (this.value === 'Community Service') {
            communityServiceDetailsDiv.style.display = 'block';
        } else {
            communityServiceDetailsDiv.style.display = 'none';
        }
    });

    // Initial toggle based on preselected values
    if (communityServiceSelect.value === 'Community Service') {
        communityServiceDetailsDiv.style.display = 'block';
    }
});
</script>

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




<center><div class="d-flex" style="width: 700px; margin-top: 100px;">
<button type="submit" class="btn btn-primary flex-fill">Save</button>
    <a href="<?= ROOT ?>/profile/<?= $row->user_id ?>" class="btn btn-warning flex-fill">Cancel</a>
</div></center>
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
    </div>

    <div class="col-md-4">
    <!-- Display user's violation statistics -->
    <div class="card mb-3" style="height: 410px;  overflow-y: auto;">
        <h5 class="card-header">Violation Statistics of <?= htmlspecialchars($userName->firstname . ' ' . $userName->lastname) ?></h5>
        <div class="card-body">
            <table class="table table-striped">
                <tr>
                    <th>No.</th>
                    <th>Violation</th>
                    <th>Total Violations</th>
                    <th>Level</th>
                    <th>Status</th>
                </tr>
                <?php if (!empty($userViolationStats)) { ?>
                    <?php $rank = 1; ?>
                    <?php foreach ($userViolationStats as $stats) { ?>
                        <tr>
                            <td><?= $rank ?></td>
                            <td><?= $stats->violation ?></td>
                            <td><?= $stats->total_violations ?></td>
                            <td><?= $stats->level ?></td>
                            <td><?= $stats->status ?></td>
                        </tr>
                        <?php $rank++; ?>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="3" class="text-center">
                            <h3>No violation statistics found.</h3>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="height: 390px; overflow-y: auto;">
  <div class="card-body">
    <h5 class="card-title text-center mb-4 fw-bold">Community Service Office Assignment Counts</h5>
    <ul class="list-group list-group-flush">
      <?php foreach ($officeCounts as $officeCount) { ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <span class="fw-bold"><?= $officeCount->office ?></span>
          <span class="badge bg-primary rounded-pill"><?= $officeCount->count ?></span>
        </li>
      <?php } ?>
    </ul>
  </div>
</div>
    </div>



    <script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const submitButton = document.querySelector('button[type="submit"]');

    submitButton.addEventListener('click', function (event) {
        event.preventDefault(); // Prevent the form from submitting immediately

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to save the changes?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, save it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // Submit the form if the user confirms
            }
        });
    });
});
</script>



<?php $this->view('includes/footer'); ?>
