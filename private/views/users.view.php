<?php $this->view('includes/header'); ?>
<?php $this->view('includes/navigation'); ?>

<style>
.user-item {
        background: linear-gradient(to bottom, #ffffff, #f0f0f0);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 15px;
        display: flex; /* Align items horizontally */
        align-items: center; /* Center items vertically */
    }
    .navbar {
        background: linear-gradient(to right, #ffffff, #e0e0e0);
        margin-bottom: 10px;
        border-radius: 10px;
        padding: 10px;
    }
    .btn-view-profile {
        background: linear-gradient(to right, #0D47A1, #1976D2);
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
    .btn-view-profile:hover {
        background: linear-gradient(to right, #0B3C91, #1565C0);
    }
    .user-img-container {
        display: inline-block;
        padding: 5px;
        background: linear-gradient(to right, #ff7e5f, #feb47b);
        border-radius: 50%;
        margin-right: 15px; /* Space between image and text */
    }
    .user-img {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-right: 25px;
    }
    .user-img:hover {
        transform: scale(1.05); /* Slightly enlarge image on hover */
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); /* Increase shadow on hover */
    }
    .user-info {
        flex-grow: 1; /* Allow user info to take available space */
    }
    .user-info h5 {
        margin: 0; /* Remove default margin */
        font-size: 18px; /* Increase font size */
    }
    .user-info p {
        margin: 5px 0 0; /* Adjust margin for better spacing */
        font-size: 14px; /* Adjust font size */
        color: #555; /* Slightly lighter text color */
    }
    .violation-indicator {
    display: inline-block;
    padding: 3px 8px;
    border-radius: 12px;
    color: white;
    font-size: 12px;
    margin-top: 5px;
}
</style>
<div class="dashboard-container p-4 shadow mx-auto" style="max-width: 1700px;">
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
