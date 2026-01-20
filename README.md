# Internship Management System

A comprehensive web-based application for managing internship opportunities, connecting students with companies through a centralized platform.

## 🎯 Project Overview

The Internship Management System is built using **Core PHP** with **MVC Architecture** and **MySQL** database. It provides role-based access control for three types of users: Students, Companies, and Administrators.

## ✨ Features

### 🎓 Student Features

- Browse and search internship opportunities
- Apply for internships with resume upload
- Track application status (Pending/Approved/Rejected)
- Manage profile and personal information
- View personalized dashboard

### 🏢 Company Features

- Post internship opportunities
- Manage internship postings
- View and manage student applications
- Approve/reject applications
- Company profile management
- Requires admin approval for account activation

### 👨‍💼 Admin Features

- Approve/reject company accounts
- Approve/reject internship postings
- Manage all users (students and companies)
- View system statistics and reports
- Monitor all platform activities

### 🔐 Common Features

- Secure authentication and authorization
- Role-based access control
- Password hashing with bcrypt
- Session management
- Flash messages for user feedback
- Responsive design with white & gradient green theme

## 🛠️ Technology Stack

- **Frontend**: HTML5, CSS3, JavaScript
- **Backend**: Core PHP (No Framework)
- **Database**: MySQL
- **Architecture**: MVC (Model-View-Controller)
- **Server**: Apache with mod_rewrite

## 📋 Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache Server with mod_rewrite enabled
- Web browser (Chrome, Firefox, Safari, etc.)

## 🚀 Installation & Setup

### Step 1: Clone/Download the Project

```bash
cd /path/to/your/htdocs/or/www
# Copy the Internship_Management_System folder here
```

### Step 2: Configure Database

1. Open **phpMyAdmin** or MySQL client
2. Run the SQL file located at: `database/schema.sql`
   ```sql
   -- Or copy and paste the contents into phpMyAdmin SQL tab
   ```
3. This will create:
   - Database: `internship_management_system`
   - All required tables
   - Default admin account

### Step 3: Configure Application

Edit `config/database.php` if your MySQL credentials are different:

```php
private $host = 'localhost';
private $db_name = 'internship_management_system';
private $username = 'root';  // Change if needed
private $password = '';       // Change if needed
```

Edit `config/config.php` to set your base URL:

```php
define('BASE_URL', 'http://localhost:8080/Internship_Management_System/');
// Note: Your XAMPP runs on port 8080, not the default port 80
```

### Step 4: Set Permissions

Ensure the uploads directory is writable:

```bash
chmod -R 777 uploads/
```

### Step 5: Access the Application

Open your browser and navigate to:

```
http://localhost:8080/Internship_Management_System/
```

**Note**: Your XAMPP is configured to use port **8080** instead of the default port 80.

## 👤 Default Login Credentials

### Admin Account

- **Email**: admin@internship.com
- **Password**: admin123

### Test Accounts

You can register new student and company accounts through the registration page.

## 📁 Project Structure

```
Internship_Management_System/
│
├── config/
│   ├── config.php              # Application configuration
│   └── database.php            # Database connection
│
├── controllers/
│   ├── AuthController.php      # Authentication logic
│   ├── HomeController.php      # Homepage controller
│   ├── StudentController.php   # Student functionality
│   ├── CompanyController.php   # Company functionality
│   └── AdminController.php     # Admin functionality
│
├── core/
│   ├── Controller.php          # Base controller class
│   └── Model.php               # Base model class
│
├── models/
│   ├── User.php                # User model
│   ├── StudentProfile.php      # Student profile model
│   ├── CompanyProfile.php      # Company profile model
│   ├── Internship.php          # Internship model
│   └── Application.php         # Application model
│
├── views/
│   ├── layouts/
│   │   ├── header.php          # Header layout
│   │   └── footer.php          # Footer layout
│   ├── auth/
│   │   ├── login.php           # Login page
│   │   └── register.php        # Registration page
│   ├── student/
│   │   ├── dashboard.php       # Student dashboard
│   │   ├── internships.php     # Browse internships
│   │   ├── applications.php    # My applications
│   │   └── profile.php         # Student profile
│   ├── company/
│   │   ├── dashboard.php       # Company dashboard
│   │   ├── internships.php     # Manage internships
│   │   ├── create_internship.php
│   │   ├── applications.php    # View applications
│   │   └── profile.php         # Company profile
│   ├── admin/
│   │   ├── dashboard.php       # Admin dashboard
│   │   ├── users.php           # Manage users
│   │   ├── companies.php       # Manage companies
│   │   └── internships.php     # Manage internships
│   ├── home/
│   │   └── index.php           # Homepage
│   └── errors/
│       └── 404.php             # 404 error page
│
├── public/
│   ├── css/
│   │   └── style.css           # Main stylesheet
│   └── js/
│       └── main.js             # JavaScript functions
│
├── database/
│   └── schema.sql              # Database schema
│
├── uploads/
│   └── resumes/                # Resume uploads
│
├── .htaccess                   # URL rewriting
├── index.php                   # Application entry point
└── README.md                   # This file
```

