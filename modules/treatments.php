<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Treatments - LOVEurMOM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php
    require_once '../includes/config.php';
    require_once '../includes/functions.php';
    
    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $treatment_date = sanitize_input($_POST['treatment_date']);
        $treatment_type = sanitize_input($_POST['treatment_type']);
        $treatment_name = sanitize_input($_POST['treatment_name']);
        $doctor_name = sanitize_input($_POST['doctor_name']);
        $location = sanitize_input($_POST['location']);
        $dosage = sanitize_input($_POST['dosage']);
        $duration = sanitize_input($_POST['duration']);
        $side_effects = sanitize_input($_POST['side_effects']);
        $notes = sanitize_input($_POST['notes']);
        $status = sanitize_input($_POST['status']);
        
        $sql = "INSERT INTO treatments (treatment_date, treatment_type, treatment_name, doctor_name, location, dosage, duration, side_effects, notes, status) 
                VALUES ('$treatment_date', '$treatment_type', '$treatment_name', '$doctor_name', '$location', '$dosage', '$duration', '$side_effects', '$notes', '$status')";
        
        if ($conn->query($sql)) {
            $success_message = "Treatment added successfully!";
        } else {
            $error_message = "Error adding treatment: " . $conn->error;
        }
    }
    
    // Get all treatments
    $treatments = $conn->query("SELECT * FROM treatments ORDER BY treatment_date DESC");
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
                        <a class="nav-link active" href="treatments.php"><i class="bi bi-clipboard2-pulse"></i> Treatments</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <h1><i class="bi bi-clipboard2-pulse"></i> Treatment History</h1>
            </div>
        </div>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $success_message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $error_message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row mb-4">
            <div class="col-12">
                <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addTreatmentModal">
                    <i class="bi bi-plus-circle"></i> Add New Treatment
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <?php if ($treatments->num_rows > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>Treatment Name</th>
                                            <th>Doctor</th>
                                            <th>Status</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($treatment = $treatments->fetch_assoc()): ?>
                                            <tr>
                                                <td><?php echo format_date($treatment['treatment_date']); ?></td>
                                                <td>
                                                    <?php echo get_treatment_icon($treatment['treatment_type']); ?>
                                                    <?php echo ucfirst(str_replace('_', ' ', $treatment['treatment_type'])); ?>
                                                </td>
                                                <td><strong><?php echo htmlspecialchars($treatment['treatment_name']); ?></strong></td>
                                                <td><?php echo htmlspecialchars($treatment['doctor_name']); ?></td>
                                                <td>
                                                    <span class="badge bg-<?php echo get_status_badge($treatment['status']); ?>">
                                                        <?php echo ucfirst($treatment['status']); ?>
                                                    </span>
                                                </td>
                                                <td><?php echo htmlspecialchars(substr($treatment['notes'], 0, 50)); ?><?php echo strlen($treatment['notes']) > 50 ? '...' : ''; ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="empty-state">
                                <i class="bi bi-clipboard2-pulse"></i>
                                <h4>No treatments recorded yet</h4>
                                <p>Click "Add New Treatment" to get started</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Treatment Modal -->
    <div class="modal fade" id="addTreatmentModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Add New Treatment</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Treatment Date *</label>
                                <input type="date" name="treatment_date" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Treatment Type *</label>
                                <select name="treatment_type" class="form-select" required>
                                    <option value="">Select type...</option>
                                    <option value="surgery">🏥 Surgery</option>
                                    <option value="chemotherapy">💉 Chemotherapy</option>
                                    <option value="immunotherapy">🧬 Immunotherapy</option>
                                    <option value="radiation">☢️ Radiation</option>
                                    <option value="clinical_trial">🔬 Clinical Trial</option>
                                    <option value="other">📋 Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Treatment Name *</label>
                            <input type="text" name="treatment_name" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Doctor Name</label>
                                <input type="text" name="doctor_name" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="scheduled">Scheduled</option>
                                    <option value="ongoing">Ongoing</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Location</label>
                            <input type="text" name="location" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Dosage</label>
                                <input type="text" name="dosage" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Duration</label>
                                <input type="text" name="duration" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Side Effects</label>
                            <textarea name="side_effects" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Treatment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
