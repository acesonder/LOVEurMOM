<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medications - LOVEurMOM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php
    require_once '../includes/config.php';
    require_once '../includes/functions.php';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $medication_name = sanitize_input($_POST['medication_name']);
        $dosage = sanitize_input($_POST['dosage']);
        $frequency = sanitize_input($_POST['frequency']);
        $purpose = sanitize_input($_POST['purpose']);
        $start_date = sanitize_input($_POST['start_date']);
        $prescribing_doctor = sanitize_input($_POST['prescribing_doctor']);
        $notes = sanitize_input($_POST['notes']);
        
        $sql = "INSERT INTO medications (medication_name, dosage, frequency, purpose, start_date, prescribing_doctor, notes) 
                VALUES ('$medication_name', '$dosage', '$frequency', '$purpose', '$start_date', '$prescribing_doctor', '$notes')";
        
        if ($conn->query($sql)) {
            $success_message = "Medication added successfully!";
        } else {
            $error_message = "Error adding medication: " . $conn->error;
        }
    }
    
    $active_meds = $conn->query("SELECT * FROM medications WHERE is_active = 1 ORDER BY medication_name");
    $inactive_meds = $conn->query("SELECT * FROM medications WHERE is_active = 0 ORDER BY medication_name");
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
                        <a class="nav-link active" href="medications.php"><i class="bi bi-capsule"></i> Medications</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid py-4">
        <h1><i class="bi bi-capsule"></i> Medication List</h1>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $success_message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row mb-4">
            <div class="col-12">
                <button class="btn btn-success btn-lg" data-bs-toggle="modal" data-bs-target="#addMedicationModal">
                    <i class="bi bi-plus-circle"></i> Add New Medication
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-check-circle"></i> Active Medications</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($active_meds->num_rows > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Medication</th>
                                            <th>Dosage</th>
                                            <th>Frequency</th>
                                            <th>Purpose</th>
                                            <th>Start Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($med = $active_meds->fetch_assoc()): ?>
                                            <tr>
                                                <td><strong><?php echo htmlspecialchars($med['medication_name']); ?></strong></td>
                                                <td><?php echo htmlspecialchars($med['dosage']); ?></td>
                                                <td><?php echo htmlspecialchars($med['frequency']); ?></td>
                                                <td><?php echo htmlspecialchars($med['purpose']); ?></td>
                                                <td><?php echo format_date($med['start_date']); ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">No active medications</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Medication Modal -->
    <div class="modal fade" id="addMedicationModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Add New Medication</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Medication Name *</label>
                            <input type="text" name="medication_name" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Dosage *</label>
                                <input type="text" name="dosage" class="form-control" placeholder="e.g., 500mg" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Frequency *</label>
                                <input type="text" name="frequency" class="form-control" placeholder="e.g., Twice daily" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Purpose</label>
                            <input type="text" name="purpose" class="form-control" placeholder="e.g., Pain relief">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Start Date *</label>
                                <input type="date" name="start_date" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Prescribing Doctor</label>
                                <input type="text" name="prescribing_doctor" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Save Medication</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
