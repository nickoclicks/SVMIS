<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

<style>
    body {
  font-family: 'Open Sans', sans-serif;
}
h4 {
  font-size: 23px;
  font-weight: 700;
}
h5 {
        font-size: 22px;
        font-weight: bold;
    }

    .table td, .table th {
        font-size: 16px;
        font-weight: 400;
    }

    .table td, .table th {
        line-height: 1.5;
        padding: 0.5rem;
    }


h6 {
  font-size: 16px;
  font-weight: 400;
}

td, th {
  font-size: 16px;
  font-weight: 400;
  line-height: 1.5;
}

.badge {
  font-size: 16px;
  font-weight: 700;
}
.btn-outline-success:hover {
    background-color: rgba(40, 167, 69, 0.1); /* Light green background on hover */
}
</style>

<?php
// Define ang variable para sa selected purpose sa certificate
$selectedPurpose = isset($selectedPurpose) ? $selectedPurpose : '[Please select a purpose]';

// Kuhaon ang date nga data para sa format nga Day, month, and year Ex: 24th of March 2024
$currentDate = date('jS') . ' day of ' . date('F Y');


?>
<div style="margin-left: -150px;">
<div class="dashboard-container p-4 mx-auto" style="max-width: 1700px; margin-top: -10px">

<?php if ($row): ?>
    <div class="row justify-content-center">
        <div class="card col-md-3 text-center shadow-sm" style="border-radius: 15px; padding: 20px; margin-right: 20px;">
        <?php
                    $image = $row->image;
                    switch ($row->course) {
                        case 'BSBA':
                            $image = ROOT . '/assets/BSBA.png';
                            break;
                        case 'TEP':
                            $image = ROOT . '/assets/TEP.png';
                            break;
                        case 'BSIT':
                            $image = ROOT . '/assets/BSIT.png';
                            break;
                        case "N/A":
                            $image = ROOT . '/assets/nbsc1.png';
                            break;
                        default:
                            $image = $row->image;
                            break;
                    }
                    ?>
            <img src="<?php echo $image; ?>" class="border border-primary rounded-circle img-thumbnail mx-auto" style="width: 120px; height: 120px; object-fit: cover; margin-bottom: 20px; margin-top: 40px">

            <!-- Status Indicator -->
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

            $unresolvedViolationsCount = 0;
            if (is_array($violations_committed) || is_object($violations_committed)) {
                foreach ($violations_committed as $violation) {
                    if ($violation->status !== 'Resolved') {
                        $unresolvedViolationsCount++;
                    }
                }
            }
            
            // Calculate the number of unresolved notices received
            $unresolvedNoticesCount = 0;
            if (is_array($noticesAsRespondent) || is_object($noticesAsRespondent)) {
                foreach ($noticesAsRespondent as $notice) {
                    if ($notice->status != 'Settled amicably' && $notice->status != 'Resolved' && $notice->status != 'Referred to SDC' && $notice->status != 'Dismissed') {
                        $unresolvedNoticesCount++;
                    }
                    
                }
            }
            ?>

<div class="indicator-container">
<div class="row" style="margin-top: -10px; margin-right: 5px">
<div class="indicator-container">
    <div class="indicator violation-indicator <?= ($unresolvedViolationsCount === 0) ? 'indicator-green' : 'indicator-red' ?>">
        <i class="fa fa-exclamation-circle"></i>
        <span class="indicator-count"><?= ($unresolvedViolationsCount === 0) ? '<i class="fa fa-check"></i>' : $unresolvedViolationsCount ?></span>
    </div>
    <div class="indicator notice-indicator <?= ($unresolvedNoticesCount === 0) ? 'indicator-green' : 'indicator-red' ?>">
        <i class="fa fa-bell"></i>
        <span class="indicator-count"><?= ($unresolvedNoticesCount === 0) ? '<i class="fa fa-check"></i>' : $unresolvedNoticesCount ?></span>
    </div>
</div>
</div>
</div>

            

            <!-- CSS for Status Indicator -->
            <style>
                .indicator {
    display: inline-flex;
    align-items: center;
    padding: 5px 10px;
    border-radius: 10px;
    font-size: 16px;
}

.indicator i {
    margin-right: 5px;
    font-size: 18px;
}

