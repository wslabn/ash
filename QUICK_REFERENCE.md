# Ashbrooke CRM - Quick Reference Guide

## Key Decisions Summary

### Business Model
- **System Name:** Ashbrooke CRM
- **Owner:** Your wife (Admin)
- **Business Type:** Mary Kay independent consultant with team building
- **Revenue Model:** $9.99/month per consultant (customizable)
- **Consultant Independence:** Each consultant operates independently with own inventory/sales

### Technology Choices
- **Backend:** Laravel (PHP 8.3+)
- **Frontend:** Livewire + Tailwind CSS
- **Database:** MySQL
- **Hosting:** Namecheap Shared Hosting with cPanel
- **Deployment:** Git (public GitHub repo)
- **PWA:** Yes, with offline capability

### Design & Branding
- **Primary Color:** Mary Kay Pink
- **Accent Color:** Purple (wife's favorite)
- **Theme:** Auto dark/light mode (system preference)
- **Branding:** Generic professional (no specific logos on documents)

### Integrations

#### Payment
- **Stripe:** Separate accounts per consultant + Stripe Subscriptions
- **Saved Cards:** Yes (tokenized)
- **Subscription:** $9.99/month default, customizable per consultant
- **Trial Period:** Configurable per consultant
- **Grace Period:** 14 days on failed payments

#### Communication
- **SMS:** Twilio (shared - admin configures in platform settings)
- **Email Transactional:** SendGrid (shared - admin configures in platform settings)
- **Email Marketing:** SendGrid with campaign tools
- **Push Notifications:** Yes (browser-based)
- **Limits:** 100 SMS/day, 500 SMS/month per consultant (configurable)

#### Discord
- **Community:** Official Ashbrooke CRM Discord server for all consultants
- **Team Chat:** Each consultant can set their own team Discord invite
- **Feedback:** Bug reports and feature requests post to Discord webhook
- **Notifications:** Milestones, low stock alerts, recruiting updates

#### AI & Analytics
- **AI Provider:** Groq API
- **Usage:** Trend analysis, product suggestions, insights
- **Frequency:** On-demand + automated daily/weekly

#### Calendar
- **Sync:** Google Calendar + Outlook
- **View:** Personal calendar per consultant

#### Future Ready
- **Tax API:** Architecture ready for TaxJar/Avalara
- **Shipping API:** Architecture ready for ShipStation/EasyPost

### Core Features

#### Inventory
- **Management:** Per consultant, independent
- **Variants:** Yes (shades, colors, etc.)
- **Templates:** Pre-loaded Mary Kay products
- **Categories:** Hybrid (pre-loaded + custom)
- **Alerts:** Low stock (configurable), expiration dates
- **Tracking:** Cost, tax paid, retail price, quantity

#### Customers
- **Data:** Name, phone, email, address, birthday, skin type, preferences
- **Notes:** How met, relationship notes
- **Segmentation:** Tags (pre-defined + custom)
- **History:** Purchase history, reorder reminders
- **Transfers:** No (customers stay with consultant)

#### Sales
- **Types:** Direct, party, online
- **Payments:** Stripe, cash, check, card, venmo, paypal, invoice
- **Features:** Discounts, tax calculation, shipping, returns
- **Inventory:** Auto-deduction on sale
- **Invoices:** Browser print (save as PDF or print)
- **Sale Numbers:** Customizable starting point (1, 100, 1000, 10000)

#### Events
- **Types:** Parties, beauty consultations
- **Features:** Recurring events, RSVP, invitations, reminders
- **Hostess:** Tracking with custom rewards (from inventory)
- **Visibility:** Team can see downline events
- **Lead Capture:** New contacts at events

#### Team Management
- **Structure:** Genealogy tree (who recruited whom)
- **Views:** Visual tree + list view (toggle)
- **Access:** Hierarchical (see own + downline)
- **Financial:** No upline involvement in downline sales
- **Communication:** Announcements, DMs, team feed

#### Recruiting
- **Pipeline:** Prospect → Contacted → Interested → Applied → Recruited
- **Landing Pages:** Per consultant at custom URLs (ashbrooke.com/ashley)
- **Lead Capture:** Contact form auto-creates customers
- **Customization:** Photo/logo, headline, bio, social links
- **Spam Protection:** No phone/email displayed publicly
- **Automation:** Follow-up reminders (planned)
- **Access:** All consultants manage own pipeline

### User Management

#### Roles
- **Admin:** System owner (your wife) - full access
- **Consultant:** Team members - own data + downline view

#### Account Creation
- **Methods:** Manual by admin OR invite code self-registration
- **Onboarding:** Setup wizard + checklist
- **Profile:** Photo (optional with encouragement)

#### Subscription Management
- **Billing:** Stripe Subscriptions (automatic)
- **Self-Service:** Consultants can cancel, update payment
- **Failed Payment:** 14-day grace → suspension → limited access to update payment
- **Cancellation:** Account deactivated, data retained 1 year

### Security & Privacy

#### Authentication
- **Method:** Password-based (strong passwords)
- **2FA:** Not initially (can add later)
- **Logging:** Basic security logs only (no activity spying)

#### Data Protection
- **Isolation:** Per consultant (can't see others' data)
- **Access:** Hierarchical (see own + downline only)
- **Retention:** 1-year after cancellation
- **Deletion:** No permanent deletion (deactivation only)
- **Backups:** Manual via cPanel

#### API Keys
- **Storage:** .env file (never committed to Git)
- **Required:** Stripe, Twilio, SendGrid, Groq
- **Optional:** Google Calendar, Outlook, future tax/shipping APIs

#### Notifications

**Discord Milestones:**
- Sales count: 10, 25, 50, 100, 250, 500, 1000
- Revenue: $1k, $5k, $10k, $25k, $50k, $100k
- Customers: 10, 25, 50, 100, 250, 500, 1000

**Discord Alerts:**
- Low stock (5 or below after sale)
- Recruiting interest shown
- Customer converted to consultant

**Channels**
- **Email:** Transactional + marketing
- **SMS:** Reminders, alerts
- **Push:** Browser notifications
- **Discord:** Milestones, alerts, feedback

#### Preferences
- **Granular:** Per notification type
- **Configurable:** Each consultant controls own preferences
- **Critical:** Always sent (payment failures, security)

#### Types
- Appointment reminders
- Follow-up after purchase
- Birthday messages
- Reorder reminders
- New product announcements
- Event invitations
- Payment confirmations
- Low stock alerts
- Expiration warnings
- Recruiting follow-ups

### Reporting & Analytics

#### Standard Reports
- Sales totals (day/week/month/year)
- Profit margins
- Outstanding invoices
- Inventory value
- Top customers/products
- Customer lifetime value
- Party performance
- Expense tracking

#### AI Insights (Groq)
- Sales trend analysis
- Product bundling suggestions
- Frequently bought together
- Seasonal patterns
- Customer behavior predictions
- Reorder timing optimization

#### Platform Stats (Admin Only)
- Total consultants
- System-wide sales
- Active users
- Subscription revenue
- Usage metrics

### Documents & PDFs

#### Generated Documents
- Invoices (with discounts shown)
- Receipts
- Packing slips
- Party booking confirmations

#### Format
- **Library:** DomPDF
- **Branding:** Generic professional
- **Content:** Consultant contact info, no logos

### Additional Features

#### Admin Settings Page
- **SendGrid:** API key, from address, from name
- **Twilio:** Account SID, auth token, phone number
- **Discord:** Community invite, feedback webhook
- **No .env editing required** - all configured through UI

#### Profile Enhancements
- **Photos:** Profile photo and business logo uploads
- **Contact:** Phone number
- **Social Media:** Facebook, Instagram, YouTube, Website URLs
- **Team Chat:** Discord invite link for team
- **Business Settings:** Sale number starting point
- **Landing Page:** Custom slug, headline, bio, enable/disable toggle

#### Search
- **Type:** Global (customers, products, orders, events)
- **Scope:** Per consultant (own data only)

#### Bulk Actions
- **Supported:** Messages, product updates
- **Usage:** Marketing campaigns, inventory management

#### Calendar
- **View:** Personal per consultant
- **Sync:** Google + Outlook
- **Events:** Parties, consultations, reminders

#### Expenses
- **Tracking:** Categorized (mileage, supplies, marketing)
- **Access:** All consultants
- **Purpose:** Tax reporting

#### Goals
- **Types:** Sales targets, recruitment goals
- **Tracking:** Progress indicators
- **Visibility:** Own goals only

#### Help & Support
- **Documentation:** Built-in knowledge base
- **Feedback:** Simple form (emails admin)
- **Support:** No ticketing system

### What's NOT Included

- ❌ Customer login portal (admin system only)
- ❌ Keyboard shortcuts
- ❌ Activity audit logs (no spying)
- ❌ Customer transfers between consultants
- ❌ Upline commission on downline sales
- ❌ Product images (text descriptions only)
- ❌ Two-factor authentication (initially)
- ❌ Staging environment (dev local, deploy to prod)
- ❌ Email notifications for every action (configurable only)
- ❌ Automatic data deletion (deactivation + 1-year retention)

### Development Approach

#### Phased Deployment
1. **Phase 1:** Core features for single user (your wife)
2. **Phase 2:** Payments and automation
3. **Phase 3:** Events and multi-tenant
4. **Phase 4:** Team and recruiting
5. **Phase 5:** AI and advanced features
6. **Phase 6:** Polish and optimization

#### Each Phase Delivers
- Working, deployable functionality
- Can pause for testing/feedback
- Incremental value delivery

### Cost Structure

#### Fixed Monthly
- Hosting: ~$10-30
- Domain: ~$1
- SSL: Free

#### Variable (Usage-Based)
- Twilio SMS: ~$0.0079/message
- SendGrid: Free (100/day) or ~$15/month
- Stripe: 2.9% + $0.30/transaction
- Groq: Pay-as-you-go

#### Revenue
- $9.99/month per consultant
- Break-even: 2-3 consultants

### Timeline
- **Phase 1:** 3-4 weeks
- **Phase 2:** 2-3 weeks
- **Phase 3:** 3-4 weeks
- **Phase 4:** 2-3 weeks
- **Phase 5:** 2-3 weeks
- **Phase 6:** 1-2 weeks
- **Total:** 13-19 weeks (3-5 months)

---

## Important Reminders

### For Development
- Always use .env for secrets
- Never commit API keys
- Test on local before deploying
- Update PROGRESS.md as you complete tasks
- Each consultant's data is isolated
- No financial connection between upline/downline

### For Deployment
- Set up cPanel cron: `* * * * * php /path/artisan schedule:run`
- Configure .env with production keys
- Run migrations
- Test Stripe webhooks
- Verify email/SMS sending
- Check SSL certificate

### For Your Wife
- She's the system owner (admin)
- Controls all shared integrations (Twilio, SendGrid)
- Manages consultant subscriptions
- Sees platform-wide statistics
- Can customize pricing per consultant
- Earns revenue from subscriptions only

### For Consultants
- Independent operators
- Own inventory and sales
- Own Stripe account
- Use shared SMS/email (admin pays)
- Can recruit and build own team
- No upline involvement in their business
- Pay $9.99/month subscription

---

**Quick Reference Version:** 3.0  
**Last Updated:** February 24, 2026  
**For Questions:** Refer to PROJECT_PLAN.md for full details
