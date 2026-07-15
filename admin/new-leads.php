<?php
session_start();
include "functions.php";

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Travel Inquiries | Admin Dashboard</title>
    <link rel="icon" href="assets/img/logo.png" type="image/png">

    <?php include "links.php"; ?>
    
    <style>
        .inquiry-card {
            transition: all 0.3s ease;
        }
        .inquiry-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-unread {
            background: #fff3e0;
            color: #f39c12;
        }
        .status-read {
            background: #e8f0fe;
            color: #3498db;
        }
        .status-replied {
            background: #d4edda;
            color: #28a745;
        }
    </style>
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
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="white_card card_height_100 mb_30">
                            <div class="card-header bg-white border-0 py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h2 class="mb-1 fw-bold">Travel Inquiries</h2>
                                        <p class="text-muted mb-0 small">Manage customer travel inquiries and requests
                                        </p>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-outline-secondary btn-sm" id="markAllRead" 
                                                onclick="markAllAsRead()">
                                            <i class="fas fa-check-double me-2"></i>Mark All as Read
                                        </button>
                                        <a href="export_inquiries.php" class="btn btn-outline-primary btn-sm" id="exportBtn">
                                            <i class="fas fa-download me-2"></i>Export CSV
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Stats Cards -->
                            <div class="card-body border-bottom">
                                <div class="row g-3">
                                    <?php
                                    $stats = getInquiryStats();
                                    ?>
                                    <div class="col-md-3">
                                        <div class="bg-light p-3 rounded">
                                            <h6 class="text-muted mb-1">Total Inquiries</h6>
                                            <h3 class="mb-0"><?= $stats['total'] ?></h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                                            <h6 class="text-muted mb-1">Unread</h6>
                                            <h3 class="mb-0 text-warning"><?= $stats['unread'] ?></h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="bg-info bg-opacity-10 p-3 rounded">
                                            <h6 class="text-muted mb-1">Today</h6>
                                            <h3 class="mb-0 text-info"><?= $stats['today'] ?></h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="bg-success bg-opacity-10 p-3 rounded">
                                            <h6 class="text-muted mb-1">Replied</h6>
                                            <h3 class="mb-0 text-success"><?= $stats['replied'] ?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Search and Filter Section -->
                            <div class="card-header bg-light border-0 py-3">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="searchInquiries"
                                                placeholder="Search by name, email, destination...">
                                            <button class="btn btn-outline-secondary" type="button">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row g-2">
                                            <div class="col-md-3">
                                                <select class="form-select" id="statusFilter">
                                                    <option value="all">All Status</option>
                                                    <option value="unread">Unread</option>
                                                    <option value="read">Read</option>
                                                    <option value="replied">Replied</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <select class="form-select" id="destinationFilter">
                                                    <option value="all">All Destinations</option>
                                                    <?php echo getDestinationOptions(); ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="date" class="form-control" id="dateFilter" 
                                                       placeholder="Filter by date">
                                            </div>
                                            <div class="col-md-3">
                                                <button class="btn btn-secondary w-100" id="clearFilters">
                                                    <i class="fas fa-times me-2"></i>Clear Filters
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="white_card_body">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle" id="inquiriesTable">
                                        <thead class="bg-light text-dark">
                                            <tr>
                                                <th width="5%">#</th>
                                                <th width="12%">Customer</th>
                                                <th width="15%">Travel Details</th>
                                                <th width="15%">Destination</th>
                                                <th width="18%">Requirements</th>
                                                <th width="10%">Status</th>
                                                <th width="10%">Date</th>
                                                <th width="15%">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php echo displayInquiries(); ?>
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

    <!-- Inquiry Details Modal -->
    <div class="modal fade" id="inquiryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title">Travel Inquiry Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <!-- Personal Information -->
                        <div class="col-md-6">
                            <div class="card border-0 bg-light">
                                <div class="card-body">
                                    <h6 class="border-bottom pb-2 mb-3">
                                        <i class="fas fa-user me-2 text-primary"></i>Personal Information
                                    </h6>
                                    <p class="mb-2"><strong>Name:</strong> <span id="modalName"></span></p>
                                    <p class="mb-2"><strong>Email:</strong> <span id="modalEmail"></span></p>
                                    <p class="mb-2"><strong>Phone:</strong> <span id="modalPhone"></span></p>
                                </div>
                            </div>
                        </div>

                        <!-- Travel Information -->
                        <div class="col-md-6">
                            <div class="card border-0 bg-light">
                                <div class="card-body">
                                    <h6 class="border-bottom pb-2 mb-3">
                                        <i class="fas fa-plane me-2 text-success"></i>Travel Information
                                    </h6>
                                    <p class="mb-2"><strong>Travel Date:</strong> <span id="modalTravelDate"></span></p>
                                    <p class="mb-2"><strong>Destination:</strong> <span id="modalDestination"></span></p>
                                    <p class="mb-2"><strong>Duration:</strong> <span id="modalTimeline"></span></p>
                                </div>
                            </div>
                        </div>

                        <!-- Travelers Information -->
                        <div class="col-12">
                            <div class="card border-0 bg-light">
                                <div class="card-body">
                                    <h6 class="border-bottom pb-2 mb-3">
                                        <i class="fas fa-users me-2 text-info"></i>Travelers
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="text-center p-2 bg-white rounded">
                                                <h4 class="mb-0 text-primary" id="modalAdults">0</h4>
                                                <small class="text-muted">Adults</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="text-center p-2 bg-white rounded">
                                                <h4 class="mb-0 text-success" id="modalChildren">0</h4>
                                                <small class="text-muted">Children</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="text-center p-2 bg-white rounded">
                                                <h4 class="mb-0 text-warning" id="modalTotal">0</h4>
                                                <small class="text-muted">Total</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Special Requirements -->
                        <div class="col-12">
                            <div class="card border-0 bg-light">
                                <div class="card-body">
                                    <h6 class="border-bottom pb-2 mb-3">
                                        <i class="fas fa-comment me-2 text-secondary"></i>Special Requirements
                                    </h6>
                                    <p id="modalComments" class="mb-0 p-3 bg-white rounded"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Metadata -->
                        <div class="col-12">
                            <div class="row g-2 text-muted small">
                                <div class="col-md-4">
                                    <i class="fas fa-calendar me-1"></i> Submitted: <span id="modalDate"></span>
                                </div>
                                <div class="col-md-4">
                                    <i class="fas fa-map-marker-alt me-1"></i> IP: <span id="modalIP"></span>
                                </div>
                                <div class="col-md-4">
                                    <i class="fas fa-globe me-1"></i> Status: <span id="modalStatus"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning" onclick="markAsRead(currentInquiryId)">
                        <i class="fas fa-check me-2"></i>Mark as Read
                    </button>
                    <a href="#" class="btn btn-primary" id="replyBtn" target="_blank">
                        <i class="fas fa-reply me-2"></i>Reply via Email
                    </a>
                    <button type="button" class="btn btn-danger" onclick="deleteInquiry(currentInquiryId)">
                        <i class="fas fa-trash me-2"></i>Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentInquiryId = null;

        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            document.getElementById('searchInquiries')?.addEventListener('keyup', filterTable);
            document.getElementById('statusFilter')?.addEventListener('change', filterTable);
            document.getElementById('destinationFilter')?.addEventListener('change', filterTable);
            document.getElementById('dateFilter')?.addEventListener('change', filterTable);
            
            document.getElementById('clearFilters')?.addEventListener('click', clearFilters);
        });

        function viewInquiry(id) {
            currentInquiryId = id;
            
            fetch(`get_inquiry_details.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Fill modal with data
                        document.getElementById('modalName').textContent = data.name;
                        document.getElementById('modalEmail').textContent = data.email;
                        document.getElementById('modalPhone').textContent = data.phone;
                        document.getElementById('modalTravelDate').textContent = data.travel_date;
                        document.getElementById('modalDestination').textContent = data.destination;
                        document.getElementById('modalTimeline').textContent = data.timeline;
                        document.getElementById('modalAdults').textContent = data.adults;
                        document.getElementById('modalChildren').textContent = data.children;
                        document.getElementById('modalTotal').textContent = data.total_travelers;
                        document.getElementById('modalComments').textContent = data.comments || 'No special requirements';
                        document.getElementById('modalDate').textContent = data.created_at;
                        document.getElementById('modalIP').textContent = data.ip_address || 'N/A';
                        document.getElementById('modalStatus').innerHTML = getStatusBadge(data.status);
                        
                        // Set reply email link
                        const subject = encodeURIComponent(`Re: Travel Inquiry for ${data.destination}`);
                        const body = encodeURIComponent(`Dear ${data.name},\n\nThank you for your interest in our ${data.destination} package.\n\nBest regards,\nVocation Travels Team`);
                        document.getElementById('replyBtn').href = `mailto:${data.email}?subject=${subject}&body=${body}`;
                        
                        // Show modal
                        new bootstrap.Modal(document.getElementById('inquiryModal')).show();
                        
                        // Mark as read if unread
                        if (data.status === 'unread') {
                            markAsRead(id, false);
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function markAsRead(id, reload = true) {
            fetch('mark_inquiry_read.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id: id })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && reload) {
                    location.reload();
                }
            });
        }

        function markAllAsRead() {
            if (confirm('Mark all inquiries as read?')) {
                fetch('mark_all_read.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                });
            }
        }

        function deleteInquiry(id) {
            if (confirm('Are you sure you want to delete this inquiry? This action cannot be undone.')) {
                fetch('delete_inquiry.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ id: id })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error deleting inquiry');
                    }
                });
            }
        }

        function filterTable() {
            const searchTerm = document.getElementById('searchInquiries').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value;
            const destinationFilter = document.getElementById('destinationFilter').value;
            const dateFilter = document.getElementById('dateFilter').value;

            const rows = document.querySelectorAll('#inquiriesTable tbody tr');

            rows.forEach(row => {
                let show = true;
                
                // Search filter
                if (searchTerm) {
                    const text = row.textContent.toLowerCase();
                    if (!text.includes(searchTerm)) show = false;
                }
                
                // Status filter
                if (show && statusFilter !== 'all') {
                    const status = row.querySelector('.status-badge')?.classList[1]?.replace('status-', '');
                    if (status !== statusFilter) show = false;
                }
                
                // Destination filter
                if (show && destinationFilter !== 'all') {
                    const destination = row.getAttribute('data-destination');
                    if (destination !== destinationFilter) show = false;
                }
                
                // Date filter
                if (show && dateFilter) {
                    const rowDate = row.getAttribute('data-date')?.split(' ')[0];
                    if (rowDate !== dateFilter) show = false;
                }
                
                row.style.display = show ? '' : 'none';
            });
        }

        function clearFilters() {
            document.getElementById('searchInquiries').value = '';
            document.getElementById('statusFilter').value = 'all';
            document.getElementById('destinationFilter').value = 'all';
            document.getElementById('dateFilter').value = '';
            
            const rows = document.querySelectorAll('#inquiriesTable tbody tr');
            rows.forEach(row => row.style.display = '');
        }

        function getStatusBadge(status) {
            const badges = {
                'unread': '<span class="badge bg-warning text-dark">Unread</span>',
                'read': '<span class="badge bg-info text-white">Read</span>',
                'replied': '<span class="badge bg-success text-white">Replied</span>'
            };
            return badges[status] || '<span class="badge bg-secondary">Unknown</span>';
        }
    </script>
</body>

</html>