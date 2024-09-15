<!--<nav class="navbar bg-body-tertiary shadow" style="background-color: gray;">
    <form class="form-inline">
        <div class="input-group">
            <span class="input-group-text" id="basic-addon1" style="margin-left: 10px;">
                <i class="fa fa-search"></i>
            </span>
            <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1">
        </div>
    </form>

    <div>
        <a href="<?=ROOT?>/single_violations/<?=$row->violation_id?>?tab=violators-add&select=true">
            <button class="btn btn-sm btn-primary" style="margin-right: 10px;"><i class="fa fa-plus"></i> Add New</button>
        </a>

        <a href="<?=ROOT?>/single_violations/<?=$row->violation_id?>?tab=violators-remove&select=true">
            <button class="btn btn-sm btn-primary" style="margin-right: 10px;"><i class="fa fa-minus"></i> Remove</button>
        </a>
    </div>
</nav>-->

<div class="card-group justify-content-center">
    <?php if (is_array($violators)): ?>
        <?php foreach ($violators as $violator): ?>
            <?php
            // Assuming violator information
            $row = $violator->user;
            $image = ($row->gender == 'male') ? ROOT . '/assets/male.png' : ROOT . '/assets/female.png';

            // Check for a custom image
            if (isset($row->image) && !empty($row->image) && file_exists($row->image)) {
                $image = $row->image;
            }
            ?>

            <div class="user-item">
                <img src="<?= htmlspecialchars($image) ?>" alt="Violator Image" class="user-img border border-primary rounded-circle">

                <div class="user-info">
                    <h5><?= htmlspecialchars($row->firstname . " " . $row->lastname) ?></h5>
                    <p><?= ucfirst(htmlspecialchars($row->rank)) ?></p>
                </div>

                <a href="<?= ROOT ?>/profile/<?= htmlspecialchars($row->user_id) ?>" class="btn-view-profile">View Profile</a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <h4>No violators were found at this time!</h4>
    <?php endif; ?>
</div>

<style>
    .card-group {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-top: 20px;
    }

    .user-item {
        display: flex;
        align-items: center;
        background-color: white;
        border: 1px solid #e3e6f0;
        border-radius: 0.5rem;
        padding: 1rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .user-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 50%;
        margin-right: 15px;
    }

    .user-info {
        flex-grow: 1;
    }

    .user-info h5 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
    }

    .user-info p {
        margin: 0;
        color: #6c757d;
    }

    .btn-view-profile {
        background-color: #007bff;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        text-decoration: none;
        transition: transform 0.3s, background-color 0.3s;
    }

    .btn-view-profile:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .user-item {
            flex-direction: column;
            text-align: center;
        }

        .user-img {
            margin-bottom: 10px;
        }

        .btn-view-profile {
            margin-top: 10px;
        }
    }
</style>
