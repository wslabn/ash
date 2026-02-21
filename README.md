# Ashbrooke CRM

A web-based inventory and CRM system for Mary Kay consultants with multi-tenant SaaS capabilities.

## Tech Stack

- **Backend**: Laravel 11, Livewire 3
- **Frontend**: Tailwind CSS, Alpine.js
- **Database**: MySQL 8.0
- **Authentication**: Laravel Breeze

## Setup

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & npm
- MySQL 8.0+

### Installation

1. Clone the repository:
```bash
git clone https://github.com/wslabn/ash.git
cd ash
```

2. Install dependencies:
```bash
composer install
npm install
```

3. Configure environment:
```bash
cp .env.example .env
php artisan key:generate
```

4. Update `.env` with database credentials:
```
DB_DATABASE=ashbrooke_crm
DB_USERNAME=supporttracker
DB_PASSWORD=your_password
```

5. Run migrations and seed data:
```bash
php artisan migrate
php artisan db:seed
php artisan db:seed --class=TestDataSeeder
```

6. Build assets:
```bash
npm run dev
```

7. Start development server:
```bash
php artisan serve
```

Visit: http://localhost:8000

## Default Credentials

**Admin Account:**
- Email: ashley@ashbrooke.com
- Password: password123

## Development Commands

```bash
# Clear test data (preserves admin user)
php artisan test:clear

# Reseed test data
php artisan db:seed --class=TestDataSeeder

# Run dev server
php artisan serve

# Watch assets
npm run dev
```

## Current Features (Phase 2 - 27% Complete)

### ✅ Completed
- User authentication with roles (Admin/Consultant)
- Customer management with CRM
- Product & inventory management
- Product categories
- Sales system (Retail/Party/Online)
- Payment tracking
- Invoice generation
- Return processing
- Customer detail pages with purchase history
- Quick add customer modal
- Inventory adjustments
- Global search
- Dark mode support

### 🚧 In Progress (Phase 2)
- Advanced customer insights
- Sales analytics
- Product management enhancements

### 📋 Planned
- Party management system
- Team & recruiting tools
- Commission tracking
- Marketing automation
- Mobile app
- Multi-tenant SaaS

## Project Structure

```
app/
├── Console/Commands/     # Custom artisan commands
├── Http/Controllers/     # HTTP controllers
├── Livewire/            # Livewire components
├── Models/              # Eloquent models
database/
├── migrations/          # Database migrations
├── seeders/            # Database seeders
resources/
├── views/              # Blade templates
│   ├── livewire/       # Livewire component views
│   └── layouts/        # Layout templates
routes/
└── web.php             # Web routes
```

## Documentation

- [PROJECT_PLAN.md](PROJECT_PLAN.md) - Complete requirements and roadmap
- [PROGRESS.md](PROGRESS.md) - Development progress tracker
- [QUICK_REFERENCE.md](QUICK_REFERENCE.md) - Key decisions and summaries
- [DATABASE_SCHEMA.md](DATABASE_SCHEMA.md) - Database schema documentation

## Business Model

**Target**: Mary Kay consultants  
**Pricing**: $9.99/month per consultant  
**Model**: Multi-tenant SaaS

## License

Proprietary - All rights reserved
