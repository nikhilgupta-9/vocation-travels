<?php
session_start();
include "db-conn.php";

if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM visa_cities WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['success'] = "Visa city deleted successfully!";
    } else {
        $_SESSION['error'] = "Error deleting visa city: " . $stmt->error;
    }
    $stmt->close();
    header("Location: view-visa-cities.php");
    exit();
}

if (isset($_GET['toggle'])) {
    $id = (int) $_GET['toggle'];
    $stmt = $conn->prepare("UPDATE visa_cities SET status = IF(status = 'active', 'inactive', 'active') WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: view-visa-cities.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Visa Cities | Admin Panel</title>
    <link rel="icon" href="assets/img/logo_icon.jpg" type="image/png">
    <?php include "links.php"; ?>
</head>

<body class="crm_body_bg">
    <?php include "header.php"; ?>
    <section class="main_content dashboard_part large_header_bg">
        <div class="container-fluid g-0">
            <div class="row">
                <div class="col-lg-12 p-0">
                    <?php include "top_nav.php"; ?>
                </div>
            </div>
        </div>

        <div class="main_content_iner">
            <div class="container-fluid p-0 sm_padding_15px">

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="container mt-3">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($_SESSION['success']) ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="container mt-3">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($_SESSION['error']) ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="white_card card_height_100 mb_30">
                            <div class="card-header bg-white border-0 py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h2 class="mb-0 fw-bold">Visa City Landing Pages</h2>
                                        <p class="text-muted mb-0 small">Manage /visa-consultants-:city pages — no deploy needed to add a new city</p>
                                    </div>
                                    <a href="add-visa-city.php" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Add New City
                                    </a>
                                </div>
                            </div>
                            <div class="white_card_body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered text-center">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Order</th>
                                                <th>Name</th>
                                                <th>Slug / URL</th>
                                                <th>Services</th>
                                                <th>FAQs</th>
                                                <th>Status</th>
                                                <th>Updated</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sno = 1;
                                            $sql = "SELECT * FROM visa_cities ORDER BY city_order ASC, name ASC";
                                            $result = mysqli_query($conn, $sql);
                                            while ($row = mysqli_fetch_assoc($result)):
                                                $services_count = count(json_decode($row['services'], true) ?: []);
                                                $faqs_count = count(json_decode($row['faqs'], true) ?: []);
                                            ?>
                                                <tr>
                                                    <td><?= $sno++ ?></td>
                                                    <td><?= (int) $row['city_order'] ?></td>
                                                    <td><?= htmlspecialchars($row['name']) ?></td>
                                                    <td><code>/visa-consultants-<?= htmlspecialchars($row['slug']) ?>/</code></td>
                                                    <td><?= $services_count ?></td>
                                                    <td><?= $faqs_count ?></td>
                                                    <td>
                                                        <a href="?toggle=<?= $row['id'] ?>"
                                                           class="badge <?= $row['status'] === 'active' ? 'bg-success' : 'bg-secondary' ?>"
                                                           style="text-decoration:none;"
                                                           title="Click to toggle">
                                                            <?= htmlspecialchars($row['status']) ?>
                                                        </a>
                                                    </td>
                                                    <td><?= date('d M Y', strtotime($row['updated_at'])) ?></td>
                                                    <td>
                                                        <a href="edit-visa-city.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-info">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger"
                                                           onclick="return confirm('Delete the <?= htmlspecialchars($row['name']) ?> city page? This cannot be undone.')">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include "footer.php"; ?>
    </section>
</body>

</html>
