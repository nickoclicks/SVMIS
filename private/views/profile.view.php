<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>


<?php
// Define ang variable para sa selected purpose sa certificate
$selectedPurpose = isset($selectedPurpose) ? $selectedPurpose : '[Please select a purpose]';

// Kuhaon ang date nga data para sa format nga Day, month, and year Ex: 24th of March 2024
$currentDate = date('jS') . ' day of ' . date('F Y');


?>
<div class="dashboard-container p-2 shadow mx-auto" style="max-width: 1100px; background-color: #f9f9f9; border-radius: 15px;">
    <i class="fa fa-edit" style="float: inline-end;"></i>
    <?php if ($row): ?>
        <div class="row">
            <div class="col-md-3 text-center">
                <?php
                $image = $row->image;
                if (!file_exists($image)) {
                    $image = ($row->gender == 'male') ? ROOT . '/assets/male.png' : ROOT . '/assets/female.png';
                }
                ?>
                <img src="<?php echo $image; ?>" class="border border-primary rounded-circle img-thumbnail" style="width: 100px; height: 100px; object-fit: cover; margin-bottom: 15px;">
                
                <?php
$allViolationsResolved = true;
if (is_array($violations_committed) || is_object($violations_committed)) {
    foreach ($violations_committed as $violation) {
        if ($violation->status != 'Resolved') {
            $allViolationsResolved = false;
            break;
        }
    }
}

$allNoticesResolved = true;
if (is_array($noticesAsRespondent) || is_object($noticesAsRespondent)) {
    foreach ($noticesAsRespondent as $notice) {
        if ($notice->status != 'Resolved') {
            $allNoticesResolved = false;
            break;
        }
    }
}
?>



<!-- Add this indicator div -->
<center><div class="indicator <?= ($allViolationsResolved && $allNoticesResolved) ? 'green' : 'red' ?>">
    <?= ($allViolationsResolved && $allNoticesResolved) ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>' ?>
</div></center>
<!-- Add CSS styles for the indicator -->
<style>
      .indicator {
        width: 80px;
        height: 25px;
        border-radius: 5%;
        margin-top: -10px;
        background-color: <?= ($allViolationsResolved && $allNoticesResolved) ? 'green' : 'red' ?>;
        /* Add a gradient effect to give it a premium look */
        background-image: linear-gradient(to bottom, <?= ($allViolationsResolved && $allNoticesResolved) ? 'green' : 'red' ?> 50%, <?= ($allViolationsResolved && $allNoticesResolved) ? 'darkgreen' : 'darkred' ?> 100%);
        /* Add a subtle shadow to give it depth */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        /* Add a slight glow effect to make it stand out */
        border: 1px solid <?= ($allViolationsResolved && $allNoticesResolved) ? 'lightgreen' : 'lightred' ?>;
        /* Add a modern font to display the status (optional) */
        font-family: Arial, sans-serif;
        font-size: 14px;
        font-weight: bold;
        text-align: center;
        color: #fff;
        padding: 4px;
    }
