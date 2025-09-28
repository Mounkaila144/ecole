# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a CodeIgniter 3 PHP-based Smart School Management System. The application manages various aspects of school administration including student records, staff management, attendance, fees, examinations, library management, and more.

## Development Commands

### Docker Development Environment
```bash
# Start the development environment
docker-compose up -d

# Stop the development environment
docker-compose down

# View logs
docker-compose logs -f
```

### Environment Setup
- **Web Application**: http://localhost:8080
- **phpMyAdmin**: http://localhost:8081
- **Database**: MariaDB on port 3306
  - Database: `laravel`
  - Username: `laravel`
  - Password: `laravel`
  - Root Password: `root`

## Architecture & Structure

### Core Framework
- **Framework**: CodeIgniter 3
- **PHP Version**: Configured for development environment
- **Database**: MariaDB/MySQL with mysqli driver
- **Default Database**: `ssnodb` (configurable in `application/config/database.php`)

### Directory Structure
```
├── application/          # Main application code (CodeIgniter)
│   ├── config/          # Configuration files
│   ├── controllers/     # 225+ controllers for different modules
│   ├── models/          # 149+ models for data management
│   ├── views/           # View templates organized by module
│   ├── libraries/       # Custom libraries and extensions
│   ├── helpers/         # Custom helper functions
│   └── core/            # Core extensions (MY_Controller, MY_Model)
├── backend/             # Static assets (CSS, JS, images)
├── system/              # CodeIgniter framework files
├── uploads/             # File uploads directory
└── index.php            # Application entry point
```

### Key Architecture Components

#### Base Controllers
- `MY_Controller` - Base controller with common functionality, session handling, and multi-language support
- Controllers extend either `MY_Controller` directly or specialized base controllers
- Role-based access control with different user types (admin, student, parent, teacher, accountant, librarian)

#### User Roles & Access
The system supports multiple user roles with specific routing:
- **Admin**: `/admin/` routes
- **Students**: `/student/` routes
- **Parents**: `/parent/` routes
- **Teachers**: `/teacher/` routes
- **Accountants**: `/accountant/` routes
- **Librarians**: `/librarian/` routes

#### Key Features
- **Multi-language Support**: Dynamic language loading based on user preferences
- **Multi-currency**: Support for different currencies (CFA and others)
- **Modular Design**: Feature-based organization with modules for attendance, fees, exams, library, etc.
- **Role-based Permissions**: Comprehensive permission system for different user types
- **File Management**: Upload handling with file type validation
- **Audit Trail**: User action logging and audit functionality

### Database Configuration
- Default environment: `development`
- Database configuration in `application/config/database.php`
- Default local database: `ssnodb`
- Docker database: `laravel`

### Front-end Assets
- Bootstrap-based UI components in `/backend/`
- CKEditor integration for rich text editing
- DataTables for data display
- FullCalendar for calendar functionality
- Custom CSS/JS in `/backend/custom/`

### Custom Extensions
- Custom libraries in `application/libraries/`
- Helper functions in `application/helpers/`
- Core extensions: `MY_Controller.php`, `MY_Model.php`

### Deployment
- GitHub Actions workflow configured for automatic deployment
- Deploys to remote server via SSH on push to main branch
- Docker containerization with nginx web server

### Key Configuration Files
- `application/config/routes.php` - URL routing and rewriting
- `application/config/database.php` - Database configuration
- `docker-compose.yml` - Development environment setup
- `.github/workflows/main.yml` - CI/CD pipeline

### Development Notes
- Environment is set to 'development' in `index.php`
- Error reporting enabled in development mode
- Session-based authentication system
- Extensive model layer with 149+ models for different entities
- Comprehensive controller structure with 225+ controllers