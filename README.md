# 🏫 Grievance System for College Students

A **web-based complaint management system** for students to submit grievances related to **hostel, food, library, and other college services**. This system allows students to track complaints in **real-time**, while admins can manage and resolve them efficiently.

---

## **✨ Features**
### 🔹 Student Features:
- 📊 **Track Complaint Status** in real-time (Pending, In Progress, Resolved).
- 🔍 **Search & Filter** complaints by **date, status, category, or keywords**.
- 📩 **Receive Email Notifications** when complaint status is updated.

### 🔹 Admin Features:
- 📜 **View and Manage Complaints** from all students.
- ⚡ **Update Complaint Status** and add responses.
- 📈 **Dashboard Analytics** (e.g., total pending complaints).
- 📤 **Send Notifications via Email** to students.
- 📄 **Download Complaint Reports as PDF**.

### 🔹 Additional Enhancements:
- 🎨 **Attractive Homepage with College Branding**.
- 🚀 **Loading Animation** when submitting forms.
- 🛠️ **Role-Based Access** (Students & Admins).


## **⚙️ Installation Guide**
### **1️⃣ Prerequisites**
Ensure you have the following installed:
- ✅ **XAMPP** (for Apache & MySQL)
- ✅ **Composer** (for PHPMailer)
- ✅ **Git** (for version control)

### **2️⃣ Clone the Repository**
```sh
git clone https://github.com/pansarey91/Grievance_System_PHP.git
cd Grievance_System_PHP
```

### **3️⃣ Set Up the Database**
1. Create a new database:  
   ```sql
   CREATE DATABASE complaint_sys;
   ```

### **4️⃣ Install Dependencies**
Run:
```sh
composer install
```
This will install **PHPMailer**.

### **5️⃣ Configure the `.env` File**
Rename `.env.example` to `.env` and update:
```
DB_HOST=localhost
DB_NAME=grievance_system
DB_USER=root
DB_PASS=
SMTP_HOST=smtp.gmail.com
SMTP_USER=your-email@gmail.com
SMTP_PASS=your-email-password
```

### **6️⃣ Start the Server**
Run XAMPP and start **Apache & MySQL**, then open:
```
http://localhost/studentphp/
```

---

## **📧 Email Notifications**
The system sends **email alerts** when:
✅ A student **submits a complaint**.  
✅ The **complaint status is updated**.  

Uses **PHPMailer** via **SMTP (Gmail/Yahoo)**.

---

## **📊 Admin Panel Features**
- **View all complaints** and their priority.
- **Filter & Sort complaints** by date or status.
- **Update complaint status** (Pending, In Progress, Resolved).
- **View email logs** of sent notifications.

To access the **admin panel**, log in as an admin.

---

## **💡 Future Enhancements**
🚀 **Live Complaint Tracking (AJAX Updates)**  
📱 **WhatsApp/SMS Alerts for Complaint Status**  
🤖 **AI Chatbot for Complaint Assistance**  
📑 **Download Complaints as PDF Reports**  

---

## **🛠️ Contributing**
Want to contribute? Follow these steps:
1. **Fork** the repository.
2. **Create a new branch**:  
   ```sh
   git checkout -b feature-branch
   ```
3. **Make changes and commit**:  
   ```sh
   git commit -m "Added a new feature"
   ```
4. **Push to GitHub and create a Pull Request**.

---

## **📞 Contact & Support**
For any issues, contact us:
📧 **Email:** pansarey91@gmail.com

---

### **🎉 Thank You for Using the Grievance System!**
🚀 *Empowering students with a seamless complaint management system!* 🏫✨
