<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tumor Progression - LOVEurMOM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php
    require_once '../includes/config.php';
    require_once '../includes/functions.php';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $measurement_date = sanitize_input($_POST['measurement_date']);
        $tumor_location = sanitize_input($_POST['tumor_location']);
        $size_cm = sanitize_input($_POST['size_cm']);
        $progression_status = sanitize_input($_POST['progression_status']);
        $notes = sanitize_input($_POST['notes']);
        
        $sql = "INSERT INTO tumor_progression (measurement_date, tumor_location, size_cm, progression_status, notes) 
                VALUES ('$measurement_date', '$tumor_location', '$size_cm', '$progression_status', '$notes')";
        
        if ($conn->query($sql)) {
            $success_message = "Tumor measurement added successfully!";
        } else {
            $error_message = "Error adding measurement: " . $conn->error;
        }
    }
    
    // Get progression data for chart
    $progression_data = $conn->query("SELECT measurement_date, tumor_location, size_cm, progression_status FROM tumor_progression ORDER BY measurement_date ASC");
    $chart_dates = [];
    $chart_sizes = [];
    
    while ($row = $progression_data->fetch_assoc()) {
        $chart_dates[] = format_date($row['measurement_date']);
        $chart_sizes[] = $row['size_cm'];
    }
    
    // Get all tumor tracking records
    $tumors = $conn->query("SELECT * FROM tumor_progression ORDER BY measurement_date DESC");
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
                        <a class="nav-link active" href="tumor_tracking.php"><i class="bi bi-graph-up"></i> Tumor Tracking</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid py-4">
        <h1><i class="bi bi-graph-up"></i> Tumor Progression Tracking</h1>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $success_message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row mb-4">
            <div class="col-12">
                <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addMeasurementModal">
                    <i class="bi bi-plus-circle"></i> Add New Measurement
                </button>
            </div>
        </div>

        <?php if (!empty($chart_dates)): ?>
        <!-- Chart Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-bar-chart-line"></i> Tumor Size Over Time</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="tumorChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Measurement History -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="bi bi-list-ul"></i> Measurement History</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($tumors->num_rows > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Location</th>
                                            <th>Size (cm)</th>
                                            <th>Status</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $tumors->data_seek(0); // Reset pointer
                                        while ($tumor = $tumors->fetch_assoc()): 
                                            $status_colors = [
                                                'stable' => 'primary',
                                                'growing' => 'danger',
                                                'shrinking' => 'success',
                                                'new' => 'warning',
                                                'resolved' => 'info'
                                            ];
                                            $status_color = $status_colors[$tumor['progression_status']] ?? 'secondary';
                                        ?>
                                            <tr>
                                                <td><?php echo format_date($tumor['measurement_date']); ?></td>
                                                <td><?php echo htmlspecialchars($tumor['tumor_location']); ?></td>
                                                <td><strong><?php echo $tumor['size_cm']; ?> cm</strong></td>
                                                <td>
                                                    <span class="badge bg-<?php echo $status_color; ?>">
                                                        <?php echo ucfirst($tumor['progression_status']); ?>
                                                    </span>
                                                </td>
                                                <td><?php echo htmlspecialchars(substr($tumor['notes'], 0, 50)); ?><?php echo strlen($tumor['notes']) > 50 ? '...' : ''; ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="empty-state">
                                <i class="bi bi-graph-up"></i>
                                <h4>No tumor measurements recorded yet</h4>
                                <p>Click "Add New Measurement" to start tracking tumor progression</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Measurement Modal -->
    <div class="modal fade" id="addMeasurementModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Add New Measurement</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Measurement Date *</label>
                                <input type="date" name="measurement_date" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tumor Location *</label>
                                <input type="text" name="tumor_location" class="form-control" placeholder="e.g., Right lung" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Size (cm) *</label>
                                <input type="number" step="0.1" name="size_cm" class="form-control" placeholder="e.g., 3.2" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Progression Status *</label>
                                <select name="progression_status" class="form-select" required>
                                    <option value="">Select status...</option>
                                    <option value="stable">Stable</option>
                                    <option value="shrinking">Shrinking</option>
                                    <option value="growing">Growing</option>
                                    <option value="new">New</option>
                                    <option value="resolved">Resolved</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" class="form-control" rows="3" placeholder="Additional observations..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Measurement</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <?php if (!empty($chart_dates)): ?>
    <script>
        const ctx = document.getElementById('tumorChart');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($chart_dates); ?>,
                datasets: [{
                    label: 'Tumor Size (cm)',
                    data: <?php echo json_encode($chart_sizes); ?>,
                    borderColor: 'rgb(13, 110, 253)',
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    borderWidth: 3,
                    tension: 0.1,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            font: {
                                size: 14
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: 'Tumor Size Progression',
                        font: {
                            size: 18
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Size (cm)',
                            font: {
                                size: 14
                            }
                        },
                        ticks: {
                            font: {
                                size: 12
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Measurement Date',
                            font: {
                                size: 14
                            }
                        },
                        ticks: {
                            font: {
                                size: 12
                            }
                        }
                    }
                }
            }
        });
    </script>
    <?php endif; ?>
</body>
</html>
