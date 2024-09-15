<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

<div class="dashboard-container p-4 shadow mx-auto" style="max-width: 1400px;">
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
                    if (!file_exists($image)) {
                        // Default to gender-based image if no valid profile picture is found
                        $image = ($row->gender == 'male') ? ROOT . '/assets/male.png' : ROOT . '/assets/female.png';
                    }
                    ?>
                    <img src="<?= htmlspecialchars($image) ?>" alt="Student Image" class="student-img border border-primary">
                    <div class="student-info">
                        <h5><?= htmlspecialchars($row->firstname . " " . $row->lastname) ?></h5>
                        <p><?= ucfirst(htmlspecialchars($row->rank)) ?></p>
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