</style>
                <h4 class="text-center" style="font-weight: 700;"><?php echo esc($row->firstname . ' ' . $row->lastname); ?></h4>
                <h6 class="text-center text-muted"><?php echo esc($row->year_level . '  year ' . $row->course); ?></h6>
                <h6 class="text-center text-muted"><?php echo esc($row->std_id); ?></h6>
            </div>
            
            <div class="col-md-9 bg-light p-4" style="border-radius: 10px;">
                <h4 class="" style="font-weight: 600; color: #34495e; font-size: 18px">Personal Information</h4>
                <table class="table table-bordered table-striped table-hover">
                    <tr>
                        <th style="color: black;">First Name:</th>
                        <td><?php echo esc($row->firstname); ?></td>
                        <th style="color: black;">Middle Name:</th>
                        <td><?php echo esc($row->lastname); ?></td>
                        <th style="color: black;">Last Name:</th>
                        <td><?php echo esc($row->lastname); ?></td>
                    </tr>
                    <tr>
                        <th style="color: black;">Sex:</th>
                        <td><?php echo esc(ucfirst($row->gender)); ?></td>
                        <th style="color: black;">Email:</th>
                        <td><?php echo esc($row->email); ?></td>
                        <th style="color: black;">Phone:</th>
                        <td><?php echo esc($row->phone); ?></td>
                    </tr>
                </table>

            
                <h4 class="" style="font-weight: 600; color: #34495e; font-size: 18px">Address</h4>
                <table class="table table-bordered table-striped table-hover">
                    <tr>
                        <th style="color: black;">Street:</th>
                        <td><?php echo esc($row->street); ?></td>
                        <th style="color: black;">Barangay:</th>
                        <td><?php echo esc($row->barangay); ?></td>
                    </tr>
                    <tr>
                        <th style="color: black;">City:</th>
                        <td><?php echo esc($row->city); ?></td>
                        <th style="color: black;">Municipality:</th>
                        <td><?php echo esc($row->municipality); ?></td>
                    </tr>
                </table>
            </div>
            </div>

            
        

        <hr class="my-4">

        <!---------------Table para sa committed violations------>
        <div class="container mt-5">

    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="violations-tab" data-bs-toggle="tab" href="#violations" role="tab">Violations Committed</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="complainant-tab" data-bs-toggle="tab" href="#complainant" role="tab">Complaints</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="respondent-tab" data-bs-toggle="tab" href="#respondent" role="tab">Notices</a>
        </li>
    </ul>

    <!-- Tabs Content -->
    <div class="tab-content mt-3" id="myTabContent">
        

        <!-- Violations Tab -->
        <div class="tab-pane fade show active" id="violations" role="tabpanel" aria-labelledby="violations-tab">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 style="font-weight: 600; color: #34495e;">Violations Committed</h4>
        <?php if (Auth::canPerformAction()): ?>
            <a href="<?= ROOT ?>/violations/list?user_id=<?= $row->id ?>" class="btn btn-primary btn-sm shadow">
                <i class="fa fa-plus"></i> Add Violation
            </a>
        <?php endif; ?>
    </div>
    <table class="table table-hover table-striped table-bordered">
                <thead class="bg-dark text-white">
                    <tr>
                        <th>Violation</th>
                        <th>Date Committed</th>
                        <th>Status</th>
                        <?php if (Auth::canPerformAction()): ?>
                        <th>Actions</th>
                        <?php endif ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($violations_committed) && !empty($violations_committed)): ?>
                        <?php foreach ($violations_committed as $violation): ?>
                            <tr class="violation-row">
                                <td><?php echo esc($violation->violation); ?></td>
                                <td><?php echo get_date($violation->date); ?></td>
                                <td><?php echo esc($violation->status); ?></td>
                                <?php if (Auth::canPerformAction()): ?>
                                <td>
                                    <a href="<?= ROOT ?>/violator/edit/<?= $violation->id ?>" class="btn btn-sm btn-info text-white">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">No violations committed.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php
$allViolationsResolved = true;
if (is_array($violations_committed) || is_object($violations_committed)) {
    foreach ($violations_committed as $violation) {
        if ($violation->status != 'resolved') {
            $allViolationsResolved = false;
            break;
        }
    }
}
?>

        <!-- Complaints tab -->
        <div class="tab-pane fade" id="complainant" role="tabpanel" aria-labelledby="complainant-tab">
            <div class="d-flex justify-content-between align-items-center mb-3">

            <?php if (Auth::canPerformAction()): ?>
                <h4 style="font-weight: 600; color: #34495e;">Complaints</h4>
                <a href="<?= ROOT ?>/forms?user_id=<?= $row->user_id ?>" class="btn btn-primary btn-sm shadow">
                    <i class="fa fa-plus"></i> Add Complaint
                </a>
                <?php endif; ?>

            </div>
            <table class="table table-hover table-striped table-bordered">
                <thead class="bg-dark text-white">
                    <tr>
                        <th>Complaint Name</th>
                        <th>Respondent</th>
                        <th>Date Filed</th>
                        <th>Status</th>
                        <?php if (Auth::canPerformAction()): ?>
                        <th>Actions</th>
                        <?php endif ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($noticesAsComplainant)): ?>
                        <?php foreach ($noticesAsComplainant as $notice): ?>
                            <tr>
                                <td><?= esc($notice->complaint) ?></td>
                                <td><?= esc($notice->resp_name) ?></td>
                                <td><?= get_date($notice->date) ?></td>
                                <td><?= esc($notice->status) ?></td>
                                <?php if (Auth::canPerformAction()): ?>
                                <td>
                                    <a href="<?= ROOT ?>/forms/edit/<?= $notice->id ?>" class="btn btn-sm btn-info text-white">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                                <?php endif ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">No notices found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Notices tab -->
        <div class="tab-pane fade" id="respondent" role="tabpanel" aria-labelledby="respondent-tab">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 style="font-weight: 600; color: #34495e;">Notices</h4>
            </div>
            <table class="table table-hover table-striped table-bordered">
                <thead class="bg-dark text-white">
                    <tr>
                        <th>Complaint Name</th>
                        <th>Complainant</th>
                        <th>Status</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($noticesAsRespondent)): ?>
                        <?php foreach ($noticesAsRespondent as $notice): ?>
                            <tr>
                                <td><?= esc($notice->complaint) ?></td>
                                <td><?= ucwords(str_replace('.',' ',esc($notice->user_id))) ?></td> <!-- Adjust as needed -->
                                <td><?= esc($notice->status) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">No notices found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>




        <hr class="my-4">
        <?php if (Auth::canPerformAction()): ?>
        <div class="text-center">
            <button class="btn btn-info btn-sm shadow" onclick="selectCertificate()" style="background-color: gray; height: 50px; width: 70px">
                <i class="fa fa-print"></i>
            </button>
        </div>
        <?php endif ?>

        <!-- Modal for certificate selection -->
