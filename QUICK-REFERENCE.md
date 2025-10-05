# Quick Reference Guide

## 📱 Accessing the App

### From Computer
```
http://localhost/LOVEurMOM/
```

### From Tablet (Same WiFi)
```
http://[YOUR-COMPUTER-IP]/LOVEurMOM/
```

Example: `http://192.168.1.100/LOVEurMOM/`

---

## 🎯 Main Features - Quick Access

| Feature | What It Does | When to Use |
|---------|--------------|-------------|
| **🏠 Dashboard** | Overview of everything | Start here every time |
| **💉 Treatments** | Record chemo, surgery, etc. | After each treatment |
| **📷 Scans** | Track CT, MRI, PET scans | After imaging appointments |
| **❤️ Symptoms** | Log how you feel + get AI help | Daily or when feeling unwell |
| **💊 Medications** | List all current meds | When meds change |
| **📅 Appointments** | Track doctor visits | When scheduling |
| **🏥 Diagnoses** | Medical diagnoses | At diagnosis or update |
| **⏰ Timeline** | See everything chronologically | Before doctor appointments |
| **📊 Tumor Progress** | View size changes with charts | After scans to compare |

---

## 💡 Daily Workflow

### Morning Routine
1. Open app on tablet
2. Click **"Log Symptoms"**
3. Select how you're feeling
4. Click pain level (1-10)
5. Get AI suggestions
6. Take medications as scheduled

### Before Appointments
1. Click **"Timeline"**
2. Review recent events
3. Check **"Symptoms"** for patterns
4. Note questions for doctor
5. Print or screenshot if needed

### After Medical Events
1. **After Scan** → Add to "Scans" + "Tumor Progress"
2. **After Treatment** → Add to "Treatments"
3. **New Medication** → Add to "Medications"
4. **Next Appointment** → Add to "Appointments"

---

## 🎨 Understanding Colors

### Status Colors
- 🟢 **Green** - Good/Completed/Shrinking
- 🔵 **Blue** - Scheduled/Stable
- 🟡 **Yellow** - Warning/Upcoming
- 🔴 **Red** - Severe/Urgent/Growing
- ⚫ **Gray** - Cancelled/Inactive

### Pain Scale Colors
- **1-3 (Green)** - Mild discomfort
- **4-6 (Yellow)** - Moderate pain
- **7-10 (Red)** - Severe pain

---

## 📝 Adding Data - Quick Steps

### Add Symptom (Most Common)
1. Dashboard → **"Log Symptoms"** button
2. Choose symptom type
3. Click pain number (1-10)
4. Add description (optional)
5. **"Log Symptom & Get AI Suggestions"**
6. Read AI recommendations

### Add Treatment
1. Dashboard → **"Treatments"** button
2. **"Add New Treatment"** button
3. Fill required fields (marked with *)
4. **"Save Treatment"**

### Add Scan
1. Dashboard → **"Scans"** button
2. **"Add New Scan"** button
3. Enter scan details and findings
4. **"Save Scan"**

### Add Appointment
1. Dashboard → **"Appointments"** button
2. **"Add New Appointment"** button
3. Enter date, time, doctor
4. **"Save Appointment"**

---

## 🤖 AI Symptom Suggestions

### What AI Helps With
- **Pain** - Relief methods by severity
- **Nausea** - Diet and comfort tips
- **Fatigue** - Energy management
- **Anxiety** - Calming techniques

### How It Works
1. Log your symptom
2. Select severity (1-10)
3. AI analyzes type + severity
4. Shows 4-6 helpful suggestions
5. Always safe, evidence-based tips

### Remember
- AI gives general suggestions only
- Not medical advice
- Always consult your doctor
- Call doctor if symptoms severe

---

## 📊 Using the Timeline

### What You'll See
- All events in date order
- Color-coded by type
- Grouped by month
- Complete details for each

### Treatment Icons
- 🏥 Surgery
- 💉 Chemotherapy  
- 🧬 Immunotherapy
- ☢️ Radiation
- 🔬 Clinical Trial
- 📋 Other

### Best Used
- Before doctor appointments
- To track treatment journey
- To see patterns over time
- To share with family

---

## 📈 Tumor Tracking

### How to Use
1. Add each scan result to **"Scans"**
2. Go to **"Tumor Progress"**
3. **"Add New Measurement"**
4. Enter size from scan report
5. View chart showing changes

### Understanding Chart
- **Line going down** = Shrinking (good!)
- **Flat line** = Stable
- **Line going up** = Growing (discuss with doctor)

---

## 💾 Backing Up Your Data

### Weekly Backup (Recommended)

1. **Open phpMyAdmin**
   - Go to: `http://localhost/phpmyadmin`

2. **Export Database**
   - Click `loveurmom_db` on left
   - Click "Export" tab
   - Click "Go"

3. **Save File**
   - Save to USB drive
   - Or email to yourself
   - Name it with date: `backup_2024_01_15.sql`

---

## 🆘 Quick Fixes

### App Won't Load
1. Check XAMPP is running (Apache + MySQL)
2. Try: `http://127.0.0.1/LOVEurMOM/`
3. Restart XAMPP

### Can't Add Data
1. Fill all required fields (*)
2. Check date format is correct
3. Refresh page and try again

### Tablet Can't Connect
1. Same WiFi network?
2. Computer still on?
3. XAMPP still running?
4. Correct IP address?

### Form Won't Submit
1. All * fields filled?
2. Click pain level for symptoms
3. JavaScript enabled in browser?

---

## ⌨️ Keyboard Shortcuts

- **Ctrl/Cmd + P** - Print current page
- **Ctrl/Cmd + H** - Go to home/dashboard
- **F5** - Refresh page
- **Esc** - Close modal

---

## 📱 Tablet Tips

### For Best Experience
1. **Landscape mode** - Better view
2. **Full brightness** - Easy to read
3. **Add to home screen** - One-tap access
4. **Disable auto-lock** - While using
5. **Close other apps** - Better performance

### Making Text Bigger
- **iPad**: Settings → Display → Text Size
- **Android**: Settings → Display → Font Size

---

## 🔑 Important URLs

| What | URL |
|------|-----|
| Main App | `http://localhost/LOVEurMOM/` |
| phpMyAdmin | `http://localhost/phpmyadmin` |
| XAMPP Control | Launch from Start Menu |

---

## 📞 When to Call Doctor

Even with AI suggestions, call your doctor if:
- ❗ Pain level 8 or higher
- ❗ New or worsening symptoms
- ❗ Fever over 100.4°F (38°C)
- ❗ Severe nausea/vomiting
- ❗ Difficulty breathing
- ❗ Any concerning symptoms

**The app helps track, not replace medical care!**

---

## 💝 Remember

- **Log symptoms daily** - Better tracking
- **Update after appointments** - Keep current
- **Use AI suggestions** - Helpful tips
- **Backup weekly** - Protect your data
- **Share timeline with doctors** - Better care
- **You're doing great!** - One day at a time ❤️

---

**Print this page for quick reference while using the app!**

---

**Made with love to support your health journey** 💪❤️
