# Troubleshooting Guide

## Common Issues and Solutions

---

## Installation Issues

### Issue: "Can't access http://localhost/LOVEurMOM/"

**Possible Causes:**
1. Apache not running
2. Wrong folder location
3. Incorrect URL

**Solutions:**
1. **Check XAMPP Control Panel**
   - Open XAMPP Control Panel
   - Make sure Apache shows "Running" (green)
   - If not, click "Start" next to Apache

2. **Verify Folder Location**
   - Folder should be: `C:\xampp\htdocs\LOVEurMOM\`
   - NOT in: Documents, Desktop, Downloads
   - ALL files must be inside this folder

3. **Try Alternative URLs**
   - `http://127.0.0.1/LOVEurMOM/`
   - `http://localhost:80/LOVEurMOM/`

---

### Issue: "Database connection error"

**Error Message:** "Connection failed: Access denied for user..."

**Solutions:**

1. **Check MySQL is Running**
   - XAMPP Control Panel → MySQL should be green
   - Click "Start" if not running

2. **Verify Database Exists**
   - Open phpMyAdmin: `http://localhost/phpmyadmin`
   - Look for `loveurmom_db` in left sidebar
   - If missing, create it:
     - Click "New"
     - Name: `loveurmom_db`
     - Click "Create"

3. **Import Database Schema**
   - Click on `loveurmom_db`
   - Click "Import" tab
   - Choose file: `database/schema.sql`
   - Click "Go"

4. **Check config.php Settings**
   - Open: `includes/config.php`
   - Verify:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'root');
     define('DB_PASS', '');  // Empty for XAMPP
     define('DB_NAME', 'loveurmom_db');
     ```

---

### Issue: "Blank white page"

**Possible Causes:**
1. PHP errors not displayed
2. Missing files
3. Syntax errors

**Solutions:**

1. **Enable Error Display**
   - Create file: `test.php` in LOVEurMOM folder
   - Add:
     ```php
     <?php
     error_reporting(E_ALL);
     ini_set('display_errors', 1);
     phpinfo();
     ?>
     ```
   - Visit: `http://localhost/LOVEurMOM/test.php`
   - You should see PHP info page

2. **Check Apache Error Logs**
   - XAMPP Control Panel → Apache → Logs → Error Log
   - Look for recent errors

3. **Verify All Files Present**
   - Check that all folders exist:
     - `includes/`
     - `modules/`
     - `assets/css/`
     - `assets/js/`
     - `database/`

---

## Usage Issues

### Issue: "Can't add new records"

**Solutions:**

1. **Check Required Fields**
   - All fields marked with * are required
   - Fill them in before saving

2. **Check Date Format**
   - Use the date picker
   - Format should be YYYY-MM-DD

3. **Clear Browser Cache**
   - Ctrl+Shift+Delete (Windows)
   - Cmd+Shift+Delete (Mac)
   - Clear cache and reload

---

### Issue: "Chart not displaying"

**Solutions:**

1. **Add Data First**
   - Charts need data to display
   - Add at least 2 tumor measurements

2. **Check Internet Connection**
   - Chart.js loads from CDN
   - Needs internet for first load
   - After that, browser caches it

3. **Clear Browser Cache**
   - May have old cached version

---

### Issue: "Modal won't close"

**Solutions:**

1. **Click Cancel or X**
   - Use the close buttons provided

2. **Refresh Page**
   - Press F5 or Ctrl+R

3. **Check for Errors**
   - Open browser console: F12
   - Look for JavaScript errors

---

## Tablet Issues

### Issue: "Can't access from tablet"

**Solutions:**

1. **Verify Same Network**
   - Computer and tablet must be on same WiFi
   - Check WiFi name on both devices

2. **Find Computer IP Address**
   - Windows:
     - Open Command Prompt
     - Type: `ipconfig`
     - Look for "IPv4 Address"
   - Mac:
     - System Preferences → Network
     - Look for IP address

3. **Use Correct URL**
   - Format: `http://[IP-ADDRESS]/LOVEurMOM/`
   - Example: `http://192.168.1.100/LOVEurMOM/`
   - Replace [IP-ADDRESS] with your computer's IP

4. **Check Firewall**
   - Windows Firewall might block
   - Temporarily disable to test
   - Add exception for Apache if needed

5. **Ensure Computer is On**
   - Computer must be running
   - XAMPP must be running
   - Computer can't be in sleep mode

---

### Issue: "Buttons too small on tablet"

**Solutions:**

1. **Increase Zoom**
   - iPad: Settings → Display → Zoom
   - Android: Settings → Display → Screen zoom