<div id="certificateModal" style="display: none; text-align: center;">
    <p>Please select which certificate to print:</p>
    <button onclick="showCertificate('firstCertificate')">Undergraduate</button>
    <button onclick="showCertificate('secondCertificate')">Graduate</button>
</div>

<!-- First Certificate Section -->
<div id="firstCertificate" class="certificate">
    <div class="certificate-header" style="text-align: center;">
        <div style="display: flex; align-items: center; justify-content: center; gap: 10px;">
            
            <div>
                <h5 style="margin: 0;">Republic of the Philippines</h5>
                <h4 style="font-weight: bold; margin: 0;">NORTHERN BUKIDNON STATE COLLEGE</h4>
                <p style="margin: 0;">(Formerly Northern Bukidnon Community College)</p>
                <p style="margin: 0;">Manolo Fortich, 8703 Bukidnon</p>
                <p style="margin: 0;"><i>Creando futura, Transformationis vitae, Ductae a Deo</i></p>
            </div>
        </div>
        <hr>
    </div>

    <div class="content" style="text-align: center;">
        <h4 style="margin: 0;">Office of the Prefect of Students</h4>
        <br>
        <h3 style="margin: 0;">CERTIFICATION</h3>
        <br>
    </div>

    <div class="content" style="text-align: justify;">
        <p style="font-size: 20px;">TO WHOM IT MAY CONCERN:</p>
        <p style="font-size: 20px;">
            This is to certify that <?php echo esc($row->firstname . ' ' . $row->lastname); ?>, a <?php echo esc($row->year_level);?> year student from this institution under the <?php echo esc($row->course); ?> program, has consistently shown good moral conduct and character and complied and adhered to the rules and regulations set forth while in attendance in this institution.
        </p>
        <p style="font-size: 20px;">
            This certification is issued upon request of the above mentioned student for <span id="selected-purpose"><?php echo esc($selectedPurpose); ?></span> purposes.
        </p>
        <p style="font-size: 20px;">
            Given this <?php echo $currentDate; ?> at Northern Bukidnon State College, Kihare, Tankulan, Manolo Fortich, Bukidnon, Mindanao, Philippines.
        </p>
    </div>

    <div class="footer" style="text-align: end; position: relative; height: 150px;">
        <p style="display: inline-block; border-bottom: 1px solid black; width: 200px; margin-bottom: 0;">&nbsp;</p>
        <p style="margin-right: 25px;">Prefect of Discipline</p>
    </div>

    <div class="footer" style="text-align: start; position: relative; height: 150px;">
        <p style="margin-left: 40px;">Not Valid Without</p>
        <p style="margin-top: -20px; font-size: 20px;">OFFICIAL COLLEGE SEAL</p>
    </div>

    <div class="text-center mt-4">
        <button class="btn btn-primary" onclick="printCertificate()">Print Certificate</button>
    </div>

    <!-- Purpose Dropdown -->
    <div class="mt-4">
        <label id="label" for="purposeDropdown" style="font-weight: 600;">Select Purpose:</label>
        <select id="purposeDropdown" class="form-control" onchange="updatePurpose()">
            <option value="">Please select a purpose</option>
            <option value="scholarship">Legal</option>
            <option value="job application">Employment</option>
            <option value="immigration">Local Internship</option>
            <option value="immigration">On-the-job Training</option>
            <option value="immigration">Life Bank Scholarship</option>
            <option value="other">Other</option>
        </select>
        <div id="customPurposeInput" style="display: none; margin-top: 10px;">
            <label for="customPurpose" style="font-weight: 600;">Specify:</label>
            <input type="text" id="customPurpose" class="form-control" placeholder="Enter purpose">
        </div>
    </div>
