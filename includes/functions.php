<?php
// Helper functions for the application

function sanitize_input($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $conn->real_escape_string($data);
}

function format_date($date) {
    return date('M d, Y', strtotime($date));
}

function format_datetime($datetime) {
    return date('M d, Y g:i A', strtotime($datetime));
}

function get_severity_class($severity) {
    if ($severity >= 8) return 'danger';
    if ($severity >= 5) return 'warning';
    return 'success';
}

function get_status_badge($status) {
    $badges = [
        'scheduled' => 'primary',
        'completed' => 'success',
        'cancelled' => 'danger',
        'ongoing' => 'info',
        'rescheduled' => 'warning'
    ];
    return $badges[$status] ?? 'secondary';
}

function get_treatment_icon($type) {
    $icons = [
        'surgery' => '🏥',
        'chemotherapy' => '💉',
        'immunotherapy' => '🧬',
        'radiation' => '☢️',
        'clinical_trial' => '🔬',
        'other' => '📋'
    ];
    return $icons[$type] ?? '📋';
}

function get_ai_pain_suggestion($symptom_type, $severity, $location) {
    $suggestions = [
        'pain' => [
            'mild' => [
                "Try gentle stretching exercises for 10-15 minutes",
                "Apply a warm compress to the affected area",
                "Practice deep breathing exercises",
                "Consider over-the-counter pain relief (consult your doctor first)"
            ],
            'moderate' => [
                "Rest in a comfortable position",
                "Use ice packs for 15-20 minutes if inflammation is present",
                "Practice mindfulness meditation to manage pain perception",
                "Contact your healthcare provider if pain persists"
            ],
            'severe' => [
                "Contact your doctor or nurse immediately",
                "Avoid strenuous activities",
                "Take prescribed pain medication as directed",
                "Consider calling emergency services if pain is unbearable"
            ]
        ],
        'nausea' => [
            "Eat small, frequent meals instead of large ones",
            "Avoid strong odors and greasy foods",
            "Try ginger tea or ginger candies",
            "Stay hydrated with small sips of water",
            "Rest with your head elevated",
            "Ask your doctor about anti-nausea medication"
        ],
        'fatigue' => [
            "Take short naps (20-30 minutes) during the day",
            "Prioritize activities and conserve energy",
            "Stay hydrated throughout the day",
            "Eat nutritious, energy-boosting foods",
            "Light exercise like short walks can help",
            "Maintain a consistent sleep schedule"
        ],
        'anxiety' => [
            "Practice deep breathing: inhale for 4, hold for 4, exhale for 4",
            "Try progressive muscle relaxation",
            "Listen to calming music or nature sounds",
            "Reach out to a trusted friend or family member",
            "Consider speaking with a counselor or therapist",
            "Use mindfulness or meditation apps"
        ]
    ];
    
    $severity_level = 'mild';
    if ($severity >= 7) $severity_level = 'severe';
    elseif ($severity >= 4) $severity_level = 'moderate';
    
    $symptom_lower = strtolower($symptom_type);
    
    if (strpos($symptom_lower, 'pain') !== false || strpos($symptom_lower, 'ache') !== false) {
        return $suggestions['pain'][$severity_level];
    } elseif (strpos($symptom_lower, 'nausea') !== false || strpos($symptom_lower, 'vomit') !== false) {
        return $suggestions['nausea'];
    } elseif (strpos($symptom_lower, 'tired') !== false || strpos($symptom_lower, 'fatigue') !== false) {
        return $suggestions['fatigue'];
    } elseif (strpos($symptom_lower, 'anxiety') !== false || strpos($symptom_lower, 'stress') !== false) {
        return $suggestions['anxiety'];
    }
    
    return [
        "Monitor the symptom and note any changes",
        "Stay hydrated and get adequate rest",
        "Contact your healthcare provider if symptoms worsen",
        "Keep a log of when symptoms occur and what helps"
    ];
}
?>