.indicator-count {
    font-weight: bold;
    font-size: 18px;
}

.indicator-red {
    background-color: #ff7e5f;
    color: #fff;
}

.indicator-green {
    background-color: #4CAF50;
    color: #fff;
}
.indicator-container {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 5px;
    margin-left: 8px;
}
.badge {
        font-size: 15px;
        font-weight: bold;
        padding: 0.2rem 0.5rem;
        border-radius: 0.2rem;
    }
            </style>

            <h4 class="text-center" style="font-weight: 700;"><?php echo esc($row->firstname . ' ' . $row->lastname); ?></h4>
            <h6 class="text-center text-muted"><?php echo esc(formatYearLevel($row->year_level_id)); ?>  Year <?php echo esc($row->course); ?></h6>
            <h6 class="text-center text-muted"><?php echo esc($row->std_id); ?></h6>
        </div>

        <div class="card col-md-8 shadow-sm p-4" style="border-radius: 15px;">
            <div class="row mb-3">
                <div class="col-md-6">
                    <h4 class="mb-0" style="font-weight: 600; color: #2c3e50;">Personal Information</h4>
                </div>
                <div class="col-md-6 text-end">
                    <?php if (Auth::canPerformAction()): ?>
                        <a href="<?= ROOT ?>/users/edit/<?= $row->id ?>" class="btn">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <table class="table table-bordered table-hover">
                <tbody>
                    <tr>
                        <th style="font-weight: bold">First Name:</th>
                        <td><?php echo esc($row->firstname); ?></td>
                        <th style="font-weight: bold">Middle Name:</th>
                        <td><?php echo esc($row->middlename); ?></td>
                        <th style="font-weight: bold">Last Name:</th>
                        <td><?php echo esc($row->lastname); ?></td>
                    </tr>
                    <tr>
                        <th style="font-weight: bold"">Sex:</th>
                        <td><?php echo esc(ucfirst($row->gender)); ?></td>
                        <th style="font-weight: bold">Email:</th>
                        <td><?php echo esc($row->email); ?></td>
                        <th style="color: #2c3e50;">Phone:</th>
                        <td><?php echo esc($row->phone); ?></td>
                    </tr>
                </tbody>
            </table>

            <h4 class="mt-4" style="font-weight: 600; color: #2c3e50;">Address</h4>
            <table class="table table-bordered table-hover">
                <tbody>
                    <tr>
                        <th style="font-weight: bold">Street:</th>
                        <td><?php echo esc($row->street); ?></td>
                        <th style="font-weight: bold">Barangay:</th>
                        <td><?php echo esc($row->barangay); ?></td>
                    </tr>
                    <tr>
                        <th style="font-weight: bold">City:</th>
                        <td><?php echo esc($row->city); ?></td>
                        <th style="font-weight: bold">Municipality:</th>
                        <td><?php echo esc($row->municipality); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>



            
        

        

        <!---------------Table para sa committed violations------>
        <div class="card mt-3" style="max-width: 1520px; padding: 10px; margin-left: 60px">

    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link text-reset fw-bold active" id="violations-tab" data-bs-toggle="tab" href="#violations" role="tab">Violations Committed</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link text-reset fw-bold" id="complainant-tab" data-bs-toggle="tab" href="#complainant" role="tab">Complaints Filed</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link text-reset fw-bold" id="respondent-tab" data-bs-toggle="tab" href="#respondent" role="tab">Notices Recieved</a>
        </li>
    </ul>

    <!-- Tabs Content -->
    <div class="tab-content mt-3" id="myTabContent">
        

