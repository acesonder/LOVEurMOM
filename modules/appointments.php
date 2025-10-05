<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments - LOVEurMOM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php
    require_once '../includes/config.php';
    require_once '../includes/functions.php';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $appointment_date = sanitize_input($_POST['appointment_date']);
        $appointment_time = sanitize_input($_POST['appointment_time']);
        $doctor_name = sanitize_input($_POST['doctor_name']);
        $appointment_type = sanitize_input($_POST['appointment_type']);
        $location = sanitize_input($_POST['location']);
        $notes = sanitize_input($_POST['notes']);
        
        $sql = "INSERT INTO appointments (appointment_date, appointment_time, doctor_name, appointment_type, location, notes) 
                VALUES ('$appointment_date', '$appointment_time', '$doctor_name', '$appointment_type', '$location', '$notes')";
        
        if ($conn->query($sql)) {
            $success_message = "Appointment added successfully!";
        } else {
            $error_message = "Error adding appointment: " . $conn->error;
        }
    }
    
    $upcoming = $conn->query("SELECT * FROM appointments WHERE status = 'scheduled' AND appointment_date >= CURDATE() ORDER BY appointment_date, appointment_time");
    $past = $conn->query("SELECT * FROM appointments WHERE status = 'completed' OR appointment_date < CURDATE() ORDER BY appointment_date DESC, appointment_time DESC LIMIT 5");
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
                        <a class="nav-link active" href="appointments.php"><i class="bi bi-calendar-check"></i> Appointments</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid py-4">
        <h1><i class="bi bi-calendar-check"></i> Appointments</h1>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $success_message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row mb-4">
            <div class="col-12">
                <button class="btn btn-warning btn-lg" data-bs-toggle="modal" data-bs-target="#addAppointmentModal">
                    <i class="bi bi-plus-circle"></i> Add New Appointment
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header bg-warning">
                        <h5 class="mb-0"><i class="bi bi-calendar-event"></i> Upcoming Appointments</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($upcoming->num_rows > 0): ?>
                            <div class="list-group list-group-flush">
                                <?php while ($apt = $upcoming->fetch_assoc()): ?>
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1"><?php echo htmlspecialchars($apt['doctor_name']); ?></h6>
                                                <p class="mb-1">
                                                    <strong><?php echo format_date($apt['appointment_date']); ?></strong>
                                                    at <?php echo date('g:i A', strtotime($apt['appointment_time'])); ?>
                                                </p>
                                                <?php if ($apt['appointment_type']): ?>
                                                    <p class="mb-1 text-muted"><?php echo htmlspecialchars($apt['appointment_type']); ?></p>
                                                <?php endif; ?>
                                                <?php if ($apt['location']): ?>
                                                    <p class="mb-0 small"><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($apt['location']); ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">No upcoming appointments</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="bi bi-clock-history"></i> Past Appointments</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($past->num_rows > 0): ?>
                            <div class="list-group list-group-flush">
                                <?php while ($apt = $past->fetch_assoc()): ?>
                                    <div class="list-group-item">
                                        <h6 class="mb-1"><?php echo htmlspecialchars($apt['doctor_name']); ?></h6>
                                        <p class="mb-1"><?php echo format_date($apt['appointment_date']); ?></p>
                                        <?php if ($apt['appointment_type']): ?>
                                            <small class="text-muted"><?php echo htmlspecialchars($apt['appointment_type']); ?></small>
                                        <?php endif; ?>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">No past appointments</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Appointment Modal -->
    <div class="modal fade" id="addAppointmentModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Add New Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Appointment Date *</label>
                                <input type="date" name="appointment_date" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Appointment Time *</label>
                                <input type="time" name="appointment_time" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Doctor Name *</label>
                            <input type="text" name="doctor_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Appointment Type</label>
                            <select name="appointment_type" class="form-select">
                                <option value="">Select type...</option>
                                <option value="Consultation">Consultation</option>
                                <option value="Follow-up">Follow-up</option>
                                <option value="Treatment">Treatment</option>
                                <option value="Scan">Scan</option>
                                <option value="Lab Work">Lab Work</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Location</label>
                            <input type="text" name="location" class="form-control" placeholder="Clinic or hospital address">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning">Save Appointment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
