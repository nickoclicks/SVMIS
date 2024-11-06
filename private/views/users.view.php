<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

<div style="margin-left: -150px; margin-top: -10px">
<div class="dashboard-container p-4 shadow mx-auto" style="max-width: 1700px; margin-left: -150px; margin-top: -10px">
    <nav class="navbar shadow" style="background-color: white; margin-bottom: 10px; border-radius: 10px">
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
            <div class="user-item" style="background-color: white; padding: 20px;   border-radius: 10px;   box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); margin-bottom: 15px; display: flex; align-items: center; ">
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
                <img src="<?= htmlspecialchars($image) ?>" alt="User Image" class="user-img border border-primary" style="width: 70px;height: 70px;border-radius: 50%;object-fit: cover;border: 3px solid #fff;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);transition: transform 0.3s ease, box-shadow 0.3s ease;margin-right: 25px;">

                <div class="user-info" style="flex-grow: 1;">
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
