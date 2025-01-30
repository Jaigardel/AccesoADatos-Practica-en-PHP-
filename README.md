# 📌 Web Development - Server-Side Environment

## 📢 Project: Company Database with Role-Based Access

This project is an extension of a previously developed company management system. The goal is to implement user authentication and role-based access control to restrict permissions based on user roles.

## 🔹 Objectives
- Implement authentication to restrict access to authorized users only.
- Establish role-based permissions for different user types.
- Use **PDO** for database interactions.
- Secure password storage with encryption.
- Implement session management with login/logout functionality.

## 📋 Prerequisites

#### **User Roles**
- **ADMIN**: Full access to user management, company branches, departments, and employees.
- **GESTOR**: Manages employees (add, update, delete employees), also can read the other company branches.
- **CONSULTA**: Read-only access to company branches, departments, and employees.

## 🔑 Authentication System
### **Login Page (`login.php`)**
- Contains fields for **email** and **password**.
- Validates user credentials and redirects to the appropriate dashboard.
- Displays an error message if login fails.
- Includes a **"Forgot Password?"** link leading to `recordar.php`.

### **Password Recovery (`recordar.php`)**
- Accepts user email and checks if it exists in the database.
- Simulates an email being sent with a **password reset link** (including email & token).
- Displays an error if the email is not found.

### **Password Reset (`establecer.php`)**
- Verifies email and token from the reset link.
- Allows users to set a new password.
- Activates the account upon successful password update.

## 📂 Role-Based Access Management
### **Listings Page**
- Accessible only to logged-in users.
- **ADMIN** users see links to all sections (branches, departments, employees, user management).
- **GESTOR** users only see employee-related sections.
- **CONSULTA** users can only view listings without modification permissions.

### **User Management**
#### User List Page
- Displays all registered users sorted by registration date.
- Includes an "Add User" button.

#### Add User Page
- Form fields:
  - Email
  - Role selection dropdown
- Inserts new user into the database as **inactive**.
- Simulates sending an email with an activation link (email & token).

### **Create, Edit, Delete Operations**
#### Create New Entries
- **ADMIN**: Can add branches, departments, and employees.
- **GESTOR**: Can add employees only.
- **CONSULTA**: No access.

#### Edit Entries
- **ADMIN**: Can edit branches, departments, and employees.
- **GESTOR**: Can edit employees only.
- **CONSULTA**: No access.

#### Delete Entries
- **ADMIN**: Can delete branches, departments, and employees.
- **GESTOR**: Can delete employees only.
- **CONSULTA**: No access.

## 🛠️ Technologies Used
- **PHP (with PDO extension)** for backend development.
- **MySQL** for database storage.
- **HTML/CSS** for UI design.
- **Session handling** for authentication.
- **Password encryption** for secure authentication.

## 📌 Important Notes
- Users **must be logged in** to access protected pages.
- Every protected page must include a **logout button** to destroy the session.
- Passwords must be **4 to 20 characters long**.
- **Emails must be unique** in the database.

🚀 _This project implements a secure and structured authentication system with role-based access control for a company management system._