2. **Check CSS File**
   - File: `assets/css/style.css`
   - Button size: `.btn-action { min-height: 120px; }`
   - Increase if needed

---

## Data Issues

### Issue: "Lost data after computer restart"

**This should NOT happen** - data is in database

**If it does:**

1. **Check MySQL is Running**
   - Must start MySQL in XAMPP

2. **Verify Database Still Exists**
   - Open phpMyAdmin
   - Check for `loveurmom_db`

3. **Restore from Backup**
   - If you have a backup:
     - phpMyAdmin → Import
     - Select backup .sql file
     - Click "Go"

---

### Issue: "Want to delete all sample data"

**Solution:**

```sql
-- Open phpMyAdmin
-- Click loveurmom_db
-- Click SQL tab
-- Paste and run:

DELETE FROM ai_suggestions;
DELETE FROM symptoms;
DELETE FROM tumor_progression;
DELETE FROM appointments;
DELETE FROM medications;
DELETE FROM treatments;
DELETE FROM scans;
DELETE FROM diagnoses;
```

---

### Issue: "Need to reset everything"

**Complete Reset:**

1. **Drop Database**
   ```sql
   DROP DATABASE loveurmom_db;
   ```

2. **Recreate Database**
   ```sql
   CREATE DATABASE loveurmom_db;
   USE loveurmom_db;
   SOURCE C:/xampp/htdocs/LOVEurMOM/database/schema.sql;
   ```

---

## Performance Issues

### Issue: "Application slow"

**Solutions:**

1. **Close Unused Programs**
   - Free up RAM
   - Close browser tabs

2. **Clear Browser Cache**
   - Old cached files can slow down

3. **Optimize Database** (if lots of data)
   - phpMyAdmin → loveurmom_db → Operations
   - Click "Optimize table"

4. **Increase PHP Memory**
   - Edit: `C:\xampp\php\php.ini`
   - Find: `memory_limit`
   - Change to: `memory_limit = 256M`
   - Restart Apache

---

## Browser Issues

### Issue: "Looks broken in Internet Explorer"

**Solution:**
- **Don't use Internet Explorer**
- Use: Chrome, Firefox, Safari, or Edge
- IE is outdated and not supported

---

### Issue: "Forms not working"

**Solutions:**

1. **Enable JavaScript**
   - Must be enabled in browser
   - Check browser settings

2. **Clear Cookies**
   - Sometimes corrupted cookies cause issues

3. **Try Different Browser**
   - Test in Chrome or Firefox

---

## Advanced Troubleshooting

### Enable PHP Error Display

Edit `index.php`, add at top:
```php
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
```

### Check PHP Version

Create `info.php`:
```php
<?php phpinfo(); ?>
```
Visit: `http://localhost/LOVEurMOM/info.php`

Should show PHP 7.4 or higher

### Database Connection Test

Create `test_db.php`:
```php
<?php
require_once 'includes/config.php';
if ($conn->connect_error) {
    die("Failed: " . $conn->connect_error);
} else {
    echo "Database connected successfully!";
}
?>
```

---

## Still Having Issues?

### Check These:

1. **XAMPP Version**
   - Use latest stable version
   - PHP 7.4 or higher

2. **File Permissions**
   - Ensure all files readable
   - Windows usually no issue
   - Linux: `chmod -R 755 LOVEurMOM/`

3. **Port Conflicts**
   - Apache uses port 80
   - Make sure nothing else using it
   - Skype sometimes conflicts

4. **Antivirus**
   - Sometimes blocks Apache
   - Add XAMPP to exceptions

---

## Getting Help

### Information to Gather:

When seeking help, have ready:
1. Operating system (Windows/Mac/Linux)
2. XAMPP version
3. PHP version (from phpinfo)
4. Exact error message
5. What you were trying to do
6. Browser being used

### Logs to Check:

1. **Apache Error Log**
   - XAMPP → Apache → Logs

2. **MySQL Error Log**
   - XAMPP → MySQL → Logs

3. **Browser Console**
   - Press F12 → Console tab

---

## Preventive Measures

### To Avoid Issues:

1. **Regular Backups**
   - Export database weekly
   - Save to USB or cloud

2. **Keep XAMPP Running**
   - Don't stop unnecessarily
   - Auto-start on boot if desired

3. **Bookmark the URL**
   - Quick access
   - No typing errors

4. **Document Your Setup**
   - Note your IP address
   - Write down any changes made

---

**Remember: Most issues are simple to fix. Stay calm and work through the solutions systematically.**