<!-- Violations Tab -->
<div class="tab-pane fade show active" id="violations" role="tabpanel" aria-labelledby="violations-tab">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="input-group mb-3" style="width: 300px;">
            <button class="btn btn-outline-secondary" type="button" id="search-violations-btn">
                <i class="fa fa-search"></i>
            </button>
            <input type="text" class="form-control border-secondary" id="search-violations" placeholder="Search Violations..." oninput="searchViolations()">
        </div>
        <?php if (Auth::canPerformAction()): ?>
            <a href="<?= ROOT ?>/violations/list?user_id=<?= $row->id ?>" class="btn btn-sm text-black fs-sm">
                <i class="fa fa-plus"></i> Add Violation
            </a>
        <?php endif; ?>
    </div>
    <div style="max-height: 200px; overflow-y: auto;"> <!-- Set a fixed height and enable vertical scrolling -->
        <table class="table table-hover table-striped table-bordered">
            <thead class="bg-dark text-white">
                <tr>
                    <th class="text-light">No.</th>
                    <th class="text-light">Violation</th>
                    <th class="text-light">Date Committed</th>
                    <th class="text-light">Status</th>
                    <th class="text-light">Level</th>
                    <th class="text-light">Category</th>
                    
                    <!--<th class="text-light">Possible Sanction</th>-->
                    <th class="text-light">Sanction Imposed</th>
                    <th class="text-light">Year Level</th>
                    <th class="text-light">Semester</th>
                    <th class="text-light">School Year</th>
                    <?php if (Auth::canPerformAction()): ?>
                    <th class="text-light">Actions</th>
                    <?php endif ?>
                </tr>
            </thead>

            
            <tbody id="violations-table-body">
                <?php if (isset($violations_committed) && !empty($violations_committed)): ?>
                    <?php $i = 1; ?>
                    <?php foreach ($violations_committed as $violation): ?>
                        <tr class="violation-row" data-violation="<?= esc($violation->violation); ?>">
                            <td><?= $i++; ?></td>
                            
                            <td ><?= esc($violation->violation); ?></td>
                            <td><?= get_date($violation->date); ?></td>
                            <td><?= esc($violation->status); ?></td>
                            <td>
    <span <?= ($violation->level == 'Major') ? 'class="badge bg-danger"' : 'class="badge bg-warning"' ?>>
        <i class="fa fa-tag"></i> <?= $violation->level ?>
    </span>
                            <td><?= esc($violation->category); ?></td>
                           
                       
                            <td><?= !empty($violation->compensation) ? esc($violation->compensation) : 'N/A'; ?></td>
                            <td><?= esc($violation->year_level); ?></td>
                            <td><?= esc($violation->semester_name); ?></td>
                            <td><?= esc($violation->school_year); ?></td>
                            <?php if (Auth::canPerformAction()): ?>
                            <td>
                                <a href="<?= ROOT ?>/violator/edit/<?= $violation->id ?>" class="btn btn-outline-success btn-sm">
                                    <i class="fa fa-edit fa-lg text-successs"></i>
                                </a>
                            </td>
                            <?php endif ?>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr id="no-violation-found">
                        <td colspan="12" class="text-center">No violation found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


<script>
    function searchViolations() {
        const searchInput = document.getElementById('search-violations');
        const searchValue = searchInput.value.trim().toLowerCase();
        const tableBody = document.getElementById('violations-table-body');
        const rows = tableBody.rows;
        const noViolationFoundRow = document.getElementById('no-violation-found');

        let found = false;

        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            const cells = row.cells;

            for (let j = 0; j < cells.length; j++) {
                const cell = cells[j];
                const cellText = cell.textContent.toLowerCase();

                if (cellText.includes(searchValue)) {
                    found = true;
                    break;
                }
            }

            if (found) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }

        if (searchValue === '') {
            if (rows.length === 0) {
                noViolationFoundRow.style.display = '';
            } else {
                noViolationFoundRow.style.display = 'none';
            }
        } else {
            if (found) {
                noViolationFoundRow.style.display = 'none';
            } else {
                noViolationFoundRow.style.display = '';
            }
        }
    }
