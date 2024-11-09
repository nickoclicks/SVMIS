<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

<div style="margin-left: -150px">
<div class="dashboard-container-fluid p-4 shadow-lg mx-auto bg-light" style="max-width: 1700px; border-radius: 10px;">

    <div class="row text-center">
        <div class="col-md-4 mb-4">
        <div class="stat-card">
                <div class="card-body p-4">
                <div class="icon" style="color: rgba(0, 0, 255, 0.8);"><i class="fa fa-exclamation-triangle"></i></div>
                        <a href="<?= ROOT ?>/profile/<?= Auth::getUserId() ?>"
                        <h5 class="card-title justify-content-center text-decoration-none" style="font-size: 20px; font-weight: bold; color: rgba(0, 0, 255, 0.8);">Violations Committed</h5>
                        <p style="color: rgba(0, 0, 255, 0.8);"><?= $totalUserViolations ?></p>
                        </a>
                </div>
            </div>
        </div>

       
        <div class="col-md-4 mb-4">
        <div class="stat-card">
                <div class="card-body p-4">
                <div class="icon" style="color: rgba(0, 0, 255, 0.8);"><i class="fa fa-bullhorn"></i></div>
                         <a href="<?= ROOT ?>/profile/<?= Auth::getUserId() ?> . #complainant"
                         <h5 class="card-title justify-content-center text-decoration-none" style="font-size: 20px; font-weight: bold; color: rgba(0, 0, 255, 0.8);">Complaints Filed</h5>
                        <p style="color: rgba(0, 0, 255, 0.8);"><?= $totalComplaints ?></p>
                        </a>
                  
                   
                    
                </div>
            </div>
        </div>

        <!-- Notices Card -->
        <div class="col-md-4 mb-4">
        <div class="stat-card">
                <div class="card-body p-4">
                <div class="icon" style="color: rgba(0, 0, 255, 0.8);"><i class="fa fa-bell"></i></div>
                         <a href="<?= ROOT ?>/profile/<?= Auth::getUserId() ?> . #respondent"
                         <h5 class="card-title justify-content-center text-decoration-none" style="font-size: 20px; font-weight: bold; color: rgba(0, 0, 255, 0.8);">Complaints Received</h5>
                        <p style="color: rgba(0, 0, 255, 0.8);"><?= $totalNotices ?></p>
</a>
                    
                    
                </div>
            </div>
        </div>
    </div>

<?php

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
    
     <div class="row">
    <div class="violation-levels mb-5">
        <center><h4 class="text-secondary mb-4">Violation Levels Committed</h4></center>
        <div class="row text-center">
            <div class="col-md-6 mb-4">
                <div class="card border-1 shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">Minor Violations</h5>
                        <span class="badge bg-warning text-white fs-4"><?php echo $minorViolationCount; ?></span>
                    </div>
                </div>
            </div>
       
             
            
            <div class="col-md-6 mb-4">
                <div class="card border-1 shadow-sm h-100">
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
    <div class="card current-sanction" style="height: 350px">
        <center><h4 class="text-secondary">Possible Sanctions for Current Violations</h4></center>
        <center><h6 class="text-secondary mb-4"><i>(These are the possible sanctions that can be applied to you, based on your current violation)</i></h6></center>
        <ul class="list-group list-group-flush">
            <?php foreach ($sanctions['current'] as $sanction): ?>
                <li class="list-group-item bg-light rounded-3 shadow-sm mb-2"><?php echo $sanction; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    </div>

    <div class="col-md-6"> 

    <div class="card future-sanctions" style="height: 350px; overflow: scroll">
        <center><h4 class="text-secondary">Possible Sanctions for next Violations</h4></center>
        <center><h6 class="text-secondary mb-4"><i>(These are the possible sanctions that can be applied to you, if you commit another violation regardless of the level)</i></h6></center>
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
