# LOVEurMOM Installation Guide

## Quick Start Guide for Non-Technical Users

This guide will help you set up the LOVEurMOM cancer tracking application on your computer.

### What You Need

1. **A Web Server** - We recommend XAMPP (it's free and easy to install)
2. **A Web Browser** - Chrome, Firefox, Safari, or Edge
3. **This Application** - The LOVEurMOM files

---

## Step-by-Step Installation

### Step 1: Install XAMPP

1. **Download XAMPP**
   - Go to: https://www.apachefriends.org/
   - Click "Download" for your operating system (Windows, Mac, or Linux)
   - Download the latest version with PHP 7.4 or higher

2. **Install XAMPP**
   - Run the downloaded installer
   - Follow the installation wizard
   - Install to the default location (usually `C:\xampp` on Windows)
   - Select at least Apache and MySQL components

3. **Start XAMPP**
   - Open XAMPP Control Panel
   - Click "Start" next to Apache
   - Click "Start" next to MySQL
   - Both should show green "Running" status

### Step 2: Set Up the Application Files

1. **Copy Application Files**
   - Find your XAMPP installation folder (usually `C:\xampp`)
   - Go to the `htdocs` folder inside XAMPP
   - Copy the entire `LOVEurMOM` folder into `htdocs`
   - Final path should be: `C:\xampp\htdocs\LOVEurMOM\`

### Step 3: Create the Database

**Option A: Using phpMyAdmin (Easier)**

1. **Open phpMyAdmin**
   - Make sure XAMPP is running (Apache and MySQL)
   - Open your web browser
   - Go to: `http://localhost/phpmyadmin`

2. **Create Database**
   - Click "New" in the left sidebar
   - Database name: `loveurmom_db`
   - Collation: `utf8mb4_general_ci`
   - Click "Create"

3. **Import Database Structure**
   - Click on `loveurmom_db` in the left sidebar
   - Click the "Import" tab at the top
   - Click "Choose File"
   - Navigate to: `C:\xampp\htdocs\LOVEurMOM\database\schema.sql`
   - Click "Go" at the bottom
   - You should see a green success message

**Option B: Using Command Line (Advanced)**

```bash
# Open Command Prompt or Terminal
cd C:\xampp\mysql\bin
mysql -u root -p
# Press Enter (no password by default)

CREATE DATABASE loveurmom_db;
USE loveurmom_db;
SOURCE C:/xampp/htdocs/LOVEurMOM/database/schema.sql;
EXIT;
```

### Step 4: Configure Database Connection

1. **Edit Configuration File**
   - Navigate to: `C:\xampp\htdocs\LOVEurMOM\includes\`
   - Open `config.php` with a text editor (Notepad, Notepad++, etc.)

2. **Check Settings** (Default settings for XAMPP)
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');  // Empty password is default for XAMPP
   define('DB_NAME', 'loveurmom_db');
   ```

3. **Save the file**

### Step 5: Access the Application

1. **Open Your Browser**
   - Chrome, Firefox, Safari, or Edge

2. **Go to the Application**
   - Type in address bar: `http://localhost/LOVEurMOM/`
   - Press Enter

3. **You Should See:**
   - The LOVEurMOM dashboard
   - Statistics cards showing 0 or sample data
   - Large colorful buttons for different features

---

## Using the Application

### First Time Setup

1. **Add a Diagnosis**
   - Click the "Diagnoses" button
   - Click "Add New Diagnosis"
   - Fill in the form
   - Click "Save Diagnosis"

2. **Add Medications**
   - Click "Medications" button
   - Click "Add New Medication"
   - Enter medication details
   - Click "Save Medication"

3. **Schedule Appointments**
   - Click "Appointments" button
   - Click "Add New Appointment"
   - Fill in date, time, and doctor
   - Click "Save Appointment"

### Daily Use

**Log Symptoms:**
1. Click "Log Symptoms" button
2. Select symptom type
3. Click pain level (1-10)
4. Add any notes
5. Click "Log Symptom & Get AI Suggestions"
6. View personalized suggestions

**Track Treatments:**
1. Click "Treatments" button
2. Click "Add New Treatment"
3. Select treatment type
4. Fill in details
5. Click "Save Treatment"

**View Progress:**
1. Click "Timeline" to see all events
2. Click "Tumor Progress" to see charts
3. Check dashboard for overview

---

## Tablet Setup Instructions

### For iPad/iOS:

1. **Find Your Computer's IP Address**
   - Windows: Open Command Prompt, type `ipconfig`
   - Look for "IPv4 Address" (e.g., 192.168.1.100)

2. **Connect Tablet to Same WiFi**
   - Make sure tablet is on same network as computer

3. **Access from Tablet**
   - Open Safari
   - Type: `http://[YOUR-IP-ADDRESS]/LOVEurMOM/`
   - Example: `http://192.168.1.100/LOVEurMOM/`

4. **Add to Home Screen**
   - Tap the Share button
   - Tap "Add to Home Screen"
   - Name it "Health Tracker" or "LOVEurMOM"
   - Tap "Add"

### For Android:

1. **Same steps for IP address and WiFi**

2. **Access from Tablet**
   - Open Chrome
   - Type: `http://[YOUR-IP-ADDRESS]/LOVEurMOM/`

3. **Add to Home Screen**
   - Tap the menu (three dots)
   - Tap "Add to Home screen"
   - Name it and tap "Add"

---

## Troubleshooting

### Can't Access http://localhost/LOVEurMOM/

**Check:**
- Is XAMPP running? (Apache and MySQL both green)
- Is the folder in the right place? (`C:\xampp\htdocs\LOVEurMOM\`)
- Try: `http://127.0.0.1/LOVEurMOM/` instead

### Database Connection Error

**Check:**
- Is MySQL running in XAMPP?
- Did you create the database `loveurmom_db`?
- Did you import `schema.sql`?
- Check `includes/config.php` settings

### Blank Page or Error

**Check:**
- Look at XAMPP Control Panel for error messages
- Check Apache error log in XAMPP
- Make sure PHP is installed (comes with XAMPP)

### Can't Access from Tablet

**Check:**
- Computer and tablet on same WiFi network?
- Computer firewall might be blocking (try turning off temporarily)
- Use correct IP address
- Computer must be on and XAMPP running

---

## Data Backup

### Manual Backup (Recommended Weekly)

1. **Open phpMyAdmin**
   - Go to: `http://localhost/phpmyadmin`

2. **Export Database**
   - Click `loveurmom_db` on left
   - Click "Export" tab
   - Click "Go"
   - Save the `.sql` file with today's date

3. **Store Backup Safely**
   - Save to USB drive
   - Email to yourself
   - Save to cloud storage (Google Drive, Dropbox, etc.)

---

## Tips for Best Experience

### For Mom's Tablet:

1. **Increase Text Size**
   - iPad: Settings → Display & Brightness → Text Size
   - Android: Settings → Display → Font Size

2. **Increase Brightness**
   - Make it easy to see

3. **Enable Do Not Disturb During Use**
   - Avoid interruptions

4. **Create Home Screen Shortcut**
   - Easy one-tap access

### General Tips:

- **Enter data daily** - Keep symptom log current
- **Before appointments** - Print or view timeline
- **After scans** - Update tumor tracking immediately
- **Set reminders** - For logging symptoms and medications
- **Backup weekly** - Protect your important health data

---

## Getting Help

### Common Questions:

**Q: Can multiple people use this?**
A: Yes, but they'll all see the same data. It's designed for one patient.

**Q: Is my data safe?**
A: Data is stored only on your computer. Not in the cloud. Keep backups!

**Q: Can I print reports?**
A: Yes! Use your browser's print function (Ctrl+P or Cmd+P)

**Q: Can I access from anywhere?**
A: Only from your local network unless you set up remote access (advanced)

**Q: Does it work offline?**
A: Yes! As long as XAMPP is running, no internet needed.

---

## Need More Help?

- Check XAMPP documentation: https://www.apachefriends.org/docs/
- PHP.net documentation: https://www.php.net/manual/
- Bootstrap documentation: https://getbootstrap.com/docs/

---

**Remember: This tool helps track medical information but is not a substitute for professional medical advice. Always consult healthcare providers for medical decisions.**

---

**Made with ❤️ to support families during difficult times**
