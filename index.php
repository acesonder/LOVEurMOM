<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOVEurMOM - Health Tracker</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php
    require_once 'includes/config.php';
    require_once 'includes/functions.php';
    
    // Get summary statistics
    $total_treatments = $conn->query("SELECT COUNT(*) as count FROM treatments")->fetch_assoc()['count'];
    $total_scans = $conn->query("SELECT COUNT(*) as count FROM scans")->fetch_assoc()['count'];
    $active_medications = $conn->query("SELECT COUNT(*) as count FROM medications WHERE is_active = 1")->fetch_assoc()['count'];
    $upcoming_appointments = $conn->query("SELECT COUNT(*) as count FROM appointments WHERE status = 'scheduled' AND appointment_date >= CURDATE()")->fetch_assoc()['count'];
    
    // Get recent treatments
    $recent_treatments = $conn->query("SELECT * FROM treatments ORDER BY treatment_date DESC LIMIT 5");
    
    // Get next appointment
    $next_appointment = $conn->query("SELECT * FROM appointments WHERE status = 'scheduled' AND appointment_date >= CURDATE() ORDER BY appointment_date ASC, appointment_time ASC LIMIT 1")->fetch_assoc();
    
    // Get latest scan
    $latest_scan = $conn->query("SELECT * FROM scans ORDER BY scan_date DESC LIMIT 1")->fetch_assoc();
    ?>
    
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand fs-3" href="index.php">
                <i class="bi bi-heart-fill"></i> LOVEurMOM
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php"><i class="bi bi-house-fill"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="modules/timeline.php"><i class="bi bi-clock-history"></i> Timeline</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="modules/symptoms.php"><i class="bi bi-heart-pulse"></i> Symptoms</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4 text-center">Health Dashboard</h1>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card stat-card text-white bg-primary">
                    <div class="card-body text-center">
                        <i class="bi bi-clipboard2-pulse fs-1"></i>
                        <h3 class="mt-3"><?php echo $total_treatments; ?></h3>
                        <p class="mb-0">Total Treatments</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card stat-card text-white bg-info">
                    <div class="card-body text-center">
                        <i class="bi bi-camera-fill fs-1"></i>
                        <h3 class="mt-3"><?php echo $total_scans; ?></h3>
                        <p class="mb-0">Scans Completed</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card stat-card text-white bg-success">
                    <div class="card-body text-center">
                        <i class="bi bi-capsule fs-1"></i>
                        <h3 class="mt-3"><?php echo $active_medications; ?></h3>
                        <p class="mb-0">Active Medications</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card stat-card text-white bg-warning">
                    <div class="card-body text-center">
                        <i class="bi bi-calendar-check fs-1"></i>
                        <h3 class="mt-3"><?php echo $upcoming_appointments; ?></h3>
                        <p class="mb-0">Upcoming Appointments</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Action Buttons -->
        <div class="row mb-4">
            <div class="col-12">
                <h3 class="mb-3">Quick Actions</h3>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <a href="modules/treatments.php" class="btn btn-action btn-primary w-100 py-4">
                    <i class="bi bi-clipboard2-pulse fs-2"></i>
                    <div class="mt-2">Treatments</div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <a href="modules/scans.php" class="btn btn-action btn-info w-100 py-4 text-white">
                    <i class="bi bi-camera-fill fs-2"></i>
                    <div class="mt-2">Scans</div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <a href="modules/symptoms.php" class="btn btn-action btn-danger w-100 py-4">
                    <i class="bi bi-heart-pulse fs-2"></i>
                    <div class="mt-2">Log Symptoms</div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <a href="modules/medications.php" class="btn btn-action btn-success w-100 py-4">
                    <i class="bi bi-capsule fs-2"></i>
                    <div class="mt-2">Medications</div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <a href="modules/appointments.php" class="btn btn-action btn-warning w-100 py-4">
                    <i class="bi bi-calendar-check fs-2"></i>
                    <div class="mt-2">Appointments</div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <a href="modules/diagnoses.php" class="btn btn-action btn-secondary w-100 py-4">
                    <i class="bi bi-file-medical fs-2"></i>
                    <div class="mt-2">Diagnoses</div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <a href="modules/timeline.php" class="btn btn-action btn-dark w-100 py-4">
                    <i class="bi bi-clock-history fs-2"></i>
                    <div class="mt-2">Timeline</div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <a href="modules/tumor_tracking.php" class="btn btn-action btn-outline-primary w-100 py-4">
                    <i class="bi bi-graph-up fs-2"></i>
                    <div class="mt-2">Tumor Progress</div>
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-clock-history"></i> Recent Treatments</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($recent_treatments->num_rows > 0): ?>
                            <div class="list-group list-group-flush">
                                <?php while ($treatment = $recent_treatments->fetch_assoc()): ?>
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">
                                                    <?php echo get_treatment_icon($treatment['treatment_type']); ?>
                                                    <?php echo htmlspecialchars($treatment['treatment_name']); ?>
                                                </h6>
                                                <small class="text-muted">
                                                    <?php echo format_date($treatment['treatment_date']); ?>
                                                </small>
                                            </div>
                                            <span class="badge bg-<?php echo get_status_badge($treatment['status']); ?>">
                                                <?php echo ucfirst($treatment['status']); ?>
                                            </span>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">No treatments recorded yet.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card mb-3">
                    <div class="card-header bg-warning">
                        <h5 class="mb-0"><i class="bi bi-calendar-check"></i> Next Appointment</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($next_appointment): ?>
                            <h6><?php echo htmlspecialchars($next_appointment['doctor_name']); ?></h6>
                            <p class="mb-1"><strong>Date:</strong> <?php echo format_date($next_appointment['appointment_date']); ?></p>
                            <p class="mb-1"><strong>Time:</strong> <?php echo date('g:i A', strtotime($next_appointment['appointment_time'])); ?></p>
                            <?php if ($next_appointment['appointment_type']): ?>
                                <p class="mb-1"><strong>Type:</strong> <?php echo htmlspecialchars($next_appointment['appointment_type']); ?></p>
                            <?php endif; ?>
                            <?php if ($next_appointment['location']): ?>
                                <p class="mb-0"><strong>Location:</strong> <?php echo htmlspecialchars($next_appointment['location']); ?></p>
                            <?php endif; ?>
                        <?php else: ?>
                            <p class="text-muted">No upcoming appointments scheduled.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="bi bi-camera-fill"></i> Latest Scan</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($latest_scan): ?>
                            <h6><?php echo htmlspecialchars($latest_scan['scan_type']); ?></h6>
                            <p class="mb-1"><strong>Date:</strong> <?php echo format_date($latest_scan['scan_date']); ?></p>
                            <?php if ($latest_scan['tumor_size']): ?>
                                <p class="mb-1"><strong>Tumor Size:</strong> <?php echo htmlspecialchars($latest_scan['tumor_size']); ?></p>
                            <?php endif; ?>
                            <?php if ($latest_scan['findings']): ?>
                                <p class="mb-0"><strong>Findings:</strong> <?php echo htmlspecialchars($latest_scan['findings']); ?></p>
                            <?php endif; ?>
                        <?php else: ?>
                            <p class="text-muted">No scans recorded yet.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
