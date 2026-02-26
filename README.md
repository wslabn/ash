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

## Email Configuration (SendGrid)

For production email delivery (invoice emails), configure SendGrid:

1. **Sign up for SendGrid** at [sendgrid.com](https://sendgrid.com)
   - Free tier: 100 emails/day
   - Paid: $19.95/mo for 50,000 emails/month

2. **Create API Key** in SendGrid dashboard:
   - Settings → API Keys → Create API Key
   - Choose "Full Access" or "Mail Send" permissions
   - Copy the API key (shown only once)

3. **Verify Sender Email**:
   - Settings → Sender Authentication
   - Verify your domain or single sender email
   - Use format: `noreply@yourdomain.com`

4. **Install SendGrid Package**:
```bash
composer require sendgrid/sendgrid
```

5. **Update `.env` file**:
```env
MAIL_MAILER=sendgrid
SENDGRID_API_KEY=your-sendgrid-api-key-here
MAIL_FROM_ADDRESS="noreply@ashbrooke.com"
MAIL_FROM_NAME="Ashbrooke CRM"
```

**Development/Testing:**
- Default config uses `MAIL_MAILER=log` (emails written to `storage/logs/laravel.log`)
- For testing, use [Mailtrap](https://mailtrap.io) or keep log driver

**How it works:**
- One SendGrid account sends all emails
- Each consultant's branding (logo, name, contact info) automatically included
- Customers see personalized invoices with consultant's business logo
- No additional configuration needed per consultant

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
- Draft sales with auto-save
- Dynamic payment methods management
- Payment tracking
- Invoice generation (browser print)
- Return processing
- Customer detail pages with purchase history
- Quick add customer modal
- Inventory adjustments
- Global search
- Dark mode support
- Discord integration (community, feedback, notifications)
- Public landing pages for consultants
- Lead management and tagging
- Admin settings UI (SendGrid, Twilio, Discord)

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
