# ArchiveVault

A personal digital archive management system built with Laravel for organizing and preserving files, documents, photos, and videos.

## Features

- Create and manage digital archives organized by events, dates, or categories
- Upload and store photos, videos, PDFs, and documents (up to 20MB per file)
- Search and filter archives by keywords, dates, file types, and categories
- User authentication and private archive management
- Responsive design with modern UI components
- File metadata display and download capabilities

## System Requirements

- PHP 8.4 or higher
- Laravel 12.x
- Node.js 18.x or higher
- SQLite 3.x (default) or MySQL/PostgreSQL
- Composer 2.x
- NPM 9.x or higher

### Required PHP Extensions

- BCMath
- Ctype
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- SQLite3
- Tokenizer
- XML

## Installation

### 1. Clone and Install Dependencies

```bash
git clone <repository-url>
cd Arch
composer install
npm install
```

### 2. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

Configure your `.env` file:

```env
APP_NAME=ArchiveVault
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=sqlite
```

### 3. Database Setup

For SQLite (default):
```bash
touch database/database.sqlite
php artisan migrate
```

For MySQL/PostgreSQL, create the database and update `.env` accordingly.

### 4. Storage Configuration

```bash
php artisan storage:link
```

### 5. Build Frontend Assets

Development:
```bash
npm run dev
```

Production:
```bash
npm run build
```

### 6. Start Development Server

Using Laravel's built-in server:
```bash
php artisan serve
```

Using Laravel Herd (macOS):
```bash
herd park
```

Access the application at http://localhost:8000 or http://arch.test

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── ArchiveItemController.php
│   │   └── AssetController.php
│   └── Requests/
├── Models/
│   ├── ArchiveItem.php
│   ├── Asset.php
│   └── User.php
└── Policies/
    └── ArchiveItemPolicy.php

resources/
├── css/
│   └── app.css
├── js/
│   └── app.js
└── views/
    ├── archives/
    ├── auth/
    └── layouts/

routes/
├── web.php
└── auth.php
```

## Usage

### Authentication

Register a new account or log in at `/register` or `/login`. Password reset functionality is available at `/forgot-password`.

### Managing Archives

- **Create**: Click "Create New Archive" and fill in the archive details
- **View**: Browse archives on the main dashboard with search and filter options
- **Edit**: Update archive information from the archive detail page
- **Delete**: Remove archives and associated files

### File Management

- Upload files through the drag-and-drop interface on archive detail pages
- Supported formats: JPEG, PNG, GIF, MP4, PDF, TXT
- Maximum file size: 20MB
- Download or delete files from the archive detail page

### Search and Filtering

- Search by archive title or description
- Filter by year (4-digit format)
- Filter by file format (JPG, PNG, PDF, etc.)
- Results are paginated with 15 items per page

## Testing

Run the test suite:

```bash
php artisan test
```

Run specific tests:

```bash
php artisan test --filter=ArchiveTest
```

## Deployment

### Production Checklist

1. Set production environment variables:
   ```env
   APP_ENV=production
   APP_DEBUG=false
   ```

2. Configure production database credentials

3. Set up SMTP mail configuration for password resets

4. Build production assets:
   ```bash
   npm run build
   ```

5. Optimize application:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

6. Set file permissions:
   ```bash
   chmod -R 775 storage bootstrap/cache
   ```

7. Configure web server to point to `public/` directory

8. Enable HTTPS with SSL certificate

9. Configure database and file storage backups

## Security Features

- Authentication middleware on all protected routes
- File upload validation and rate limiting (60 uploads per minute)
- Authorization policies for archive access control
- CSRF protection on all forms
- XSS protection via Blade template escaping
- SQL injection protection via Eloquent ORM

## Common Commands

```bash
# Clear all caches
php artisan optimize:clear

# Run tests
php artisan test

# List all routes
php artisan route:list

# Create new migration
php artisan make:migration create_table_name

# Rebuild frontend assets
npm run build
```

## License

This project is open-source software.

## Support

For issues or questions, please open an issue on the repository.
