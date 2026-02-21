# Ashbrooke CRM - Project Plan

## Project Overview
Web-based inventory and CRM system for Mary Kay business with multi-tenant SaaS capability.

**Business Name:** Ashbrooke  
**Primary User:** Your wife (Admin/Owner)  
**Secondary Users:** Recruited consultants (Independent operators)  
**Hosting:** Namecheap Shared Hosting with cPanel  
**Business Model:** $9.99/month subscription per consultant (customizable per user)

---

## Technology Stack

### Backend
- **Framework:** Laravel (latest stable)
- **PHP Version:** 8.3+
- **Database:** MySQL
- **Queue/Cache:** Database-driven (no Redis)
- **Scheduler:** Laravel Scheduler via cPanel cron

### Frontend
- **UI Framework:** Laravel Livewire
- **CSS Framework:** Tailwind CSS
- **PWA:** Progressive Web App with offline capability
- **Theme:** Mary Kay pink primary, purple accents (wife's favorite)
- **Dark Mode:** Auto-detect system preferences

### Integrations
- **Payment Processing:** Stripe (separate accounts per consultant + Stripe Subscriptions)
- **SMS:** Twilio (shared - admin account)
- **Email Transactional:** Namecheap email service
- **Email Marketing:** SendGrid with campaign tools
- **AI Analytics:** Groq API for insights and recommendations
- **Calendar Sync:** Google Calendar & Outlook integration
- **Tax Calculation:** Manual entry (architecture ready for TaxJar/Avalara API later)
- **Shipping:** Manual entry (architecture ready for ShipStation/EasyPost API later)

### File Storage
- Local server storage (profile pics, PDFs)

### Deployment
- **Version Control:** GitHub (public repository)
- **Deployment Method:** Git push to repo, pull on server
- **Environment:** .env file for secrets (never committed)
- **Error Logging:** File-based, manual review

---

## Core Features Summary

### User Management
- Multi-tenant SaaS architecture
- Role-based access: Admin (owner), Consultant
- Invite code system + manual account creation
- Profile pictures (optional with encouragement)
- Configurable trial periods per consultant
- Stripe subscription management (self-service cancellation)
- 14-day grace period on failed payments
- Account suspension with payment update access
- 1-year data retention after cancellation
- Setup wizard on first login
- Customizable notification preferences (email, SMS, push)

### Inventory Management
- Product catalog with variants (shades, colors)
- Pre-loaded Mary Kay product templates
- Custom categories (hybrid: pre-loaded + customizable)
- Track: SKU, cost, retail price, quantity, tax paid
- Low stock alerts (configurable per product)
- Expiration date tracking with alerts
- Purchase order tracking (restocking)
- Each consultant manages own inventory independently

### Customer CRM
- Contact info: name, phone, email, address, birthday
- Skin type and product preferences
- How they met / relationship notes
- Customer segmentation with tags (pre-defined + custom)
- Purchase history
- Reorder reminders based on product lifespan
- Lead capture from landing page contact forms
- No customer transfers between consultants

### Sales & Orders
- Multiple sale types: direct, party, online
- Inventory deduction on sale
- Stripe integration with saved payment methods
- Manual payment methods: cash, check
- Invoicing with payment tracking
- Discount functionality (percentage or fixed)
- Sales tax calculation (manual with override)
- Shipping cost tracking (manual entry)
- Returns/refunds with optional inventory restoration
- Invoice auto-reminders (configurable per invoice)

### Events & Parties
- Schedule parties and beauty consultations
- Recurring event support
- Invite customers via SMS/email
- RSVP/attendance tracking
- Hostess tracking and custom rewards (from inventory)
- Sales recording at events
- New lead capture at events
- Team visibility (hierarchical - see downline events)
- Event reminders (automated)

### Recruiting Pipeline
- Lead stages: Prospect, Contacted, Interested, Applied, Recruited, Not Interested
- Track: how met, contact date, notes, materials shared
- Automated follow-up reminders
- Available to all consultants for their own recruits
- Public landing page per consultant (limited customization)
- Contact form auto-creates leads

### Team Management
- Genealogy tree tracking (who recruited whom)
- Visual tree diagram + list view (toggle)
- Each consultant sees own team + downline
- No financial connection between upline/downline
- Team communication: announcements, direct messages, team feed
- Onboarding checklist (standard + custom steps)
- Team performance visibility (hierarchical)
- Independent inventory and sales per consultant

### Reporting & Analytics
- **Financial:** Sales totals, profit margins, outstanding invoices, revenue by payment method
- **Inventory:** Current value, low stock, slow-moving products, turnover rate
- **Customer:** Top customers, purchase frequency, inactive customers, lifetime value
- **Product:** Best sellers, slow movers, most profitable, sales by category
- **Sales Activity:** By type, party performance, conversion rates
- **Recruiting:** Pipeline status, conversion rates
- **Expenses:** Categorized tracking (mileage, supplies, marketing)
- **AI Insights:** Groq-powered trend analysis, product bundling suggestions, seasonal patterns
- **Platform Stats:** (Admin only) Total consultants, system-wide sales, active users

### Automation & Notifications
- Configurable reminder types (customizable + add new types)
- Automated sending with rule configuration
- Notification types: appointment reminders, follow-ups, birthdays, reorders, new products
- Multi-channel: Email, SMS, Push notifications
- Daily limits: 100 SMS/day, 500 SMS/month per consultant (configurable)
- Email within SendGrid free tier limits
- Usage warnings at 80%

### Documents & PDFs
- Invoices with discount display
- Receipts
- Packing slips
- Party booking confirmations
- Generic professional branding (no specific logos)
- Consultant contact info included

### Additional Features
- Global search (customers, products, orders, events)
- Bulk actions (messages, product updates)
- Personal calendar view per consultant
- Expense tracking with categories (all consultants)
- Goal tracking (sales, recruitment)
- Product bundling suggestions (AI + manual)
- Frequently bought together tracking
- Data export (CSV/PDF) for all consultants
- Built-in help documentation/knowledge base
- Simple feedback form (emails admin)
- Referral/tracking codes per consultant
- No keyboard shortcuts
- No activity audit logs (basic security logs only)

---

## Development Phases

### Phase 1: Foundation & Core Features (MVP)
**Goal:** Get your wife using the system for her own business

#### 1.1 Project Setup
- [ ] Initialize Laravel project
- [ ] Configure Tailwind CSS
- [ ] Set up Livewire
- [ ] Database design and migrations
- [ ] Authentication system
- [ ] Setup wizard for first-time installation
- [ ] PWA configuration

#### 1.2 User Management
- [ ] Admin account creation
- [ ] User roles and permissions
- [ ] Profile management with photo upload
- [ ] Settings page
- [ ] Dark/light mode (system preference)

#### 1.3 Inventory Management
- [ ] Product categories (pre-loaded Mary Kay + custom)
- [ ] Product CRUD with variants
- [ ] Pre-loaded Mary Kay product templates
- [ ] Stock level tracking
- [ ] Low stock alerts (configurable)
- [ ] Expiration date tracking
- [ ] Purchase order tracking

#### 1.4 Customer CRM
- [ ] Customer CRUD
- [ ] Contact information management
- [ ] Customer notes and preferences
- [ ] Customer tags (pre-defined + custom)
- [ ] Purchase history view
- [ ] Basic search functionality

#### 1.5 Sales & Orders
- [ ] Create sale (direct, party, online types)
- [ ] Inventory deduction
- [ ] Manual payment methods (cash, check)
- [ ] Basic invoicing
- [ ] Sales history
- [ ] Returns/refunds with inventory option

#### 1.6 Basic Reporting
- [ ] Sales summary dashboard
- [ ] Inventory value report
- [ ] Top customers
- [ ] Best-selling products
- [ ] Basic profit calculations

**Deliverable:** Functional system for single user (your wife) to manage inventory, customers, and sales

---

### Phase 2: Payments & Automation
**Goal:** Add payment processing and automated communications

#### 2.1 Stripe Integration
- [ ] Stripe API setup
- [ ] Payment processing for sales
- [ ] Saved payment methods (tokenization)
- [ ] Payment history
- [ ] Refund processing

#### 2.2 Tax & Shipping
- [ ] Manual tax rate entry with override
- [ ] Manual shipping cost entry
- [ ] Architecture for future API integration

#### 2.3 Document Generation
- [ ] DomPDF integration
- [ ] Invoice PDF generation
- [ ] Receipt generation
- [ ] Packing slip generation
- [ ] Email PDF attachments

#### 2.4 Communication Setup
- [ ] Twilio integration (SMS)
- [ ] Namecheap email configuration
- [ ] SendGrid integration (transactional)
- [ ] Email templates
- [ ] SMS templates

#### 2.5 Automated Reminders
- [ ] Reminder type configuration
- [ ] Rule builder for automation
- [ ] Scheduled reminder system
- [ ] Reorder reminders based on product lifespan
- [ ] Invoice payment reminders (auto + manual toggle)
- [ ] Usage limits and warnings

#### 2.6 Push Notifications
- [ ] Browser push notification setup
- [ ] Notification preferences per user
- [ ] Multi-channel notification system

**Deliverable:** Fully automated payment and communication system

---

### Phase 3: Events & Multi-Tenant
**Goal:** Add event management and enable team/consultant features

#### 3.1 Event Management
- [ ] Event/party CRUD
- [ ] Recurring events
- [ ] Event calendar view
- [ ] Hostess tracking
- [ ] Custom hostess rewards (inventory deduction)
- [ ] Attendee management
- [ ] RSVP tracking
- [ ] Event invitations (SMS/email)
- [ ] Event reminders
- [ ] Sales at events
- [ ] New lead capture at events

#### 3.2 Calendar Integration
- [ ] Google Calendar sync
- [ ] Outlook calendar sync
- [ ] Personal calendar view

#### 3.3 Multi-Tenant Architecture
- [ ] Data isolation per consultant
- [ ] Consultant account creation (manual + invite code)
- [ ] Stripe Subscriptions setup
- [ ] Subscription management (self-service)
- [ ] Payment failure handling (14-day grace)
- [ ] Account suspension logic
- [ ] Trial period configuration
- [ ] Custom pricing per consultant

#### 3.4 Consultant Features
- [ ] Consultant dashboard (own stats only)
- [ ] Consultant settings
- [ ] Own inventory management
- [ ] Own customer management
- [ ] Own sales tracking
- [ ] Data export functionality

#### 3.5 Expense Tracking
- [ ] Expense CRUD with categories
- [ ] Mileage tracking
- [ ] Expense reports
- [ ] Available to all consultants

**Deliverable:** Multi-tenant system with event management and subscription billing

---

### Phase 4: Team & Recruiting
**Goal:** Build team management and recruiting pipeline

#### 4.1 Recruiting Pipeline
- [ ] Lead stages and management
- [ ] Lead CRUD with notes
- [ ] Pipeline visualization
- [ ] Automated follow-up reminders
- [ ] Lead conversion tracking
- [ ] Available to all consultants

#### 4.2 Public Landing Pages
- [ ] Landing page template design
- [ ] Per-consultant URL routing
- [ ] Limited customization (photo, headline, bio)
- [ ] Contact form with lead capture
- [ ] Phone number display

#### 4.3 Team Structure
- [ ] Genealogy tree database design
- [ ] Who-recruited-whom tracking
- [ ] Visual tree diagram view
- [ ] List view with levels
- [ ] Toggle between views
- [ ] Hierarchical data access

#### 4.4 Team Features
- [ ] Team dashboard (see downline stats)
- [ ] Team event visibility
- [ ] Team communication (announcements, DMs, feed)
- [ ] Onboarding checklist (standard + custom)
- [ ] Referral/tracking codes

#### 4.5 Platform Admin Features
- [ ] Platform-wide statistics dashboard
- [ ] Consultant management
- [ ] Subscription management
- [ ] System settings (Twilio, SendGrid shared config)
- [ ] Usage monitoring

**Deliverable:** Full team management and recruiting system

---

### Phase 5: Advanced Features & AI
**Goal:** Add AI insights and advanced functionality

#### 5.1 AI Integration
- [ ] Groq API setup
- [ ] Sales trend analysis
- [ ] Product bundling suggestions
- [ ] Frequently bought together tracking
- [ ] Seasonal pattern detection
- [ ] Customer behavior insights
- [ ] On-demand insight generation
- [ ] Automated daily/weekly insights

#### 5.2 Advanced Reporting
- [ ] Custom report builder
- [ ] Date range filtering
- [ ] Export all reports (CSV/PDF)
- [ ] Comparative analysis (month-over-month)
- [ ] Goal tracking with progress
- [ ] Commission calculations (informational)

#### 5.3 Marketing Features
- [ ] SendGrid marketing campaign integration
- [ ] Customer segmentation for campaigns
- [ ] Bulk messaging
- [ ] Campaign performance tracking
- [ ] A/B testing support

#### 5.4 Enhanced Features
- [ ] Global search (all entities)
- [ ] Bulk actions
- [ ] Advanced filtering
- [ ] Saved searches/filters
- [ ] Custom fields (extensibility)

#### 5.5 Help & Support
- [ ] Knowledge base/documentation
- [ ] In-app help tooltips
- [ ] Video tutorials (embed)
- [ ] Feedback form
- [ ] Feature request tracking

**Deliverable:** Complete system with AI-powered insights and advanced features

---

### Phase 6: Polish & Optimization
**Goal:** Performance, security, and user experience improvements

#### 6.1 Performance Optimization
- [ ] Database query optimization
- [ ] Caching strategy
- [ ] Image optimization
- [ ] Lazy loading
- [ ] Code splitting

#### 6.2 Security Hardening
- [ ] Security audit
- [ ] Rate limiting
- [ ] CSRF protection verification
- [ ] XSS prevention
- [ ] SQL injection prevention
- [ ] API key rotation system

#### 6.3 UX Improvements
- [ ] Loading states
- [ ] Error handling
- [ ] Toast notifications
- [ ] Confirmation dialogs
- [ ] Keyboard navigation
- [ ] Mobile responsiveness testing

#### 6.4 Testing
- [ ] Unit tests for critical functions
- [ ] Feature tests for main workflows
- [ ] Browser compatibility testing
- [ ] Mobile device testing
- [ ] Load testing

#### 6.5 Documentation
- [ ] API integration guides (TaxJar, shipping APIs)
- [ ] Deployment documentation
- [ ] Admin user guide
- [ ] Consultant user guide
- [ ] Developer documentation

**Deliverable:** Production-ready, optimized system

---

## Database Schema Overview

### Core Tables
- **users** - All system users (admin + consultants)
- **subscriptions** - Stripe subscription tracking
- **products** - Product catalog
- **product_variants** - Product variations (shades, colors)
- **product_categories** - Inventory categories
- **inventory** - Stock levels per consultant per product
- **customers** - Customer information
- **customer_tags** - Segmentation tags
- **sales** - Sales transactions
- **sale_items** - Line items per sale
- **payments** - Payment tracking
- **invoices** - Invoice generation and tracking
- **events** - Parties and consultations
- **event_attendees** - RSVP and attendance
- **expenses** - Business expense tracking
- **reminders** - Scheduled notifications
- **notifications** - Notification history
- **leads** - Recruiting pipeline
- **team_structure** - Genealogy tracking
- **messages** - Internal communication
- **settings** - System and user settings
- **ai_insights** - Cached AI analysis results

---

## Security Considerations

### Data Protection
- All passwords hashed (bcrypt)
- API keys in .env only
- HTTPS required (SSL certificate)
- CSRF protection on all forms
- XSS prevention (Blade escaping)
- SQL injection prevention (Eloquent ORM)

### Access Control
- Role-based permissions
- Data isolation per consultant
- Hierarchical access (see own + downline only)
- API rate limiting
- Failed login throttling

### Payment Security
- PCI compliance via Stripe
- No card data stored locally
- Tokenized payment methods only
- Secure webhook handling

### Privacy
- 1-year data retention policy
- No cross-consultant data sharing
- Secure file uploads
- Email/SMS opt-out capability

---

## API Keys Required

### Production
- Stripe API keys (admin + per consultant)
- Twilio Account SID & Auth Token (admin only)
- SendGrid API key (admin only)
- Groq API key (admin only)
- Google Calendar API (optional, per consultant)
- Microsoft Graph API for Outlook (optional, per consultant)

### Future Integrations (Architecture Ready)
- TaxJar API key
- ShipStation/EasyPost API key

---

## Deployment Checklist

### Initial Setup
- [ ] Purchase domain (ashbrooke.com or similar)
- [ ] Configure DNS on Namecheap
- [ ] Set up SSL certificate
- [ ] Create MySQL database
- [ ] Configure cPanel cron job
- [ ] Clone repository to server
- [ ] Run composer install
- [ ] Configure .env file
- [ ] Run migrations
- [ ] Run setup wizard

### Ongoing Maintenance
- [ ] Weekly database backups (cPanel)
- [ ] Monthly security updates
- [ ] Monitor error logs
- [ ] Review API usage/costs
- [ ] Update Laravel dependencies

---

## Cost Estimates (Monthly)

### Fixed Costs
- Namecheap hosting: ~$10-30/month
- Domain: ~$1/month (annual)
- SSL certificate: Free (Let's Encrypt)

### Variable Costs (Scale with usage)
- Twilio SMS: ~$0.0079 per message
- SendGrid: Free up to 100 emails/day, then ~$15/month
- Stripe: 2.9% + $0.30 per transaction
- Groq API: Pay-as-you-go (very affordable)

### Revenue
- $9.99/month per consultant
- Break-even: ~2-3 consultants

---

## Success Metrics

### Phase 1 Success
- Your wife actively using system daily
- All inventory tracked
- All customers in system
- Sales recorded consistently

### Phase 2 Success
- 100% of sales processed through Stripe
- Automated reminders sending
- Invoices generated automatically

### Phase 3 Success
- First consultant recruited and onboarded
- Events scheduled and tracked
- Subscription billing working

### Phase 4 Success
- 5+ consultants using system
- Recruiting pipeline active
- Team communication happening

### Phase 5 Success
- AI insights being used for decisions
- Marketing campaigns running
- Advanced reports utilized

### Phase 6 Success
- 20+ consultants subscribed
- System stable and performant
- Positive user feedback
- Revenue exceeding costs

---

## Timeline Estimates

- **Phase 1:** 3-4 weeks
- **Phase 2:** 2-3 weeks
- **Phase 3:** 3-4 weeks
- **Phase 4:** 2-3 weeks
- **Phase 5:** 2-3 weeks
- **Phase 6:** 1-2 weeks

**Total:** ~13-19 weeks (3-5 months)

*Note: Timeline assumes consistent development effort. Can be accelerated or extended based on availability.*

---

## Next Steps

1. Review and approve this plan
2. Set up development environment
3. Create GitHub repository
4. Begin Phase 1 development
5. Regular progress updates

---

## Notes

- All features designed for shared hosting compatibility
- Architecture allows for future scaling to VPS/cloud if needed
- Public repository requires careful .env management
- Each phase delivers working, deployable functionality
- Can pause between phases for testing/feedback
- Consultant independence is core principle (no upline financial involvement)
- System owner (your wife) earns via subscriptions only
- Mary Kay branding with purple accents for personalization

---

**Document Version:** 1.0  
**Last Updated:** 2024  
**Status:** Planning Complete - Ready for Development
