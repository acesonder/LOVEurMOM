# LOVEurMOM - Cancer Treatment Tracking System

A comprehensive, user-friendly web application designed to help track and manage cancer treatment, specifically created for supporting loved ones with Stage 4 terminal cancer. This tablet-optimized application provides an easy-to-navigate interface with AI-powered symptom management suggestions.

## 🎯 Features

### Core Tracking Features
- **📋 Treatment History** - Track all treatments including surgery, chemotherapy, immunotherapy, radiation, and clinical trials
- **📷 Scan Management** - Record and monitor all medical scans (CT, MRI, PET, X-Ray, etc.)
- **🏥 Diagnosis Tracking** - Maintain complete diagnosis history with stages and details
- **📊 Tumor Progression** - Visual charts and graphs tracking tumor size over time
- **💊 Medication Management** - Keep track of all current and past medications
- **📅 Appointment Scheduling** - Never miss a medical appointment
- **❤️ Symptom Tracker** - Log daily symptoms with severity levels
- **🤖 AI-Powered Suggestions** - Get intelligent recommendations for pain and symptom management

### Visual Timeline
- Complete chronological view of all medical events
- Color-coded treatment types with emoji icons
- Monthly grouping for easy navigation
- Status tracking for all treatments and appointments

### Tablet-Optimized Interface
- Large, easy-to-tap buttons (minimum 120px height)
- High-contrast, readable text (18px base font size)
- Simple navigation with clear icons
- Bootstrap 5 responsive design
- Touch-friendly forms and inputs

### AI Pain Management
The system provides intelligent suggestions based on:
- Symptom type (pain, nausea, fatigue, anxiety, etc.)
- Severity level (1-10 scale)
- Location and triggers
- Evidence-based relief methods

## 🚀 Installation

### Prerequisites
- Apache/Nginx web server
- PHP 7.4 or higher
- MySQL 5.7 or higher
- phpMyAdmin (optional but recommended)

### Step 1: Clone/Download Repository
```bash
git clone https://github.com/acesonder/LOVEurMOM.git
cd LOVEurMOM
```

### Step 2: Set Up Database
1. Open phpMyAdmin in your browser
2. Click "New" to create a new database
3. Name it `loveurmom_db`
4. Click on the database name
5. Go to "Import" tab
6. Choose the file `database/schema.sql`
7. Click "Go" to import

**OR** use command line:
```bash
mysql -u root -p
CREATE DATABASE loveurmom_db;
USE loveurmom_db;
SOURCE database/schema.sql;
```

### Step 3: Configure Database Connection
Edit `includes/config.php` with your database credentials:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
define('DB_NAME', 'loveurmom_db');
```

### Step 4: Move Files to Web Server
- For XAMPP: Copy folder to `C:\xampp\htdocs\LOVEurMOM\`
- For WAMP: Copy folder to `C:\wamp\www\LOVEurMOM\`
- For Linux: Copy to `/var/www/html/LOVEurMOM/`

### Step 5: Access the Application
Open your browser and go to:
```
http://localhost/LOVEurMOM/
```

## 📱 Using the Application

### Dashboard
The main dashboard provides:
- Quick statistics (total treatments, scans, medications, appointments)
- Large action buttons for all main features
- Recent activity overview
- Next upcoming appointment
- Latest scan results

### Adding Data
Each module has an "Add New" button that opens a modal form:
1. Click the large colored button for the feature you want
2. Click "Add New [Item]" button
3. Fill in the form (required fields marked with *)
4. Click "Save" to store the data

### Symptom Tracking with AI
1. Go to "Symptoms" from the dashboard
2. Select symptom type from dropdown
3. Click on the pain scale (1-10) to select severity
4. Fill in additional details
5. Click "Log Symptom & Get AI Suggestions"
6. View personalized AI recommendations

### Viewing Timeline
The Timeline page shows:
- All medical events in chronological order
- Treatment type summaries with counts
- Color-coded event markers
- Monthly grouping
- Complete details for each event

### Tumor Progression
- Visual line chart showing size changes over time
- Complete measurement history table
- Color-coded progression status
- Easy comparison between measurements

## 🎨 Customization

### Colors
Edit `assets/css/style.css` to change color scheme:
```css
:root {
    --primary-color: #0d6efd;
    --secondary-color: #6c757d;
    --success-color: #198754;
    --danger-color: #dc3545;
    --warning-color: #ffc107;
    --info-color: #0dcaf0;
}
```

### Button Sizes
Adjust button sizes in `style.css`:
```css
.btn-action {
    min-height: 120px;  /* Change this value */
    font-size: 1.2rem;  /* Change font size */
}
```

## 🔒 Security Notes

- Change default database credentials
- Use strong passwords
- Consider adding user authentication for multi-user environments
- Keep PHP and MySQL updated
- Backup database regularly

## 🗄️ Database Backup

Regular backups are recommended:

**Via phpMyAdmin:**
1. Select `loveurmom_db` database
2. Click "Export" tab
3. Click "Go" to download SQL file

**Via Command Line:**
```bash
mysqldump -u root -p loveurmom_db > backup_$(date +%Y%m%d).sql
```

## 📊 Sample Data

The database includes sample data for demonstration:
- 1 initial diagnosis
- 3 treatment records
- 2 scan records

You can delete this data after installation:
```sql
DELETE FROM diagnoses;
DELETE FROM treatments;
DELETE FROM scans;
```

## 🤝 Support

This application is designed with love and care for cancer patients and their families. The interface prioritizes ease of use and accessibility.

## 📝 License

This project is open source and available for personal use to help families track cancer treatment.

## 💝 Dedication

This application is dedicated to all the brave individuals fighting cancer and the families who support them every step of the way. Stay strong! 💪❤️

## 🛠️ Technical Stack

- **Frontend:** HTML5, CSS3, JavaScript, Bootstrap 5
- **Backend:** PHP 7.4+
- **Database:** MySQL
- **Charts:** Chart.js
- **Icons:** Bootstrap Icons

## 📞 Features Overview

| Feature | Description | Icon |
|---------|-------------|------|
| Treatments | Track all treatment types | 💉 |
| Scans | Record medical imaging | 📷 |
| Symptoms | Log symptoms with AI help | ❤️ |
| Medications | Manage prescriptions | 💊 |
| Appointments | Schedule tracking | 📅 |
| Diagnoses | Diagnosis history | 🏥 |
| Timeline | Visual journey | ⏰ |
| Tumor Tracking | Size progression charts | 📊 |

---

**Made with ❤️ for Mom**
