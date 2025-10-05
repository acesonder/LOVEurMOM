<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scans - LOVEurMOM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php
    require_once '../includes/config.php';
    require_once '../includes/functions.php';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $scan_date = sanitize_input($_POST['scan_date']);
        $scan_type = sanitize_input($_POST['scan_type']);
        $scan_location = sanitize_input($_POST['scan_location']);
        $findings = sanitize_input($_POST['findings']);
        $tumor_size = sanitize_input($_POST['tumor_size']);
        $tumor_markers = sanitize_input($_POST['tumor_markers']);
        $doctor_name = sanitize_input($_POST['doctor_name']);
        
        $sql = "INSERT INTO scans (scan_date, scan_type, scan_location, findings, tumor_size, tumor_markers, doctor_name) 
                VALUES ('$scan_date', '$scan_type', '$scan_location', '$findings', '$tumor_size', '$tumor_markers', '$doctor_name')";
        
        if ($conn->query($sql)) {
            $success_message = "Scan added successfully!";
        } else {
            $error_message = "Error adding scan: " . $conn->error;
        }
    }
    
    $scans = $conn->query("SELECT * FROM scans ORDER BY scan_date DESC");
    ?>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand fs-3" href="../index.php">
                <i class="bi bi-heart-fill"></i> LOVEurMOM
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php"><i class="bi bi-house-fill"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="scans.php"><i class="bi bi-camera-fill"></i> Scans</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid py-4">
        <h1><i class="bi bi-camera-fill"></i> Scan History</h1>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $success_message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row mb-4">
            <div class="col-12">
                <button class="btn btn-info btn-lg text-white" data-bs-toggle="modal" data-bs-target="#addScanModal">
                    <i class="bi bi-plus-circle"></i> Add New Scan
                </button>
            </div>
        </div>

        <div class="row">
            <?php if ($scans->num_rows > 0): ?>
                <?php while ($scan = $scans->fetch_assoc()): ?>
                    <div class="col-lg-6 mb-4">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">
                                    <i class="bi bi-camera-fill"></i> <?php echo htmlspecialchars($scan['scan_type']); ?>
                                </h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Date:</strong> <?php echo format_date($scan['scan_date']); ?></p>
                                <?php if ($scan['scan_location']): ?>
                                    <p><strong>Location:</strong> <?php echo htmlspecialchars($scan['scan_location']); ?></p>
                                <?php endif; ?>
                                <?php if ($scan['tumor_size']): ?>
                                    <p><strong>Tumor Size:</strong> <span class="badge bg-warning"><?php echo htmlspecialchars($scan['tumor_size']); ?></span></p>
                                <?php endif; ?>
                                <?php if ($scan['tumor_markers']): ?>
                                    <p><strong>Tumor Markers:</strong> <?php echo htmlspecialchars($scan['tumor_markers']); ?></p>
                                <?php endif; ?>
                                <?php if ($scan['findings']): ?>
                                    <p><strong>Findings:</strong><br><?php echo nl2br(htmlspecialchars($scan['findings'])); ?></p>
                                <?php endif; ?>
                                <?php if ($scan['doctor_name']): ?>
                                    <p class="mb-0"><strong>Doctor:</strong> <?php echo htmlspecialchars($scan['doctor_name']); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="empty-state">
                        <i class="bi bi-camera-fill"></i>
                        <h4>No scans recorded yet</h4>
                        <p>Click "Add New Scan" to get started</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Add Scan Modal -->
    <div class="modal fade" id="addScanModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Add New Scan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Scan Date *</label>
                                <input type="date" name="scan_date" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Scan Type *</label>
                                <select name="scan_type" class="form-select" required>
                                    <option value="">Select type...</option>
                                    <option value="CT Scan">CT Scan</option>
                                    <option value="MRI">MRI</option>
                                    <option value="PET Scan">PET Scan</option>
                                    <option value="X-Ray">X-Ray</option>
                                    <option value="Ultrasound">Ultrasound</option>
                                    <option value="Bone Scan">Bone Scan</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Scan Location</label>
                            <input type="text" name="scan_location" class="form-control" placeholder="e.g., Chest, Abdomen, Brain">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tumor Size</label>
                                <input type="text" name="tumor_size" class="form-control" placeholder="e.g., 3.2 cm">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tumor Markers</label>
                                <input type="text" name="tumor_markers" class="form-control" placeholder="e.g., CEA, CA 19-9">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Findings</label>
                            <textarea name="findings" class="form-control" rows="4" placeholder="Enter scan findings and observations..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Doctor Name</label>
                            <input type="text" name="doctor_name" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-info text-white">Save Scan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