</div>

<!-- Second Certificate Section -->
<div id="secondCertificate" class="certificate">
    <div class="certificate-header" style="text-align: center;">
        <div style="display: flex; align-items: center; justify-content: center; gap: 10px;">
            <div>
                <h5 style="margin: 0;">Republic of the Philippines</h5>
                <h4 style="font-weight: bold; margin: 0;">NORTHERN BUKIDNON STATE COLLEGE</h4>
                <p style="margin: 0;">(Formerly Northern Bukidnon Community College)</p>
                <p style="margin: 0;">Manolo Fortich, 8703 Bukidnon</p>
                <p style="margin: 0;"><i>Creando futura, Transformationis vitae, Ductae a Deo</i></p>
            </div>
        </div>
        <hr>
    </div>

    <div class="content" style="text-align: center;">
        <h4 style="margin: 0;">Office of the Prefect of Students</h4>
        <br>
        <h3 style="margin: 0;">CERTIFICATION</h3>
        <br>
    </div>

    <div class="content" style="text-align: justify;">
        <p style="font-size: 20px;">TO WHOM IT MAY CONCERN:</p>
        <p style="font-size: 20px;">
            This is to certify that <?php echo esc($row->firstname . ' ' . $row->lastname); ?>, a graduate of <span id="selected-purpose"><?php echo esc($selectedPurpose); ?></span> of this institution, has consistently shown good moral conduct and character and complied and adhered to the rules and regulations set forth while in attendance in this institution.
        </p>
        <p style="font-size: 20px;">
            This certification is issued upon request of the above mentioned student for legal purposes.
        </p>
        <p style="font-size: 20px;">
            Given this <?php echo $currentDate; ?> at Northern Bukidnon State College, Kihare, Tankulan, Manolo Fortich, Bukidnon, Mindanao, Philippines.
        </p>
    </div>

    <div class="footer" style="text-align: end; position: relative; height: 150px;">
        <p style="display: inline-block; border-bottom: 1px solid black; width: 200px; margin-bottom: 0;">&nbsp;</p>
        <p style="margin-right: 25px;">Prefect of Discipline</p>
    </div>

    <div class="footer" style="text-align: start; position: relative; height: 150px;">
        <p style="margin-left: 40px;">Not Valid Without</p>
        <p style="margin-top: -20px; font-size: 20px;">OFFICIAL COLLEGE SEAL</p>
    </div>

    <div class="text-center mt-4">
        <button class="btn btn-primary" onclick="printCertificate()">Print Certificate</button>
    </div>

    <!-- Purpose Dropdown -->
    <!-- Purpose Dropdown for Second Certificate -->
<div class="mt-4">
    <label id="label" for="purposeDropdownone" style="font-weight: 600;">Select Course:</label>
    <select id="purposeDropdownone" class="form-control" onchange="updatePurposes()">
        <option value="">Please select a course</option>
        <option value="scholarship">Bachelor of Science in Information Technology</option>
        <option value="job application">Teacher Education Program</option>
        <option value="immigration">Bachelor of Science in Business Administration</option>
        <option value="other">Other</option>
    </select>

    <!-- Custom Purpose Input for Second Certificate -->
    <div id="customPurposeInputSecond" style="display: none; margin-top: 10px;">
        <label for="customPurposeSecond" style="font-weight: 600;">Specify:</label>
        <input type="text" id="customPurposeSecond" class="form-control" placeholder="Enter purpose">
    </div>
</div>

</div>







        <!-- Purpose Dropdown 
        <div class="mt-4">
    <label for="purpose" class="font-weight-bold">Select purpose:</label>
    <select id="purpose" onchange="updatePurpose()" class="form-control form-control-lg">
        <option value="" disabled selected>Select purpose</option>
        <option value="Legal">Legal</option>
        <option value="Employment">Employment</option>
        <option value="Local Internship">Local Internship</option>
        <option value="On Job Training">On Job Training</option>
        <option value="Others">Others</option>
    </select>
    
    <!-- Custom Purpose Input Field for 'Others' 
    <div id="other-purpose-div" class="mt-3" style="display: none;">
        <label for="other-purpose" class="font-weight-bold">Please specify:</label>
        <input type="text" id="other-purpose" class="form-control form-control-lg" oninput="updatePurpose()">
    </div>
</div>-->

    <?php else: ?>
        <div class="text-center">
            <h3>Sorry, that profile was not found!</h3>
        </div>
    <?php endif; ?>
</div>

<script>

