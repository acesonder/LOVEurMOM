<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation Test - LOVEurMOM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 20px; }
        .test-item { margin: 10px 0; padding: 10px; border-radius: 5px; }
        .test-pass { background-color: #d4edda; border: 1px solid #c3e6cb; }
        .test-fail { background-color: #f8d7da; border: 1px solid #f5c6cb; }
        .test-warning { background-color: #fff3cd; border: 1px solid #ffeaa7; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">LOVEurMOM - Installation Test</h1>
        <p class="lead">This page will test your installation and show you what's working and what needs attention.</p>
        <hr>

        <?php
        $allPassed = true;
        $tests = [];

        // Test 1: PHP Version
        $phpVersion = phpversion();
        $phpOK = version_compare($phpVersion, '7.4.0', '>=');
        $tests[] = [
            'name' => 'PHP Version',
            'status' => $phpOK,
            'message' => $phpOK ? "PHP $phpVersion ✓" : "PHP $phpVersion - Need 7.4 or higher",
            'severity' => $phpOK ? 'pass' : 'fail'
        ];
        if (!$phpOK) $allPassed = false;

        // Test 2: MySQLi Extension
        $mysqliOK = extension_loaded('mysqli');
        $tests[] = [
            'name' => 'MySQLi Extension',
            'status' => $mysqliOK,
            'message' => $mysqliOK ? 'MySQLi extension loaded ✓' : 'MySQLi extension NOT loaded',
            'severity' => $mysqliOK ? 'pass' : 'fail'
        ];
        if (!$mysqliOK) $allPassed = false;

        // Test 3: Config File
        $configExists = file_exists('includes/config.php');
        $tests[] = [
            'name' => 'Configuration File',
            'status' => $configExists,
            'message' => $configExists ? 'config.php found ✓' : 'config.php NOT found',
            'severity' => $configExists ? 'pass' : 'fail'
        ];
        if (!$configExists) $allPassed = false;

        // Test 4: Database Connection
        $dbConnected = false;
        $dbMessage = '';
        if ($configExists) {
            require_once 'includes/config.php';
            if ($conn && !$conn->connect_error) {
                $dbConnected = true;
                $dbMessage = 'Database connected successfully ✓';
            } else {
                $dbMessage = 'Database connection failed: ' . ($conn ? $conn->connect_error : 'Connection object not created');
                $allPassed = false;
            }
        } else {
            $dbMessage = 'Cannot test - config.php missing';
            $allPassed = false;
        }
        $tests[] = [
            'name' => 'Database Connection',
            'status' => $dbConnected,
            'message' => $dbMessage,
            'severity' => $dbConnected ? 'pass' : 'fail'
        ];

        // Test 5: Database Tables
        $tablesOK = false;
        $tableMessage = '';
        if ($dbConnected) {
            $requiredTables = ['diagnoses', 'scans', 'treatments', 'tumor_progression', 'symptoms', 'medications', 'ai_suggestions', 'appointments'];
            $result = $conn->query("SHOW TABLES");
            $existingTables = [];
            if ($result) {
                while ($row = $result->fetch_array()) {
                    $existingTables[] = $row[0];
                }
            }
            $missingTables = array_diff($requiredTables, $existingTables);
            if (empty($missingTables)) {
                $tablesOK = true;
                $tableMessage = 'All 8 required tables found ✓';
            } else {
                $tableMessage = 'Missing tables: ' . implode(', ', $missingTables);
                $allPassed = false;
            }
        } else {
            $tableMessage = 'Cannot test - database not connected';
            $allPassed = false;
        }
        $tests[] = [
            'name' => 'Database Tables',
            'status' => $tablesOK,
            'message' => $tableMessage,
            'severity' => $tablesOK ? 'pass' : 'fail'
        ];

        // Test 6: Required Files
        $requiredFiles = [
            'index.php',
            'includes/functions.php',
            'assets/css/style.css',
            'assets/js/app.js',
            'modules/treatments.php',
            'modules/scans.php',
            'modules/symptoms.php',
            'modules/timeline.php',
            'modules/tumor_tracking.php',
            'modules/medications.php',
            'modules/appointments.php',
            'modules/diagnoses.php'
        ];
        $missingFiles = [];
        foreach ($requiredFiles as $file) {
            if (!file_exists($file)) {
                $missingFiles[] = $file;
            }
        }
        $filesOK = empty($missingFiles);
        $tests[] = [
            'name' => 'Required Files',
            'status' => $filesOK,
            'message' => $filesOK ? 'All required files present ✓' : 'Missing files: ' . implode(', ', $missingFiles),
            'severity' => $filesOK ? 'pass' : 'fail'
        ];
        if (!$filesOK) $allPassed = false;

        // Display Results
        foreach ($tests as $test) {
            $class = 'test-' . $test['severity'];
            $icon = $test['status'] ? '✓' : '✗';
            echo "<div class='test-item $class'>";
            echo "<strong>$icon {$test['name']}:</strong> {$test['message']}";
            echo "</div>";
        }
        ?>

        <hr>

        <?php if ($allPassed): ?>
            <div class="alert alert-success">
                <h4>✓ Installation Successful!</h4>
                <p>All tests passed. Your LOVEurMOM application is ready to use.</p>
                <a href="index.php" class="btn btn-success btn-lg">Go to Dashboard</a>
            </div>
        <?php else: ?>
            <div class="alert alert-danger">
                <h4>✗ Installation Incomplete</h4>
                <p>Some tests failed. Please review the errors above and:</p>
                <ul>
                    <li>Make sure XAMPP is running (Apache and MySQL)</li>
                    <li>Check that you've imported the database schema</li>
                    <li>Verify all files were copied correctly</li>
                    <li>Review the INSTALLATION.md guide</li>
                </ul>
            </div>
        <?php endif; ?>

        <div class="card mt-4">
            <div class="card-header">
                <h5>System Information</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <td><strong>PHP Version:</strong></td>
                        <td><?php echo phpversion(); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Server Software:</strong></td>
                        <td><?php echo $_SERVER['SERVER_SOFTWARE']; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Document Root:</strong></td>
                        <td><?php echo $_SERVER['DOCUMENT_ROOT']; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Installation Path:</strong></td>
                        <td><?php echo __DIR__; ?></td>
                    </tr>
                    <?php if ($dbConnected): ?>
                    <tr>
                        <td><strong>MySQL Version:</strong></td>
                        <td><?php echo $conn->server_info; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Database Name:</strong></td>
                        <td><?php echo DB_NAME; ?></td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>

        <div class="mt-4 text-center">
            <p class="text-muted">
                <a href="README.md">README</a> | 
                <a href="INSTALLATION.md">Installation Guide</a> | 
                <a href="TROUBLESHOOTING.md">Troubleshooting</a> | 
                <a href="QUICK-REFERENCE.md">Quick Reference</a>
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