</script>
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
        <div class="input-group mb-3" style="width: 300px;">
            <button class="btn btn-outline-secondary" type="button" id="search-complaints-btn">
                <i class="fa fa-search"></i>
            </button>
            <input type="text" class="form-control" id="search-complaints" placeholder="Search Complaints..." oninput="searchComplaints()">
        </div>
        <?php if (Auth::canPerformAction()): ?>
            <a href="<?= ROOT ?>/forms?user_id=<?= $row->user_id ?>" class="btn btn-sm text-black fs-sm">
                <i class="fa fa-plus"></i> Add Complaint
            </a>
        <?php endif; ?>
    </div>
    <div style="max-height: 200px; overflow-y: auto;"> <!-- Added overflow styling -->
        <table class="table table-hover table-striped table-bordered">
            <thead class="bg-dark text-white">
                <tr>
                    <th class="text-light">No.</th>
                    <th class="text-light">Complaint Name</th>
                    <th class="text-light">Respondent ID</th>
                    <th class="text-light">Respondent</th>
                    <th class="text-light">Violation</th>
                    <th class="text-light">Date Filed</th>
                    <th class="text-light">Appointment Date</th>
                    <th class="text-light">Status</th>
                    <?php if (Auth::canPerformAction()): ?>
                    <th class="text-light">Actions</th>
                    <?php endif ?>
                </tr>
            </thead>
            <tbody id="complaints-table-body">
                <?php if (isset($noticesAsComplainant) && !empty($noticesAsComplainant)): ?>
                    <?php $i = 1; ?>
                    <?php foreach ($noticesAsComplainant as $notice): ?>
                        <tr class="complaint-row" data-complaint="<?= esc($notice->complaint); ?>">
                            <td><?= $i++; ?></td>
                            <td><?php echo esc($notice->complaint); ?></td>
                            <td><?php echo esc($notice->resp_id); ?></td>
                            <td>
                                <?php
                                $respNameForLink = str_replace(' ', '.', $notice->resp_name); 
                                ?>
                               <?php if (Auth::isAdmin()): ?>
                                <a href="<?= ROOT ?>/profile/<?= urlencode($respNameForLink) ?> #respondent" class="text-reset text-decoration-none">
                                <?php endif ?>
                                    <?= htmlspecialchars($notice->resp_name) ?>
                                </a>
                            </td>
                            <td><?php echo esc($notice->violations); ?></td>
                            <td><?= get_date($notice->date); ?></td>
                            <td><?= get_date($notice->appt_date); ?></td>
                            <td><?php echo esc($notice->status); ?></td>
                            <?php if (Auth::canPerformAction()): ?>
                            <td>
                                <a href="<?= ROOT ?>/forms/edit/<?= $notice->id ?>" class="btn btn-sm btn-info text-white">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <!--
                                <button class="btn btn-sm btn-primary" onclick="printComplaint(this)"> 
                        <i class="fa fa-print"></i> Print 
                    </button>-->
                               </td>                           
                            <?php endif ?>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr id="no-complaint-found">
                        <td colspan="7" class="text-center">No complaint found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function searchComplaints() {
        const searchInput = document.getElementById('search-complaints');
        const searchValue = searchInput.value.trim().toLowerCase();
        const tableBody = document.getElementById('complaints-table-body');
        const rows = tableBody.rows;
        const noComplaintFoundRow = document.getElementById('no-complaint-found');

        let found = false;

        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            const cells = row.cells;

            for (let j = 0; j < cells.length; j++) {
                const cell = cells[j];
                const cellText = cell.textContent.toLowerCase();

                if (cellText.includes(searchValue)) {
                    found = true;
                    break;
                }
            }

            if (found) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }

        if (searchValue === '') {
            if (rows.length === 0) {
                noComplaintFoundRow.style.display = '';
            } else {
                noComplaintFoundRow.style.display = 'none';
            }
        } else {
            if (found) {
                noComplaintFoundRow.style.display = 'none';
            } else {
                noComplaintFoundRow.style.display = '';
            }
        }
    }
</script>

        <!-- Notices tab -->
        <div class="tab-pane fade" id="respondent" role="tabpanel" aria-labelledby="respondent-tab">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="input-group mb-3" style="width: 300px;">
            <button class="btn btn-outline-secondary" type="button" id="search-notices-btn">
                <i class="fa fa-search"></i>
            </button>
            <input type="text" class="form-control" id="search-notices" placeholder="Search Notices..." oninput="searchNotices()">
        </div>
    </div>
    <div style="max-height: 200px; overflow-y: auto;"> <!-- Added overflow styling -->
        <table class="table table-hover table-striped table-bordered">
            <thead class="bg-dark text-white">
                <tr>
                    <th class="text-light">No.</th>
                    <th class="text-light">Complaint Name</th>
                    <th class="text-light">Complainant</th>
                    <th class="text-light">Status</th>
                </tr>
            </thead>
            <tbody id="notices-table-body">
                <?php $i = 1; ?>
                <?php if (!empty($noticesAsRespondent)): ?>
                    <?php foreach ($noticesAsRespondent as $notice): ?>
                        <tr class="notice-row" data-notice="<?= esc($notice->complaint); ?>">
                            <td><?= $i++; ?></td>
                            <td><?= esc($notice->complaint) ?></td>
                            <td>
    <?php if (Auth::isAdmin()): ?>
        <?= ucwords(str_replace('.',' ',esc($notice->user_id))) ?>
    <?php else: ?>
        <?= htmlspecialchars('User  ID Withheld') ?>
    <?php endif; ?>