document.addEventListener('DOMContentLoaded', function() {
        updatePurpose();  // To handle any pre-set dropdown value
    });

    function printCertificate() {
    // Find the currently visible certificate
    const visibleCertificate = document.querySelector('.certificate.show').innerHTML;

    const printWindow = window.open('', '', 'height=600,width=800');
    printWindow.document.write('<html><head><title>Print Certificate</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: Arial, sans-serif; margin: 20px; }');
    printWindow.document.write('button, #label, #purposeDropdown, #purposeDropdownone, #customPurposeInput { display: none; }');
    printWindow.document.write('</style></head><body>');
    printWindow.document.write(visibleCertificate);
    printWindow.document.write('</body></html>');

    printWindow.document.close();
    printWindow.onload = function() {
        printWindow.focus();
        printWindow.print();
    };
}





function selectCertificate() {
        document.getElementById('certificateModal').style.display = 'block';
    }

  /*  function updatePurpose() {
    // Get selected purpose from the dropdown
    const purposeDropdown = document.getElementById('purposeDropdown');
    const selectedPurpose = purposeDropdown.options[purposeDropdown.selectedIndex].text;

    // Update the purpose span in both certificates
    document.getElementById('firstCertificate').querySelector('#selected-purpose').textContent = selectedPurpose;
    document.getElementById('secondCertificate').querySelector('#selected-purpose').textContent = selectedPurpose;

    // Show custom input if 'Other' is selected
    const customPurposeInput = document.getElementById('customPurposeInput');
    if (purposeDropdown.value === 'other') {
        customPurposeInput.style.display = 'block';
    } else {
        customPurposeInput.style.display = 'none';
    }
}*/

function updatePurpose() {
    const purposeDropdown = document.getElementById('purposeDropdown');
    const selectedPurpose = purposeDropdown.options[purposeDropdown.selectedIndex].text;
    const customPurposeInput = document.getElementById('customPurposeInput');
    
    // Handle 'Other' option for the first certificate
    if (purposeDropdown.value === 'other') {
        customPurposeInput.style.display = 'block';  // Show the custom purpose input
        const customPurpose = document.getElementById('customPurpose').value;
        if (customPurpose) {
            document.getElementById('firstCertificate').querySelector('#selected-purpose').textContent = customPurpose;
        }
    } else {
        customPurposeInput.style.display = 'none';  // Hide the custom purpose input
        document.getElementById('firstCertificate').querySelector('#selected-purpose').textContent = selectedPurpose;
    }
}

function updatePurposes() {
    // Get the selected course from the second dropdown
    const purposeDropdownOne = document.getElementById('purposeDropdownone');
    const selectedOption = purposeDropdownOne.options[purposeDropdownOne.selectedIndex].value;

    // Show custom input if 'Other' is selected for the second certificate
    const customPurposeInputSecond = document.getElementById('customPurposeInputSecond');
    
    if (selectedOption === 'other') {
        customPurposeInputSecond.style.display = 'block';  // Show the custom input field

        // Update the certificate when typing in the custom input field
        document.getElementById('customPurposeSecond').addEventListener('input', function() {
            const customText = this.value;
            document.getElementById('secondCertificate').querySelector('#selected-purpose').textContent = customText;
        });
    } else {
        customPurposeInputSecond.style.display = 'none';  // Hide the custom input field

        // Update the certificate with the selected dropdown option
        document.getElementById('secondCertificate').querySelector('#selected-purpose').textContent = purposeDropdownOne.options[purposeDropdownOne.selectedIndex].text;
    }
}


// Dynamically update the custom purpose in both certificates when user types in the custom input field
document.getElementById('customPurpose').addEventListener('input', function() {
    const customPurpose = document.getElementById('customPurpose').value;

    // Update custom purpose in both certificates
    document.getElementById('firstCertificate').querySelector('#selected-purpose').textContent = customPurpose;
    document.getElementById('secondCertificate').querySelector('#selected-purpose').textContent = customPurpose;
});

document.addEventListener('DOMContentLoaded', function() {
    updatePurpose();    // Initialize first certificate
    updatePurposes();   // Initialize second certificate
});



function showCertificate(certificateId) {
    // Hide all certificates
    const certificates = document.querySelectorAll('.certificate');
    certificates.forEach(cert => cert.classList.remove('show'));

    // Show the selected certificate
    document.getElementById(certificateId).classList.add('show');

    // Hide the modal if you are using a modal to select certificates
    document.getElementById('certificateModal').style.display = 'none';
}



</script>
<?php $this->view('includes/footer'); ?>
