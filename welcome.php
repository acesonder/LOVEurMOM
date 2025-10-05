<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to LOVEurMOM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 80px 20px;
            text-align: center;
            margin-bottom: 40px;
        }
        .feature-icon {
            font-size: 3rem;
            margin-bottom: 20px;
        }
        .step-number {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #0d6efd;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="hero">
        <div class="container">
            <h1 class="display-3 mb-3"><i class="bi bi-heart-fill"></i> LOVEurMOM</h1>
            <p class="lead fs-4">Your Comprehensive Cancer Treatment Tracking System</p>
            <p class="fs-5">Track treatments, manage symptoms, and get AI-powered support</p>
        </div>
    </div>

    <div class="container pb-5">
        <!-- Quick Start Section -->
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="mb-4">Getting Started in 3 Steps</h2>
            </div>
            <div class="col-md-4 mb-3">
                <div class="text-center">
                    <div class="step-number mx-auto">1</div>
                    <h4>Test Installation</h4>
                    <p>Make sure everything is set up correctly</p>
                    <a href="test_installation.php" class="btn btn-primary">Run Installation Test</a>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="text-center">
                    <div class="step-number mx-auto">2</div>
                    <h4>Explore Dashboard</h4>
                    <p>See all features at a glance</p>
                    <a href="index.php" class="btn btn-success">Go to Dashboard</a>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="text-center">
                    <div class="step-number mx-auto">3</div>
                    <h4>Start Tracking</h4>
                    <p>Begin logging your health journey</p>
                    <a href="modules/symptoms.php" class="btn btn-danger">Log First Symptom</a>
                </div>
            </div>
        </div>

        <!-- Features Overview -->
        <div class="row mb-5">
            <div class="col-12 text-center mb-4">
                <h2>What You Can Track</h2>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <div class="feature-icon">💉</div>
                        <h5>Treatments</h5>
                        <p class="text-muted">Surgery, chemo, immunotherapy, radiation, and clinical trials</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <div class="feature-icon">📷</div>
                        <h5>Scans</h5>
                        <p class="text-muted">CT, MRI, PET scans with findings and tumor measurements</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <div class="feature-icon">❤️</div>
                        <h5>Symptoms</h5>
                        <p class="text-muted">Daily tracking with AI-powered relief suggestions</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <div class="feature-icon">📊</div>
                        <h5>Progress</h5>
                        <p class="text-muted">Visual charts showing tumor size changes over time</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Key Features -->
        <div class="row mb-5">
            <div class="col-12 text-center mb-4">
                <h2>Why Use LOVEurMOM?</h2>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5><i class="bi bi-tablet-landscape text-primary"></i> Tablet Optimized</h5>
                        <p>Large buttons, readable text, and easy navigation designed specifically for tablet use.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5><i class="bi bi-robot text-success"></i> AI-Powered Help</h5>
                        <p>Get instant, evidence-based suggestions for managing pain and symptoms.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5><i class="bi bi-shield-lock text-danger"></i> Private & Secure</h5>
                        <p>All data stays on your computer. No cloud storage, complete privacy.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5><i class="bi bi-clock-history text-info"></i> Visual Timeline</h5>
                        <p>See your complete treatment journey in one chronological view.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5><i class="bi bi-graph-up text-warning"></i> Track Progress</h5>
                        <p>Charts and graphs show tumor size changes and treatment effectiveness.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5><i class="bi bi-box-arrow-in-down text-secondary"></i> Easy Setup</h5>
                        <p>Simple installation with step-by-step guides for non-technical users.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documentation -->
        <div class="row mb-5">
            <div class="col-12 text-center mb-4">
                <h2>Helpful Resources</h2>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5><i class="bi bi-book"></i> Documentation</h5>
                        <ul class="list-unstyled">
                            <li><a href="README.md" class="btn btn-link">📖 README - Project Overview</a></li>
                            <li><a href="INSTALLATION.md" class="btn btn-link">⚙️ Installation Guide</a></li>
                            <li><a href="QUICK-REFERENCE.md" class="btn btn-link">🚀 Quick Reference</a></li>
                            <li><a href="TROUBLESHOOTING.md" class="btn btn-link">🔧 Troubleshooting</a></li>
                            <li><a href="FEATURES.md" class="btn btn-link">✨ Features List</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5><i class="bi bi-lightbulb"></i> Quick Tips</h5>
                        <ul>
                            <li>Log symptoms daily for best AI suggestions</li>
                            <li>Update tumor tracking after each scan</li>
                            <li>Review timeline before doctor appointments</li>
                            <li>Backup your data weekly</li>
                            <li>Use tablet in landscape mode</li>
                            <li>Bookmark the dashboard for quick access</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Support Section -->
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <h4><i class="bi bi-heart-fill"></i> Remember</h4>
                    <p class="mb-0">This tool helps you track and manage your health information, but it is not a substitute for professional medical advice. Always consult your healthcare providers for medical decisions.</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-5 pt-5 border-top">
            <p class="text-muted">
                <strong>Made with ❤️ to support families during their cancer journey</strong><br>
                Stay strong! You've got this! 💪
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
