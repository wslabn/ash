# Ashbrooke CRM

> A comprehensive web-based inventory and CRM system for Mary Kay consultants with multi-tenant SaaS capabilities.

## Overview

Ashbrooke CRM is designed to help Mary Kay independent consultants manage their business operations including inventory tracking, customer relationships, sales processing, event management, team building, and recruiting—all in one powerful platform.

### Key Features

- 📦 **Inventory Management** - Track products with variants, stock levels, expiration dates, and costs
- 👥 **Customer CRM** - Manage contacts, preferences, purchase history, and automated follow-ups
- 💰 **Sales Processing** - Stripe integration, invoicing, discounts, tax calculation, and shipping
- 🎉 **Event Management** - Schedule parties, track RSVPs, manage hostess rewards
- 🤝 **Team Building** - Genealogy tree, recruiting pipeline, team communication
- 📊 **Analytics & Reporting** - AI-powered insights, sales trends, performance metrics
- 📱 **Mobile-First PWA** - Works on any device, installable as an app
- 🔔 **Multi-Channel Notifications** - Email, SMS, and push notifications
- 💳 **Subscription Billing** - Automated recurring payments via Stripe

## Technology Stack

- **Backend:** Laravel (PHP 8.3+)
- **Frontend:** Livewire + Tailwind CSS
- **Database:** MySQL
- **Hosting:** Namecheap Shared Hosting (cPanel)
- **Integrations:** Stripe, Twilio, SendGrid, Groq AI

## Project Status

**Current Phase:** Planning Complete ✅  
**Next Phase:** Phase 1 - Foundation & Core Features  
**Overall Progress:** 0% (0/162 tasks completed)

See [PROGRESS.md](PROGRESS.md) for detailed task tracking.

## Documentation

- **[PROJECT_PLAN.md](PROJECT_PLAN.md)** - Complete project requirements, features, and development roadmap
- **[PROGRESS.md](PROGRESS.md)** - Task tracking and phase completion status
- **[QUICK_REFERENCE.md](QUICK_REFERENCE.md)** - Quick lookup for key decisions and configurations

## Development Phases

1. **Phase 1: Foundation & Core Features** (3-4 weeks)
   - Project setup, authentication, inventory, customers, sales, basic reporting

2. **Phase 2: Payments & Automation** (2-3 weeks)
   - Stripe integration, document generation, automated reminders, notifications

3. **Phase 3: Events & Multi-Tenant** (3-4 weeks)
   - Event management, calendar sync, subscription billing, consultant features

4. **Phase 4: Team & Recruiting** (2-3 weeks)
   - Recruiting pipeline, landing pages, team structure, platform admin

5. **Phase 5: Advanced Features & AI** (2-3 weeks)
   - Groq AI integration, advanced reporting, marketing features, help system

6. **Phase 6: Polish & Optimization** (1-2 weeks)
   - Performance, security, UX improvements, testing, documentation

**Estimated Total:** 13-19 weeks (3-5 months)

## Business Model

- **System Owner:** Admin account (full platform access)
- **Consultants:** $9.99/month subscription (customizable per user)
- **Revenue:** Subscription fees from team members
- **Independence:** Each consultant operates their own inventory and sales

## Getting Started

### Prerequisites

- PHP 8.3 or higher
- Composer
- MySQL database
- Node.js & NPM (for asset compilation)

### Installation

```bash
# Clone the repository
git clone https://github.com/yourusername/ashbrooke-crm.git
cd ashbrooke-crm

# Install dependencies
composer install
npm install

# Configure environment
cp .env.example .env
php artisan key:generate

# Set up database (update .env with your credentials)
php artisan migrate

# Compile assets
npm run dev

# Start development server
php artisan serve
```

### Required API Keys

Add these to your `.env` file:

- **Stripe:** API keys for payment processing
- **Twilio:** Account SID & Auth Token for SMS
- **SendGrid:** API key for email
- **Groq:** API key for AI insights

## Deployment

### cPanel Deployment

1. Push code to GitHub repository
2. SSH into your server and pull the repository
3. Run `composer install --optimize-autoloader --no-dev`
4. Configure `.env` with production credentials
5. Run `php artisan migrate --force`
6. Set up cron job: `* * * * * php /path/to/artisan schedule:run`
7. Configure SSL certificate (Let's Encrypt)

See full deployment guide in PROJECT_PLAN.md

## Contributing

This is a private business application. Contributions are not currently accepted.

## Security

- All API keys must be stored in `.env` (never commit)
- HTTPS required in production
- Regular security updates recommended
- Report security issues to: [your-email]

## License

Proprietary - All rights reserved

## Support

For questions or issues:
- Review documentation in PROJECT_PLAN.md
- Check QUICK_REFERENCE.md for common configurations
- Contact: [your-email]

---

**Built with ❤️ for Mary Kay consultants**
