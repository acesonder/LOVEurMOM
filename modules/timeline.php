<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Treatment Timeline - LOVEurMOM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php
    require_once '../includes/config.php';
    require_once '../includes/functions.php';
    
    // Get all events for timeline (treatments, scans, diagnoses)
    $timeline_query = "
        SELECT 'treatment' as event_type, treatment_date as event_date, treatment_type as type_detail, 
               treatment_name as title, notes, status, doctor_name
        FROM treatments
        UNION ALL
        SELECT 'scan' as event_type, scan_date as event_date, scan_type as type_detail,
               CONCAT(scan_type, ' - ', COALESCE(tumor_size, 'Size not recorded')) as title, 
               findings as notes, 'completed' as status, doctor_name
        FROM scans
        UNION ALL
        SELECT 'diagnosis' as event_type, diagnosis_date as event_date, stage as type_detail,
               diagnosis_type as title, notes, 'confirmed' as status, doctor_name
        FROM diagnoses
        ORDER BY event_date DESC
    ";
    
    $timeline_events = $conn->query($timeline_query);
    
    // Get treatment type counts
    $treatment_counts = $conn->query("
        SELECT treatment_type, COUNT(*) as count 
        FROM treatments 
        GROUP BY treatment_type
    ");
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
                        <a class="nav-link active" href="timeline.php"><i class="bi bi-clock-history"></i> Timeline</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <h1><i class="bi bi-clock-history"></i> Treatment Timeline</h1>
                <p class="lead">Visual overview of your complete health journey</p>
            </div>
        </div>

        <!-- Treatment Summary Cards -->
        <div class="row mb-4">
            <?php 
            $colors = [
                'surgery' => 'danger',
                'chemotherapy' => 'primary',
                'immunotherapy' => 'info',
                'radiation' => 'warning',
                'clinical_trial' => 'success',
                'other' => 'secondary'
            ];
            
            while ($count = $treatment_counts->fetch_assoc()): 
                $color = $colors[$count['treatment_type']] ?? 'secondary';
            ?>
                <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                    <div class="card text-white bg-<?php echo $color; ?>">
                        <div class="card-body text-center">
                            <div class="fs-2"><?php echo get_treatment_icon($count['treatment_type']); ?></div>
                            <h4 class="mt-2"><?php echo $count['count']; ?></h4>
                            <p class="mb-0 small"><?php echo ucfirst(str_replace('_', ' ', $count['treatment_type'])); ?></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Timeline -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-calendar-event"></i> Complete Timeline</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($timeline_events->num_rows > 0): ?>
                            <div class="timeline">
                                <?php 
                                $current_month = '';
                                while ($event = $timeline_events->fetch_assoc()): 
                                    $event_month = date('F Y', strtotime($event['event_date']));
                                    
                                    // Show month header if it's a new month
                                    if ($event_month != $current_month):
                                        $current_month = $event_month;
                                ?>
                                    <div class="timeline-month mb-4">
                                        <h4 class="text-primary"><i class="bi bi-calendar3"></i> <?php echo $current_month; ?></h4>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="timeline-item">
                                    <?php
                                    $marker_class = 'bg-secondary';
                                    $icon = '📋';
                                    
                                    if ($event['event_type'] == 'treatment') {
                                        $marker_class = 'bg-primary';
                                        $icon = get_treatment_icon($event['type_detail']);
                                    } elseif ($event['event_type'] == 'scan') {
                                        $marker_class = 'bg-info';
                                        $icon = '📷';
                                    } elseif ($event['event_type'] == 'diagnosis') {
                                        $marker_class = 'bg-danger';
                                        $icon = '🏥';
                                    }
                                    ?>
                                    <div class="timeline-marker <?php echo $marker_class; ?>">
                                        <?php echo $icon; ?>
                                    </div>
                                    <div class="timeline-content">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h5 class="mb-1"><?php echo htmlspecialchars($event['title']); ?></h5>
                                                <p class="text-muted mb-0">
                                                    <i class="bi bi-calendar3"></i> <?php echo format_date($event['event_date']); ?>
                                                    <?php if ($event['doctor_name']): ?>
                                                        | <i class="bi bi-person-fill"></i> <?php echo htmlspecialchars($event['doctor_name']); ?>
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                            <?php if ($event['status'] && $event['event_type'] == 'treatment'): ?>
                                                <span class="badge bg-<?php echo get_status_badge($event['status']); ?>">
                                                    <?php echo ucfirst($event['status']); ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <?php if ($event['notes']): ?>
                                            <p class="mb-0"><?php echo htmlspecialchars($event['notes']); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endwhile; ?>
                            </div>
                        <?php else: ?>
                            <div class="empty-state">
                                <i class="bi bi-clock-history"></i>
                                <h4>No timeline events yet</h4>
                                <p>Start adding treatments, scans, and diagnoses to build your timeline</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