</td>
                            <td><?= esc($notice->status) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr id="no-notices-found">
                        <td colspan="4" class="text-center">No notices found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function searchNotices() {
        const searchInput = document.getElementById('search-notices');
        const searchValue = searchInput.value.trim().toLowerCase();
        const tableBody = document.getElementById('notices-table-body');
        const rows = tableBody.rows;
        const noNoticesFoundRow = document.getElementById('no-notices-found');

        let found = false;

        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            const cells = row.cells;

            for (let j = 0; j < cells.length; j++) {
                const cell = cells[j];
                const cellText = cell.textContent.toLowerCase();

                if (cellText.includes(searchValue)) {
                    found = true;
                    break;
                }
            }

            if (found) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }

        if (searchValue === '') {
            if (rows.length === 0) {
                noNoticesFoundRow.style.display = '';
            } else {
                noNoticesFoundRow.style.display = 'none';
            }
        } else {
            if (found) {
                noNoticesFoundRow.style.display = 'none';
            } else {
                noNoticesFoundRow.style.display = '';
            }
        }
    }
</script>
    </div>

</div>




        <hr class="my-4">
        <?php if (Auth::canPerformAction() || Auth::isStaff()): ?>
        <div class="text-center">
            <button class="btn btn-info btn-sm shadow" onclick="showCertificate('firstCertificate')" style="background-color: gray; height: 50px; width: 70px">
                <i class="fa fa-print"></i>
           
            </button>
        </div>
        <?php endif ?>

        <!-- Modal for certificate selection -->



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
            This is to certify that <?php echo esc($row->firstname . ' ' . $row->lastname); ?>, a <?php echo esc(formatYearLevel($row->year_level_id));?> year student from this institution under the <?php echo esc($row->course); ?> program, has consistently shown good moral conduct and character and complied and adhered to the rules and regulations set forth while in attendance in this institution.
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


    <?php 

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the log name from the form submission
    $log_name = $_POST['log_name'];

    // Call the log_activity function to log the activity
    log_activity($log_name);

    // Now proceed to print the certificate
    // You can include your logic here to generate the certificate
    $currentDate = date('jS') . ' day of ' . date('F Y'); // Example date formatting
    // Render the certificate or handle the print logic here
    

}
?>

    <div class="text-center mt-4">
    <form action="" method="POST">
    <input type="hidden" name="log_name" value="Printed Good Moral Certificate">
    <button type="submit" class="btn btn-primary" onclick="printCertificate()">Print Certificate</button>
</form>
</div>
</div>


</div>
</div>

    <?php else: ?>
        <div class="text-center">
            <h3>Sorry, that profile was not found!</h3>
        </div>
    <?php endif; ?>
</div>

<script>
function printCertificate() {
let certificateContent = document.getElementById('firstCertificate').innerHTML;
const dropdowns = document.querySelectorAll('#firstCertificate select');
dropdowns.forEach(dropdown => {
const selectedValue = dropdown.options[dropdown.selectedIndex].text;
certificateContent = certificateContent.replace(dropdown.outerHTML, selectedValue);
});

const printWindow = window.open('', '', 'height=600,width=800');
printWindow.document.write('<html><head><title>Print Certificate</title>');
printWindow.document.write('<style>');
printWindow.document.write('body { font-family: Arial, sans-serif; margin: 20px; }');
printWindow.document.write('button, .mt-4, #label, #purposeDropdown, #customPurposeInput { display: none; }');
printWindow.document.write('</style></head><body>');
printWindow.document.write(certificateContent);
printWindow.document.write('</body></html>');

printWindow.document.close();
printWindow.onload = function() {
    printWindow.focus();
    printWindow.print();
    printWindow.close();
};

document.getElementById('purposeDropdown').onchange = updatePurpose;
document.getElementById('customPurpose').oninput = function() {
    document.getElementById('selectedPurposeText').textContent = this.value;
};
    }
