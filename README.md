# NGO Management System

A web-based management platform for non-governmental organizations (NGOs) to manage orphans, adoptions, events, volunteers, and donations — all from a single admin dashboard.

---

## Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Database Setup](#database-setup)
- [Configuration](#configuration)
- [Usage](#usage)
- [Project Structure](#project-structure)
- [Contributing](#contributing)
- [License](#license)

---

## Overview

The NGO Management System is a PHP/MySQL application that provides two portals:

- **Admin Portal** – Full control over orphan records, adoption applications, events, volunteers, donations, and user queries.
- **User Portal** – Allows registered users to view events, apply as volunteers, make donations, submit queries, and provide feedback.

---

## Features

| Module | Description |
|--------|-------------|
| 🏠 Dashboard | Statistics overview and quick navigation |
| 👶 Orphan Management | Add, view, and update orphan records with photos |
| 🤝 Adoption Management | Track adopter applications with document verification |
| 📅 Events & News | Create and manage NGO events using a rich-text editor |
| 🙋 Volunteer Management | Register and manage volunteers; track skills and availability |
| 💰 Donation Tracking | Record monetary and in-kind donations with donor details |
| ❓ Queries & Feedback | Handle user inquiries and collect structured feedback |
| 👤 User Profiles | Registration, login, profile photo, and personal details |
| 🔍 Search | Global search across records |
| 📁 File Uploads | Upload photos and supporting documents (jpg, png, gif, zip, doc, xls, txt) |

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | PHP (native, no framework) |
| Database | MySQL via MySQLi |
| Frontend | Bootstrap 5.3 |
| Admin Template | NiceAdmin (BootstrapMade) |
| Icons | Bootstrap Icons, Boxicons, Remix Icons |
| Rich Text | TinyMCE |
| Charts | ApexCharts |
| Tables | Simple DataTables |
| Session Auth | PHP Sessions + bcrypt password hashing |

---

## Prerequisites

- PHP **7.4+** (8.x recommended)
- MySQL **5.7+** or MariaDB **10.4+**
- A web server: **Apache** (with `mod_rewrite`) or **Nginx**
- Recommended local stack: [XAMPP](https://www.apachefriends.org/) / [WAMP](https://www.wampserver.com/) / [MAMP](https://www.mamp.info/)

---

## Installation

1. **Clone the repository**

   ```bash
   git clone https://github.com/lyrnoxx/ngo-management-system.git
   ```

2. **Move to your web server's document root**

   ```bash
   # XAMPP example
   mv ngo-management-system /xampp/htdocs/
   ```

3. **Start Apache and MySQL** via your local stack's control panel (e.g., XAMPP Control Panel).

---

## Database Setup

1. Open **phpMyAdmin** (usually at `http://localhost/phpmyadmin`).
2. Create a new database named **`ads`**.
3. Import the SQL dump (if provided) or create the required tables manually using the schema below.

<details>
<summary>Minimum required tables</summary>

```sql
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  phone VARCHAR(20),
  address TEXT,
  gender VARCHAR(10),
  password VARCHAR(255),
  avatar VARCHAR(255),
  role VARCHAR(20) DEFAULT 'user'
);

CREATE TABLE admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  fname VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  phone VARCHAR(20),
  password VARCHAR(255),
  avatar VARCHAR(255),
  role VARCHAR(20) DEFAULT 'admin'
);

CREATE TABLE orphans (
  id INT AUTO_INCREMENT PRIMARY KEY,
  number VARCHAR(50),
  photo VARCHAR(255),
  name VARCHAR(100),
  age INT,
  gender VARCHAR(10),
  gname VARCHAR(100),
  gcontact VARCHAR(20),
  disability VARCHAR(100),
  gaddress TEXT,
  others TEXT
);

CREATE TABLE adopter (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  contact VARCHAR(20),
  gender VARCHAR(10),
  age INT,
  aadhar VARCHAR(255),
  acard VARCHAR(255),
  icard VARCHAR(255),
  pcard VARCHAR(255),
  onumber VARCHAR(50)
);

CREATE TABLE events (
  id INT AUTO_INCREMENT PRIMARY KEY,
  photo VARCHAR(255),
  title VARCHAR(255),
  content LONGTEXT
);

CREATE TABLE volunteers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100),
  occupation VARCHAR(100),
  workingh VARCHAR(100),
  holidays VARCHAR(100),
  healthi VARCHAR(100),
  photo VARCHAR(255),
  accepted TINYINT(1) DEFAULT 0
);

CREATE TABLE donations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100),
  contact VARCHAR(20),
  occupation VARCHAR(100),
  income VARCHAR(100),
  incomep VARCHAR(100),
  type VARCHAR(50),
  mode VARCHAR(50)
);

CREATE TABLE queries (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100),
  message TEXT
);

CREATE TABLE feedbacks (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100),
  other TEXT
);
```

</details>

---

## Configuration

Open `config.php` and update the database credentials to match your environment:

```php
define( "DB_HOST", "localhost" );
define( "DB_USER", "root" );       // your MySQL username
define( "DB_PASSWORD", "" );       // your MySQL password
define( "DB_NAME", "ads" );        // database name created above
```

---

## Usage

1. Navigate to `http://localhost/ngo-management-system/` in your browser.
2. **Register** a new user account or log in with existing admin credentials.
3. Admins can access the full dashboard to manage all modules.
4. Regular users can view events, register as volunteers, donate, and submit queries.

### Key URLs

| Path | Purpose |
|------|---------|
| `/` or `/index.php` | Main dashboard (redirects to login if not authenticated) |
| `/login.php` | Login page |
| `/logout.php` | End session |
| `/add.php` | Form submission handler (POST only) |
| `/search.php` | Global search |
| `/fileUpload.php` | File upload handler |

---

## Project Structure

```
ngo-management-system/
├── config.php          # Database connection configuration
├── index.php           # Main application router & dashboard
├── login.php           # Login UI
├── login_core.php      # Authentication logic
├── logout.php          # Session termination
├── add.php             # CRUD handler for all form submissions
├── search.php          # Search functionality
├── fileUpload.php      # File upload handler
├── assets/             # Legacy CSS/JS assets
│   ├── css/
│   ├── img/
│   ├── js/
│   └── sass/
└── assets2/            # Modern admin template assets (Bootstrap 5, TinyMCE, ApexCharts)
    ├── css/
    ├── img/
    ├── js/
    ├── scss/
    └── vendor/
```

---

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository.
2. Create a new branch: `git checkout -b feature/your-feature-name`
3. Commit your changes: `git commit -m "Add your feature"`
4. Push to the branch: `git push origin feature/your-feature-name`
5. Open a Pull Request.

---

## License

This project is open-source and available under the [MIT License](LICENSE).
