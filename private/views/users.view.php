<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

<div class="dashboard-container p-4 shadow mx-auto" style="max-width: 1400px;">
    <nav class="navbar bg-body-tertiary shadow" style="background-color: gray; margin-bottom: 10px; border-radius: 10px">
        <form class="form-inline" method="GET" action="">
            <div class="input-group">
                <span class="input-group-text" id="basic-addon1" style="margin-left: 10px;">
                    <i class="fa fa-search"></i>
                </span>
                <input type="text" name="search" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1" value="<?= htmlspecialchars($searchTerm ?? '') ?>">
            </div>
        </form>
        <?php if (Auth::canPerformAction()): ?>
        <a href="<?= ROOT ?>/signup">
            <button class="btn btn-view-profile" style="margin-right: 10px;">
                <i class="fa fa-plus"></i> Add New
            </button>
        </a>
        <?php endif ?>
    </nav>

    <div id="users-list">
    <?php if ($rows): ?>
        <?php foreach ($rows as $row): ?>
            <div class="user-item">
                <?php
                // Check if the profile picture URL exists; otherwise, assign a default image based on gender
                $image = isset($row->profile_picture_url) && !empty($row->profile_picture_url) && file_exists($row->profile_picture_url)
                    ? $row->profile_picture_url
                    : (($row->gender == 'male') ? ROOT . '/assets/male.png' : ROOT . '/assets/female.png');
                ?>
                <img src="<?= htmlspecialchars($image) ?>" alt="User Image" class="user-img border border-primary">

                <div class="user-info">
                    <h5><?= htmlspecialchars($row->firstname . " " . $row->lastname) ?></h5>
                    <p><?= ucfirst(htmlspecialchars($row->rank)) ?></p>
                </div>
                <a href="<?= ROOT ?>/profile/<?= htmlspecialchars($row->user_id) ?>" class="btn-view-profile btn-dark">View Profile</a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <h4>No staff members were found at this time!</h4>
    <?php endif; ?>
</div>

</div>

<?php $this->view('includes/footer'); ?>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="search"]');

    searchInput.addEventListener('input', function() {
        const searchTerm = searchInput.value;
        
        fetch(`<?= ROOT ?>/users?search=${encodeURIComponent(searchTerm)}`)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContent = doc.querySelector('#users-list').innerHTML;
                document.querySelector('#users-list').innerHTML = newContent;
            })
            .catch(error => console.error('Error fetching search results:', error));
    });
});
</script>
