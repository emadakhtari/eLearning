# 📚 eLearning Platform – Laravel Multi-Access Persian Education System

A modern, powerful and fully featured **e-learning platform** built with the **PHP Laravel Framework , PHP V7.4**, which was requested by the **Ministry of Education** and supports multiple user roles including **Admin**, **School Principal**, **Deputy**, **Teachers**, **Students**, and **Parents**. This project is specifically localized for Persian-speaking users, integrating **BigBlueButton** for real-time virtual classrooms and the **Persian calendar** for educational scheduling.

---
<!-- HERO IMAGE
     Replace DIRECT_IMAGE_URL with a direct image link (e.g., https://i.imgur.com/XXXXXXX.jpg).
     The <a> wraps the image so clicking it opens your Imgur album.
-->
<p align="center">
<img src='https://i.postimg.cc/jdnbWPXc/elearning.jpg' border='0' width="500" alt='elearning.jpg'/>
</p>
## 🌟 Features

### 🔄 Multi-Role Access System
- **Admin**: Full access to user management, system settings, reporting.
- **School Principal**: Manages teachers, classes, and tracks student progress.
- **School Deputy**: Assists the principal in academic operations.
- **Teachers**: Schedule lessons, upload assignments, conduct live classes.
- **Students**: View classes, attend online sessions, submit assignments.

### 🔐 Accesses
- **Admin**: localhost/eLearning/Admin 
- **Deputy**: localhost/eLearning/Deputy
- **Teacher**: localhost/eLearning/Teacher
- **Students**: localhost/eLearning/Students

### 🖥️ Online Classroom (BigBlueButton)
- Seamless integration with **BigBlueButton (BBB)** hosted in **Persian UI**.
- Role-based access to create or join online classes.
- Automatic attendance tracking.

### 📆 Persian Calendar Integration
- Fully supports **Jalali (Shamsi) Calendar**.
- Teachers can schedule classes using Persian dates.
- Weekly/monthly calendar views for schools.

### 📁 Assignments & File Management
- Teachers can **upload homework**, lecture materials.
- Students can **download tasks**, and **submit** completed assignments.
- Parents can view submission history and feedback.

### 📊 Dashboards & Reports
- Role-specific dashboards with KPIs.
- Attendance, performance, and assignment completion tracking.
- Printable academic reports for students and classes.

### 🌐 Full RTL and Persian Language Support
- Entire system is **Right-To-Left (RTL)** for perfect Persian UX.
- Interface designed for native Persian speakers with intuitive navigation.

---

## 🚀 Tech Stack

| Layer        | Tech                        |
|--------------|-----------------------------|
| Backend      | Laravel (PHP 8+)            |
| Frontend     | Blade, Bootstrap RTL / Vue  |
| Calendar     | jQuery Persian Datepicker   |
| Live Class   | BigBlueButton (with JWT)    |
| Auth         | Laravel Breeze / Jetstream  |
| File Upload  | Laravel MediaLibrary        |
| Database     | MySQL / MariaDB             |

---

## 🛠️ Installation

### 1. Clone the Repository
git clone https://github.com/emadakhtari/eLearning.git
cd eLearning

### 2. Install Dependencies
composer install
npm install 

### 3. Create Environment File
cp .env.example .env
php artisan key:generate

### 4. Configure .env
DB_DATABASE=elearning
DB_USERNAME=root
DB_PASSWORD=your_password

BROADCAST_DRIVER=pusher
BBB_SERVER=https://your-bigbluebutton-server.com
BBB_SECRET=your-bigbluebutton-secret

### 5. Run Migrations
php artisan migrate

### 6. Run Seeder
php artisan db:seed --class=DatabaseSeeder

### 7. Start the Server
php artisan serve


## ☎️ Contact Me
- Developer: Emad Akhtari
- 📧 Email: [akhtari.em1@gmail.com]
- 🔗 GitHub: https://github.com/emadakhtari