</script>
<script>

document.addEventListener('DOMContentLoaded', function() {
        updatePurpose();  // To handle any pre-set dropdown value
    });

 


document.getElementById('purposeDropdown').addEventListener('change', updateSelectedPurpose);

function updateSelectedPurpose() {
    const purposeDropdown = document.getElementById('purposeDropdown');
    const selectedPurpose = purposeDropdown.options[purposeDropdown.selectedIndex].text;
    const selectedPurposeElement = document.getElementById('selected-purpose');
    const customPurposeInput = document.getElementById('customPurposeInput');
    const paragraphElement = document.getElementById('firstCertificate').querySelector('p:nth-child(2)');

    if (selectedPurpose === 'Other') {
        customPurposeInput.style.display = 'block';
        selectedPurposeElement.textContent = '';
    } else {
        customPurposeInput.style.display = 'none';
        selectedPurposeElement.textContent = selectedPurpose;

        if (selectedPurpose === 'Legal') {
            paragraphElement.innerHTML = 'This is to certify that <?php echo esc($row->firstname . ' ' . $row->lastname); ?>, a graduate from this institution under the <?php echo esc($row->course); ?> program, has consistently shown good moral conduct and character and complied and adhered to the rules and regulations set forth while in attendance in this institution.';
        } else {
            paragraphElement.innerHTML = 'This is to certify that <?php echo esc($row->firstname . ' ' . $row->lastname); ?>, a <?php echo esc(formatYearLevel($row->year_level_id));?> year student from this institution under the <?php echo esc($row->course); ?> program, has consistently shown good moral conduct and character and complied and adhered to the rules and regulations set forth while in attendance in this institution.';
        }
    }
}

document.getElementById('customPurpose').addEventListener('input', function() {
    const customPurpose = document.getElementById('customPurpose').value;
    const selectedPurposeElement = document.getElementById('selected-purpose');

    selectedPurposeElement.textContent = customPurpose;
});

document.getElementById('purposeDropdown').addEventListener('change', updateSelectedPurpose);

function showCertificate(certificateId) {
    // Hide all certificates
    const certificates = document.querySelectorAll('.certificate');
    certificates.forEach(cert => cert.classList.remove('show'));

    // Show the selected certificate
    document.getElementById(certificateId).classList.add('show');

    // Hide the modal if you are using a modal to select certificates
    document.getElementById('certificateModal').style.display = 'none';
}


    document.addEventListener('DOMContentLoaded', function() {
    // Check if an active tab is stored in sessionStorage
    const activeTab = sessionStorage.getItem('activeTab');

    if (activeTab) {
        // Find the tab link and content pane for the stored tab
        const tabLink = document.querySelector(`#${activeTab}-tab`);
        const tabContent = document.querySelector(`#${activeTab}`);

        // Deactivate all other tabs
        document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('active', 'show'));
        document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));

        // Activate the stored tab
        if (tabLink && tabContent) {
            tabLink.classList.add('active');
            tabContent.classList.add('active', 'show');
        }

        // Clear the stored tab state after switching
        sessionStorage.removeItem('activeTab');
    }
});


    function searchViolations() {
        const searchInput = document.getElementById('search-violations');
        const searchValue = searchInput.value.trim().toLowerCase();
        const tableBody = document.getElementById('violations-table-body');
        const rows = tableBody.rows;

        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            const cells = row.cells;
            let found = false;

            for (let j = 0; j < cells.length; j++) {
                const cell = cells[j];
                const cellText = cell.textContent.toLowerCase();

                if (cellText.includes(searchValue)) {
                    found = true;
                    break;
                }
            }

            if (found) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
    const hash = window.location.hash;
    if (hash) {
        const tab = document.querySelector(`a[href="${hash}"]`);
        if (tab) {
            const bootstrapTab = new bootstrap.Tab(tab);
            bootstrapTab.show();
        }
    }
});y




</script>



<?php $this->view('includes/footer'); ?>
