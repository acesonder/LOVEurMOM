<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Symptoms & AI Help - LOVEurMOM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php
    require_once '../includes/config.php';
    require_once '../includes/functions.php';
    
    $show_suggestions = false;
    $suggestions = [];
    
    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $symptom_date = sanitize_input($_POST['symptom_date']);
        $symptom_time = sanitize_input($_POST['symptom_time']);
        $symptom_type = sanitize_input($_POST['symptom_type']);
        $severity = sanitize_input($_POST['severity']);
        $location = sanitize_input($_POST['location']);
        $description = sanitize_input($_POST['description']);
        $triggers = sanitize_input($_POST['triggers']);
        
        $sql = "INSERT INTO symptoms (symptom_date, symptom_time, symptom_type, severity, location, description, triggers) 
                VALUES ('$symptom_date', '$symptom_time', '$symptom_type', '$severity', '$location', '$description', '$triggers')";
        
        if ($conn->query($sql)) {
            $symptom_id = $conn->insert_id;
            $success_message = "Symptom logged successfully!";
            
            // Generate AI suggestions
            $suggestions = get_ai_pain_suggestion($symptom_type, $severity, $location);
            $show_suggestions = true;
            
            // Save AI suggestions
            foreach ($suggestions as $suggestion) {
                $suggestion_escaped = $conn->real_escape_string($suggestion);
                $conn->query("INSERT INTO ai_suggestions (suggestion_date, symptom_id, suggestion_type, suggestion_text) 
                             VALUES (CURDATE(), $symptom_id, 'pain_management', '$suggestion_escaped')");
            }
        } else {
            $error_message = "Error logging symptom: " . $conn->error;
        }
    }
    
    // Get recent symptoms
    $recent_symptoms = $conn->query("SELECT * FROM symptoms ORDER BY symptom_date DESC, symptom_time DESC LIMIT 10");
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
                        <a class="nav-link active" href="symptoms.php"><i class="bi bi-heart-pulse"></i> Symptoms</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <h1><i class="bi bi-heart-pulse"></i> Symptom Tracker with AI Support</h1>
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

        <?php if ($show_suggestions && !empty($suggestions)): ?>
            <div class="ai-suggestion">
                <h5><i class="bi bi-robot"></i> AI-Powered Suggestions for Relief</h5>
                <p>Based on your symptom severity and type, here are some suggestions:</p>
                <ul>
                    <?php foreach ($suggestions as $suggestion): ?>
                        <li><?php echo htmlspecialchars($suggestion); ?></li>
                    <?php endforeach; ?>
                </ul>
                <p class="mb-0"><small><i class="bi bi-info-circle"></i> These are general suggestions. Always consult your healthcare provider for medical advice.</small></p>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Log New Symptom</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" id="symptomForm">
                            <div class="mb-3">
                                <label class="form-label">Date *</label>
                                <input type="date" name="symptom_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Time</label>
                                <input type="time" name="symptom_time" class="form-control" value="<?php echo date('H:i'); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Symptom Type *</label>
                                <select name="symptom_type" class="form-select" required>
                                    <option value="">Select symptom...</option>
                                    <option value="Pain">Pain</option>
                                    <option value="Nausea">Nausea</option>
                                    <option value="Fatigue">Fatigue</option>
                                    <option value="Headache">Headache</option>
                                    <option value="Anxiety">Anxiety</option>
                                    <option value="Shortness of breath">Shortness of breath</option>
                                    <option value="Loss of appetite">Loss of appetite</option>
                                    <option value="Insomnia">Insomnia</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pain/Severity Level (1-10) *</label>
                                <p class="text-muted small">1 = Very mild, 10 = Worst possible</p>
                                <div class="pain-scale" id="painScale">
                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                        <div class="pain-level pain-<?php echo $i; ?>" data-value="<?php echo $i; ?>"><?php echo $i; ?></div>
                                    <?php endfor; ?>
                                </div>
                                <input type="hidden" name="severity" id="severityInput" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Location (if applicable)</label>
                                <input type="text" name="location" class="form-control" placeholder="e.g., chest, abdomen, head">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3" placeholder="Describe how you're feeling..."></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Triggers (if any)</label>
                                <textarea name="triggers" class="form-control" rows="2" placeholder="What seems to cause or worsen the symptom?"></textarea>
                            </div>
                            <button type="submit" class="btn btn-danger btn-lg w-100">
                                <i class="bi bi-check-circle"></i> Log Symptom & Get AI Suggestions
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="bi bi-clock-history"></i> Recent Symptoms</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($recent_symptoms->num_rows > 0): ?>
                            <div class="list-group list-group-flush">
                                <?php while ($symptom = $recent_symptoms->fetch_assoc()): ?>
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1"><?php echo htmlspecialchars($symptom['symptom_type']); ?></h6>
                                                <p class="mb-1">
                                                    <strong>Severity:</strong> 
                                                    <span class="badge bg-<?php echo get_severity_class($symptom['severity']); ?>">
                                                        <?php echo $symptom['severity']; ?>/10
                                                    </span>
                                                </p>
                                                <?php if ($symptom['location']): ?>
                                                    <p class="mb-1"><strong>Location:</strong> <?php echo htmlspecialchars($symptom['location']); ?></p>
                                                <?php endif; ?>
                                                <small class="text-muted">
                                                    <?php echo format_date($symptom['symptom_date']); ?>
                                                    <?php if ($symptom['symptom_time']): ?>
                                                        at <?php echo date('g:i A', strtotime($symptom['symptom_time'])); ?>
                                                    <?php endif; ?>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php else: ?>
                            <div class="empty-state">
                                <i class="bi bi-heart-pulse"></i>
                                <h4>No symptoms logged yet</h4>
                                <p>Start tracking your symptoms to get AI-powered suggestions</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Pain scale interactive selection
        document.querySelectorAll('.pain-level').forEach(level => {
            level.addEventListener('click', function() {
                document.querySelectorAll('.pain-level').forEach(l => l.classList.remove('selected'));
                this.classList.add('selected');
                document.getElementById('severityInput').value = this.dataset.value;
            });
        });
        
        // Validate form
        document.getElementById('symptomForm').addEventListener('submit', function(e) {
            if (!document.getElementById('severityInput').value) {
                e.preventDefault();
                alert('Please select a severity level (1-10)');
            }
        });
    </script>
</body>
</html>
