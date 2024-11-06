<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

<style>

.indicator-red {
    background-color: #ff7e5f;
    color: #fff;
}

.indicator-green {
    background-color: #4CAF50;
    color: #fff;
}

/* Styles for both violation and notice indicators */
.indicator-green {
    background: linear-gradient(135deg, #4CAF50, #45a049);
    box-shadow: 0 2px 5px rgba(76, 175, 80, 0.3);
}

.indicator-red {
    background: linear-gradient(135deg, #f44336, #d32f2f);
    box-shadow: 0 2px 5px rgba(244, 67, 54, 0.3);
}

/* Hover effects */
.indicator:hover {
    transform: scale(1.1);
}

.indicator-green:hover {
    filter: brightness(1.1);
}

.indicator-red:hover {
    filter: brightness(0.9);
}
</style>
<div style="margin-left: -150px; margin-top: -10px">

<div class="dashboard-container p-4 shadow mx-auto" style="max-width: 1700px;">
    <div class="row">
    <nav class="navbar shadow" style="background-color: white; border-radius: 10px">
        <form class="form-inline" method="GET" action="">
            <div class="input-group col-md-2">
                <span class="input-group-text" id="basic-addon1" style="margin-left: 10px;">
                    <i class="fa fa-search"></i>
                </span>
                <input type="text" name="search" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1" value="<?= htmlspecialchars($searchTerm ?? '') ?>">
            </div>
        </form>
        
        <div class="col-md-8 text-center">
<h5>Generally Categorized by Course</h5>
</div>

<div class="col-md-2">
        <?php if (Auth::canPerformAction()): ?>
        <a href="<?= ROOT ?>/signup?mode=students">
            <button class="btn btn-view-profile" style="margin-right: 15px; float: right">
                <i class="fa fa-plus"></i> Add New
            </button>
        </a>
        <?php endif ?>
    </nav>
    </div>

    <div id="students-list">
    <?php if ($rows): ?>
    <?php
    $courses = array_unique(array_column($rows, 'course'));
    foreach ($courses as $course): ?>
        <div class="course-column">
            
            <h6><?= ucfirst(htmlspecialchars($course)) ?></h6>
            <?php
            $studentsInCourse = array_filter($rows, function($row) use ($course) {
                return $row->course == $course;
            });
            $studentsToDisplay = array_slice($studentsInCourse, 0, 5); // Display at least 5 students per course
            foreach ($studentsToDisplay as $row): ?>
                <div class="student-item" style="width: 500px;">
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
                        default:
                            $image = $row->image;
                            break;
                    }
                    ?>
                    <img src="<?= htmlspecialchars($image) ?>" alt="Student Image" class="student-img border border-primary">
                    <div class="student-info">
                        <h5><?= htmlspecialchars($row->firstname . " " . $row->lastname) ?></h5>
                        <p><?= ucfirst(htmlspecialchars($row->rank)) ?></p>

                       
                        <?php
// For violations
$hasViolations = $row->unresolved_violations > 0;
$violationClass = $hasViolations ? 'indicator-red' : 'indicator-green';
$violationIcon = '<i class="fa fa-exclamation-circle"></i>';
?>
<span class="indicator violation-indicator <?= $violationClass ?>" style="display: inline-flex;align-items: center;padding: 5px 10px;border-radius: 10px;font-size: 16px;">
    <?= $violationIcon ?> <?= $row->unresolved_violations ?>
</span>

<?php
// For notices
$hasNotices = $row->unresolved_notices > 0;
$noticeClass = $hasNotices ? 'indicator-red' : 'indicator-green';
$noticeIcon = '<i class="fa fa-bell"></i>';
?>
<span class="indicator notice-indicator <?= $noticeClass ?>" style="display: inline-flex;align-items: center;padding: 5px 10px;border-radius: 10px;font-size: 16px;">
    <?= $noticeIcon ?> <?= $row->unresolved_notices ?>
</span>

                    </div>
                    <a href="<?= ROOT ?>/profile/<?= htmlspecialchars($row->user_id) ?>" class="btn-view-profile">View Profile</a>
                </div>
            <?php endforeach ?>
        </div>
    <?php endforeach ?>
<?php else: ?>
    <h4>No student information was found at this time!</h4>
<?php endif ?>
</div>

</div>
</div>


<?php $this->view('includes/footer'); ?>



<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="search"]');

    searchInput.addEventListener('input', function() {
        const searchTerm = searchInput.value;
        
        fetch(`<?= ROOT ?>/students?search=${encodeURIComponent(searchTerm)}`)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContent = doc.querySelector('#students-list').innerHTML;
                document.querySelector('#students-list').innerHTML = newContent;
            })
            .catch(error => console.error('Error fetching search results:', error));
    });
});
</script>
