<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagnoses - LOVEurMOM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php
    require_once '../includes/config.php';
    require_once '../includes/functions.php';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $diagnosis_date = sanitize_input($_POST['diagnosis_date']);
        $diagnosis_type = sanitize_input($_POST['diagnosis_type']);
        $stage = sanitize_input($_POST['stage']);
        $location = sanitize_input($_POST['location']);
        $doctor_name = sanitize_input($_POST['doctor_name']);
        $notes = sanitize_input($_POST['notes']);
        
        $sql = "INSERT INTO diagnoses (diagnosis_date, diagnosis_type, stage, location, doctor_name, notes) 
                VALUES ('$diagnosis_date', '$diagnosis_type', '$stage', '$location', '$doctor_name', '$notes')";
        
        if ($conn->query($sql)) {
            $success_message = "Diagnosis added successfully!";
        } else {
            $error_message = "Error adding diagnosis: " . $conn->error;
        }
    }
    
    $diagnoses = $conn->query("SELECT * FROM diagnoses ORDER BY diagnosis_date DESC");
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
                        <a class="nav-link active" href="diagnoses.php"><i class="bi bi-file-medical"></i> Diagnoses</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid py-4">
        <h1><i class="bi bi-file-medical"></i> Diagnosis History</h1>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $success_message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row mb-4">
            <div class="col-12">
                <button class="btn btn-secondary btn-lg" data-bs-toggle="modal" data-bs-target="#addDiagnosisModal">
                    <i class="bi bi-plus-circle"></i> Add New Diagnosis
                </button>
            </div>
        </div>

        <div class="row">
            <?php if ($diagnoses->num_rows > 0): ?>
                <?php while ($diagnosis = $diagnoses->fetch_assoc()): ?>
                    <div class="col-lg-6 mb-4">
                        <div class="card">
                            <div class="card-header bg-danger text-white">
                                <h5 class="mb-0">
                                    <i class="bi bi-file-medical-fill"></i> <?php echo htmlspecialchars($diagnosis['diagnosis_type']); ?>
                                </h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Date:</strong> <?php echo format_date($diagnosis['diagnosis_date']); ?></p>
                                <?php if ($diagnosis['stage']): ?>
                                    <p><strong>Stage:</strong> <span class="badge bg-danger"><?php echo htmlspecialchars($diagnosis['stage']); ?></span></p>
                                <?php endif; ?>
                                <?php if ($diagnosis['location']): ?>
                                    <p><strong>Location:</strong> <?php echo htmlspecialchars($diagnosis['location']); ?></p>
                                <?php endif; ?>
                                <?php if ($diagnosis['notes']): ?>
                                    <p><strong>Notes:</strong><br><?php echo nl2br(htmlspecialchars($diagnosis['notes'])); ?></p>
                                <?php endif; ?>
                                <?php if ($diagnosis['doctor_name']): ?>
                                    <p class="mb-0"><strong>Doctor:</strong> <?php echo htmlspecialchars($diagnosis['doctor_name']); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="empty-state">
                        <i class="bi bi-file-medical"></i>
                        <h4>No diagnoses recorded yet</h4>
                        <p>Click "Add New Diagnosis" to get started</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Add Diagnosis Modal -->
    <div class="modal fade" id="addDiagnosisModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Add New Diagnosis</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Diagnosis Date *</label>
                                <input type="date" name="diagnosis_date" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Stage</label>
                                <input type="text" name="stage" class="form-control" placeholder="e.g., Stage IV">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Diagnosis Type *</label>
                            <input type="text" name="diagnosis_type" class="form-control" placeholder="e.g., Adenocarcinoma" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Location</label>
                            <input type="text" name="location" class="form-control" placeholder="e.g., Lung, Breast">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Doctor Name</label>
                            <input type="text" name="doctor_name" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-secondary">Save Diagnosis</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
