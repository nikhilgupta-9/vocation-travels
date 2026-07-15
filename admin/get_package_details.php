<?php
session_start();
include "db-conn.php";

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    exit('Unauthorized');
}

$id = (int)$_GET['id'];

// Get package details
$package = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM packages WHERE id = $id"));

if (!$package) {
    exit('Package not found');
}

// Get highlights
$highlights = mysqli_query($conn, "SELECT highlight FROM package_highlights WHERE package_id = $id ORDER BY display_order");

// Get inclusions
$inclusions = mysqli_query($conn, "SELECT inclusion FROM package_inclusions WHERE package_id = $id ORDER BY display_order");

// Get itinerary
$itinerary = mysqli_query($conn, "SELECT day_number, title, description FROM package_itinerary WHERE package_id = $id ORDER BY display_order");

// Get notes
$notes = mysqli_query($conn, "SELECT note FROM package_notes WHERE package_id = $id ORDER BY display_order");
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <?php if ($package['image']): ?>
                <img src="<?= $site . $package['image'] ?>" class="img-fluid rounded mb-3" alt="<?= $package['title'] ?>">
            <?php endif; ?>
            
            <div class="mb-3">
                <h6 class="fw-bold">Package Details</h6>
                <p><strong>Type:</strong> <span class="badge bg-<?= $package['type'] == 'domestic' ? 'success' : 'info' ?>"><?= ucfirst($package['type']) ?></span></p>
                <p><strong>Duration:</strong> <?= $package['duration'] ?></p>
                <p><strong>Price:</strong> $<?= number_format($package['price'], 2) ?> <?= $package['price_note'] ?></p>
                <p><strong>Suitable For:</strong> <?= $package['suitable_for'] ?: 'N/A' ?></p>
                <p><strong>Status:</strong> <span class="badge bg-<?= $package['status'] ? 'success' : 'secondary' ?>"><?= $package['status'] ? 'Active' : 'Inactive' ?></span></p>
                <p><strong>Featured:</strong> <?= $package['featured'] ? 'Yes' : 'No' ?></p>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="mb-3">
                <h6 class="fw-bold"><?= $package['title'] ?></h6>
                <p><?= nl2br($package['short_description']) ?></p>
            </div>
            
            <?php if (mysqli_num_rows($highlights) > 0): ?>
            <div class="mb-3">
                <h6 class="fw-bold">Highlights</h6>
                <ul>
                    <?php while ($row = mysqli_fetch_assoc($highlights)): ?>
                        <li><?= $row['highlight'] ?></li>
                    <?php endwhile; ?>
                </ul>
            </div>
            <?php endif; ?>
            
            <?php if (mysqli_num_rows($inclusions) > 0): ?>
            <div class="mb-3">
                <h6 class="fw-bold">Inclusions</h6>
                <ul>
                    <?php while ($row = mysqli_fetch_assoc($inclusions)): ?>
                        <li>🟢 <?= $row['inclusion'] ?></li>
                    <?php endwhile; ?>
                </ul>
            </div>
            <?php endif; ?>
            
            <?php if (mysqli_num_rows($itinerary) > 0): ?>
            <div class="mb-3">
                <h6 class="fw-bold">Itinerary</h6>
                <?php while ($row = mysqli_fetch_assoc($itinerary)): ?>
                    <div class="mb-2">
                        <strong>Day <?= $row['day_number'] ?>: <?= $row['title'] ?></strong>
                        <p><?= nl2br($row['description']) ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
            <?php endif; ?>
            
            <?php if (mysqli_num_rows($notes) > 0): ?>
            <div class="mb-3">
                <h6 class="fw-bold">Important Notes</h6>
                <ul class="text-danger">
                    <?php while ($row = mysqli_fetch_assoc($notes)): ?>
                        <li><?= $row['note'] ?></li>
                    <?php endwhile; ?>
                </ul>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>