## 🎨 Design Theme

The application uses a clean and professional design with:

- **Primary Colors**: White background with gradient green accents
- **Gradient**: `linear-gradient(135deg, #10b981 0%, #059669 100%)`
- **Typography**: Segoe UI, clean and readable
- **Components**: Cards, tables, forms with consistent styling
- **Responsive**: Mobile-friendly design

## 🔒 Security Features

- Password hashing using PHP's `password_hash()`
- SQL injection prevention with PDO prepared statements
- XSS prevention with `htmlspecialchars()`
- Session management and CSRF protection
- Role-based access control
- File upload validation
- Input sanitization and validation

## 📝 Database Schema

### Tables:

1. **users** - Authentication and role information
2. **student_profiles** - Student-specific data
3. **company_profiles** - Company information
4. **internships** - Internship postings
5. **applications** - Student applications
6. **activities** - Dashboard activities tracking

## 🎯 User Workflows

### Student Workflow:

1. Register → Account automatically approved
2. Login → Browse internships
3. Apply for internships (with optional resume upload)
4. Track application status

### Company Workflow:

1. Register → Wait for admin approval
2. Login → Post internships
3. Internship awaits admin approval
4. View and manage applications
5. Approve/reject student applications

### Admin Workflow:

1. Login with default credentials
2. Approve company accounts
3. Approve internship postings
4. Monitor system activities
5. Manage users

## 🐛 Troubleshooting

### Common Issues:

**1. 404 Not Found Errors**

- Ensure Apache mod_rewrite is enabled
- Check .htaccess file is in the root directory
- Verify BASE_URL in config.php

**2. Database Connection Error**

- Verify MySQL is running
- Check database credentials in config/database.php
- Ensure database schema is imported

**3. Upload Directory Permission Error**

```bash
chmod -R 777 uploads/
```

**4. Blank Page / PHP Errors**

- Check PHP error logs
- Enable error reporting in config.php (for development only)

## 📊 Development Phases

✅ **Phase 1**: Project structure and database setup  
✅ **Phase 2**: MVC core framework  
✅ **Phase 3**: Authentication system  
✅ **Phase 4**: Student module  
✅ **Phase 5**: Company module  
✅ **Phase 6**: Admin module  
✅ **Phase 7**: UI/UX with white & green theme  
✅ **Phase 8**: File upload functionality  
✅ **Phase 9**: JavaScript enhancements  
✅ **Phase 10**: Security measures

## 🤝 Contributing

This is an academic project. For improvements:

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## 📄 License

This project is created for educational purposes.

## 👨‍💻 Developer

Developed as a comprehensive internship management solution using Core PHP and MVC architecture.

## 📞 Support

For issues or questions:

- Check the troubleshooting section
- Review the code documentation
- Verify all setup steps are completed

---

**Note**: This application is designed for local development and learning purposes. For production deployment, additional security measures and hosting configurations are recommended.

## 🎓 Learning Outcomes

This project demonstrates:

- ✅ MVC architecture implementation
- ✅ Role-based access control
- ✅ Database design and relationships
- ✅ CRUD operations
- ✅ File upload handling
- ✅ Session management
- ✅ Security best practices
- ✅ Responsive web design
- ✅ User experience design


