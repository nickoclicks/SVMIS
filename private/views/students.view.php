<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

<style>
    .student-item {
    background: linear-gradient(to bottom, #ffffff, #f0f0f0); /* Adjust the colors as needed */
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Optional: Add some shadow for depth */
    margin-bottom: 15px;
}
.navbar {
    background: linear-gradient(left to right, #ffffff, #e0e0e0); /* Adjust the colors as needed */
    margin-bottom: 10px;
    border-radius: 10px;
    padding: 10px; /* Optional: Add some padding for spacing */
}
.btn-view-profile {
    background: linear-gradient(to right, #0D47A1, #1976D2); /* Dark blue gradient */
    border: none;
    color: white;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border-radius: 5px;
    transition: background 0.3s ease;
}
.student-img {
    width: 70px; /* Adjust size as needed */
    height: 70px; /* Ensure width and height are equal for a perfect circle */
    border-radius: 50%; /* Makes the image circular */
    object-fit: cover; /* Ensures the image covers the entire circle without distortion */
    border: 3px solid #fff; /* Optional: Inner white border for contrast */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Shadow for depth */
    transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth transition for hover effects */
    margin-bottom: 10px; /* Space between image and text */
}

.student-img-container {
    display: inline-block;
    padding: 5px; /* Space between the image and the gradient border */
    background: linear-gradient(to right, #ff7e5f, #feb47b); /* Gradient border colors */
    border-radius: 50%; /* Circular container to match the image */
}

.student-item:hover .student-img {
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); /* Enhance shadow on hover */
    transform: scale(1.05); /* Slightly enlarge the photo on hover */
}

.btn-view-profile:hover {
    background: linear-gradient(to right, #0B3C91, #1565C0); /* Even darker blue gradient on hover */
}

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

.student-info {
    font-family: Arial, sans-serif;
    font-size: 18px;
    line-height: 1.5;
    color: #333;
}

.student-info h5 {
    font-size: 20px;
    font-weight: bold;
    
}



</style>
<div class="dashboard-container p-4 shadow mx-auto" style="max-width: 1700px;">
    <nav class="navbar bg-body-tertiary shadow" style="background-color: gray; border-radius: 10px">
        <form class="form-inline" method="GET" action="">
            <div class="input-group">
                <span class="input-group-text" id="basic-addon1" style="margin-left: 10px;">
                    <i class="fa fa-search"></i>
                </span>
                <input type="text" name="search" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1" value="<?= htmlspecialchars($searchTerm ?? '') ?>">
            </div>
        </form>
        <?php if (Auth::canPerformAction()): ?>
        <a href="<?= ROOT ?>/signup?mode=students">
            <button class="btn btn-view-profile" style="margin-right: 10px;">
                <i class="fa fa-plus"></i> Add New
            </button>
        </a>
        <?php endif ?>
    </nav>

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
                <div class="student-item">
                    <?php
                    $image = $row->image;
                    switch ($row->course) {
                        case 'BSBA':
                            $image = ROOT . '/assets/male.png';
                            break;
                        case 'TEP':
                            $image = ROOT . '/assets/female.png';
                            break;
                        case 'BSIT':
                            $image = ROOT . '/assets/female.png';
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
<span class="indicator violation-indicator <?= $violationClass ?>">
    <?= $violationIcon ?> <?= $row->unresolved_violations ?>
</span>

<?php
// For notices
$hasNotices = $row->unresolved_notices > 0;
$noticeClass = $hasNotices ? 'indicator-red' : 'indicator-green';
$noticeIcon = '<i class="fa fa-bell"></i>';
?>
<span class="indicator notice-indicator <?= $noticeClass ?>">
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
