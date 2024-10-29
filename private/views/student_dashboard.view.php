<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

<div class="dashboard-container-fluid p-4 shadow-lg mx-auto bg-light" style="max-width: 1700px; border-radius: 10px;">

    <div class="row text-center">
        <!-- Violations Card -->
        <div class="col-md-4 mb-4">
            <div class="card" style="border-radius: 10px; border: 1px solid #e3e3e3;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="<?= ROOT ?>/profile/<?= Auth::getUserId() ?>"
                        <h5 class="card-title">Violations</h5>
                        <div class="rounded-circle bg-light p-2">
                            <i class="fa fa-exclamation-triangle" style="color: #007bff; font-size: 1.5rem;"></i>
                        </div>
                        </a>
                    </div>
                    <hr>
                    <div class="text-center">
                        <h1 class="display-4 fw-bold"><?= $totalUserViolations ?></h1>
                        <p class="text-muted">Total Violations</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Complaints Card -->
        <div class="col-md-4 mb-4">
            <div class="card" style="border-radius: 10px; border: 1px solid #e3e3e3;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                         <a href="<?= ROOT ?>/profile/<?= Auth::getUserId() ?> . #complainant"
                        <h5 class="card-title">Complaints</h5>
                        <div class="rounded-circle bg-light p-2">
                            <i class="fa fa-bullhorn" style="color: #007bff; font-size: 1.5rem;"></i>
                        </div>
</a>
                    </div>
                    <hr>
                    <div class="text-center">
                        <h1 class="display-4 fw-bold"><?= $totalComplaints ?></h1>
                        <p class="text-muted">Total Complaints</p>
                    </div>
                    
                </div>
            </div>
        </div>

        <!-- Notices Card -->
        <div class="col-md-4 mb-4">
            <div class="card" style="border-radius: 10px; border: 1px solid #e3e3e3;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                         <a href="<?= ROOT ?>/profile/<?= Auth::getUserId() ?> . #respondent"
                        <h5 class="card-title">Notices</h5>
                        <div class="rounded-circle bg-light p-2">
                            <i class="fa fa-bell" style="color: #007bff; font-size: 1.5rem;"></i>
                        </div>
</a>
                    </div>
                    <hr>
                    <div class="text-center">
                        <h1 class="display-4 fw-bold"><?= $totalNotices ?></h1>
                        <p class="text-muted">Total Notices</p>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

<?php
// Determine current and next possible sanctions based on violation counts
function getCurrentAndNextSanctions($minorViolationCount, $majorViolationCount) {
    $currentSanctions = [];
    $nextSanctions = [];

    // Current sanctions
    if ($minorViolationCount == 1) {
        $currentSanctions[] = "Community Service";
    }
  
    if ($minorViolationCount == 2) {
        $currentSanctions[] = "Character Probation";
    }
    if ($majorViolationCount == 1 || $minorViolationCount == 3) {
        $currentSanctions[] = "Final Character Probation";
    }
    if ($minorViolationCount == 4 || $majorViolationCount >= 1) {
        $currentSanctions[] = "Suspension";
    }
    if ($minorViolationCount == 9) {
        $currentSanctions[] = "Non-Readmission";
    }
    if ($majorViolationCount == 2) {
        $currentSanctions[] = "Exclusion";
    }
    if ($majorViolationCount == 3) {
        $currentSanctions[] = "Expulsion";
    }

    // Next possible sanctions
    if ($minorViolationCount < 1) {
        $nextSanctions[] = "Community Service";
    }
    
    if ($minorViolationCount < 2) {
        $nextSanctions[] = "Character Probation";
    }
    if ($majorViolationCount < 1 || $minorViolationCount < 3) {
        $nextSanctions[] = "Final Character Probation";
    }
    if ($minorViolationCount < 4 || $majorViolationCount < 1) {
        $nextSanctions[] = "Suspension";
    }
    if ($minorViolationCount < 9) {
        $nextSanctions[] = "Non-readmission";
    }
    if ($majorViolationCount < 2) {
        $nextSanctions[] = "Exclusion";
    }
    if ($majorViolationCount < 3) {
        $nextSanctions[] = "Expulsion";
    }

    return [
        'current' => $currentSanctions,
        'next' => $nextSanctions
    ];
}



$sanctions = getCurrentAndNextSanctions($minorViolationCount, $majorViolationCount);
?>

<!-- Summary Section -->
<div class="profile-summary card border-0 shadow-lg rounded-4 p-4 bg-white mb-5">
    

    <!-- Grid Layout for Violations, Notices, and Complaints -->
    

    <!-- Violation Levels Section with Grid -->
     <div class="row">
    <div class="violation-levels mb-5">
        <h4 class="text-secondary mb-4">Violation Levels Committed</h4>
        <div class="row text-center">
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">Minor Violations</h5>
                        <span class="badge bg-info text-white fs-4"><?php echo $minorViolationCount; ?></span>
                    </div>
                </div>
            </div>
       
             
            
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">Major Violations</h5>
                        <span class="badge bg-danger text-white fs-4"><?php echo $majorViolationCount; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
    <div class="col-md-6">
    <!-- Sanctions Section -->
    <div class="current-sanctions mb-5">
        <h4 class="text-secondary mb-4">Current Sanctions</h4>
        <ul class="list-group list-group-flush">
            <?php foreach ($sanctions['current'] as $sanction): ?>
                <li class="list-group-item bg-light rounded-3 shadow-sm mb-2"><?php echo $sanction; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    </div>

    <div class="col-md-6"> 

    <div class="future-sanctions">
        <h4 class="text-secondary mb-4">Possible Sanctions for next Violation</h4>
        <ul class="list-group list-group-flush">
            <?php foreach ($sanctions['next'] as $sanction): ?>
                <li class="list-group-item bg-light rounded-3 shadow-sm mb-2"><?php echo $sanction; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
     </div>
     </div>


<!-- Existing dashboard content -->

<script>
    function toggleDescription(icon) {
        var description = icon.nextElementSibling;
        if (description.style.display === "none") {
            description.style.display = "block";
        } else {
            description.style.display = "none";
        }
    }
</script>

<?php $this->view('includes/footer'); ?>
