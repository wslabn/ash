# Ashbrooke CRM - Database Schema

## Overview
This document outlines the complete database structure for Ashbrooke CRM.

---

## Core Tables

### users
Primary table for all system users (admin and consultants)

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| name | varchar(255) | Full name |
| email | varchar(255) | Email (unique) |
| email_verified_at | timestamp | Email verification |
| password | varchar(255) | Hashed password |
| role | enum | 'admin', 'consultant' |
| phone | varchar(20) | Phone number |
| profile_photo | varchar(255) | Profile picture path |
| bio | text | Personal bio |
| headline | varchar(100) | Landing page headline |
| recruited_by | bigint (FK) | Parent consultant ID |
| invite_code | varchar(50) | Unique invite code |
| status | enum | 'active', 'suspended', 'cancelled' |
| trial_ends_at | timestamp | Trial period end date |
| suspended_at | timestamp | Account suspension date |
| cancelled_at | timestamp | Cancellation date |
| referral_code | varchar(50) | Unique referral tracking code |
| remember_token | varchar(100) | Remember me token |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes:** email, invite_code, referral_code, recruited_by, status

---

### subscriptions
Stripe subscription tracking

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| user_id | bigint (FK) | User reference |
| stripe_subscription_id | varchar(255) | Stripe subscription ID |
| stripe_customer_id | varchar(255) | Stripe customer ID |
| stripe_price_id | varchar(255) | Stripe price ID |
| status | enum | 'active', 'past_due', 'cancelled', 'trialing' |
| price | decimal(8,2) | Monthly price |
| trial_ends_at | timestamp | Trial end date |
| current_period_start | timestamp | Billing period start |
| current_period_end | timestamp | Billing period end |
| cancelled_at | timestamp | Cancellation date |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes:** user_id, stripe_subscription_id, stripe_customer_id, status

---

### payment_methods
Saved Stripe payment methods

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| user_id | bigint (FK) | User reference |
| stripe_payment_method_id | varchar(255) | Stripe PM ID |
| type | varchar(50) | card, bank_account |
| brand | varchar(50) | Visa, Mastercard, etc. |
| last_four | varchar(4) | Last 4 digits |
| exp_month | int | Expiration month |
| exp_year | int | Expiration year |
| is_default | boolean | Default payment method |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes:** user_id, stripe_payment_method_id, is_default

---

## Inventory Tables

### product_categories
Product categories (pre-loaded + custom)

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| user_id | bigint (FK) | Creator (null = system default) |
| name | varchar(100) | Category name |
| description | text | Category description |
| is_system | boolean | System pre-loaded category |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes:** user_id, is_system

---

### products
Product catalog

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| user_id | bigint (FK) | Owner consultant |
| category_id | bigint (FK) | Category reference |
| name | varchar(255) | Product name |
| sku | varchar(100) | SKU code |
| description | text | Product description |
| base_cost | decimal(10,2) | Consultant's cost |
| base_retail_price | decimal(10,2) | Retail price |
| has_variants | boolean | Has color/shade variants |
| is_template | boolean | Mary Kay template product |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes:** user_id, category_id, sku, is_template

---

### product_variants
Product variations (shades, colors, sizes)

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| product_id | bigint (FK) | Product reference |
| name | varchar(100) | Variant name (e.g., "Ivory") |
| sku | varchar(100) | Variant SKU |
| cost_adjustment | decimal(10,2) | Price difference from base |
| retail_adjustment | decimal(10,2) | Retail price difference |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes:** product_id, sku

---

### inventory
Stock tracking per consultant

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| user_id | bigint (FK) | Consultant owner |
| product_id | bigint (FK) | Product reference |
| variant_id | bigint (FK) | Variant reference (nullable) |
| quantity | int | Current stock level |
| cost_per_unit | decimal(10,2) | Actual cost paid |
| tax_paid_per_unit | decimal(10,2) | Tax paid on purchase |
| retail_price | decimal(10,2) | Selling price |
| low_stock_threshold | int | Alert threshold |
| expiration_date | date | Product expiration (nullable) |
| batch_number | varchar(100) | Batch/lot number (nullable) |
| purchased_at | timestamp | Purchase date |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes:** user_id, product_id, variant_id, quantity, expiration_date

---

### purchase_orders
Inventory restocking orders

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| user_id | bigint (FK) | Consultant reference |
| order_number | varchar(100) | PO number |
| supplier | varchar(255) | Mary Kay or other |
| total_cost | decimal(10,2) | Total order cost |
| total_tax | decimal(10,2) | Total tax paid |
| status | enum | 'pending', 'received', 'cancelled' |
| ordered_at | timestamp | Order date |
| received_at | timestamp | Receipt date |
| notes | text | Order notes |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes:** user_id, order_number, status

---

### purchase_order_items
Line items for purchase orders

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| purchase_order_id | bigint (FK) | PO reference |
| product_id | bigint (FK) | Product reference |
| variant_id | bigint (FK) | Variant reference (nullable) |
| quantity | int | Quantity ordered |
| cost_per_unit | decimal(10,2) | Unit cost |
| tax_per_unit | decimal(10,2) | Tax per unit |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes:** purchase_order_id, product_id, variant_id

---

## Customer Tables

### customers
Customer information

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| user_id | bigint (FK) | Consultant owner |
| first_name | varchar(100) | First name |
| last_name | varchar(100) | Last name |
| email | varchar(255) | Email address |
| phone | varchar(20) | Phone number |
| address_line1 | varchar(255) | Street address |
| address_line2 | varchar(255) | Apt/Suite (nullable) |
| city | varchar(100) | City |
| state | varchar(50) | State/Province |
| zip_code | varchar(20) | ZIP/Postal code |
| country | varchar(50) | Country |
| birthday | date | Birthday (nullable) |
| skin_type | varchar(50) | Skin type (nullable) |
| preferences | text | Product preferences |
| how_met | varchar(255) | How they met |
| notes | text | Relationship notes |
| stripe_customer_id | varchar(255) | Stripe customer ID (nullable) |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes:** user_id, email, phone, stripe_customer_id

---

### customer_tags
Customer segmentation tags

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| user_id | bigint (FK) | Creator (null = system) |
| name | varchar(100) | Tag name |
| color | varchar(7) | Hex color code |
| is_system | boolean | System pre-defined tag |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes:** user_id, is_system

---

### customer_tag_pivot
Many-to-many relationship

| Column | Type | Description |
|--------|------|-------------|
| customer_id | bigint (FK) | Customer reference |
| tag_id | bigint (FK) | Tag reference |

**Indexes:** customer_id, tag_id

---

## Sales Tables

### sales
Sales transactions

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| user_id | bigint (FK) | Consultant reference |
| customer_id | bigint (FK) | Customer reference |
| event_id | bigint (FK) | Event reference (nullable) |
| sale_number | varchar(100) | Unique sale number |
| sale_type | enum | 'direct', 'party', 'online' |
| subtotal | decimal(10,2) | Before tax/shipping |
| discount_amount | decimal(10,2) | Discount applied |
| discount_type | enum | 'percentage', 'fixed' |
| tax_amount | decimal(10,2) | Sales tax |
| tax_rate | decimal(5,4) | Tax rate used |
| shipping_amount | decimal(10,2) | Shipping cost |
| total_amount | decimal(10,2) | Final total |
| payment_status | enum | 'pending', 'paid', 'partial', 'refunded' |
| payment_method | enum | 'stripe', 'cash', 'check', 'invoice' |
| stripe_payment_intent_id | varchar(255) | Stripe PI ID (nullable) |
| notes | text | Sale notes |
| sold_at | timestamp | Sale date |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes:** user_id, customer_id, event_id, sale_number, payment_status, sold_at

---

### sale_items
Line items for sales

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| sale_id | bigint (FK) | Sale reference |
| product_id | bigint (FK) | Product reference |
| variant_id | bigint (FK) | Variant reference (nullable) |
| quantity | int | Quantity sold |
| unit_cost | decimal(10,2) | Consultant's cost |
| unit_price | decimal(10,2) | Selling price |
| discount_amount | decimal(10,2) | Line item discount |
| subtotal | decimal(10,2) | Line total |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes:** sale_id, product_id, variant_id

---

### payments
Payment tracking

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| sale_id | bigint (FK) | Sale reference |
| amount | decimal(10,2) | Payment amount |
| payment_method | enum | 'stripe', 'cash', 'check' |
| stripe_payment_intent_id | varchar(255) | Stripe PI ID (nullable) |
| check_number | varchar(50) | Check number (nullable) |
| status | enum | 'pending', 'completed', 'failed', 'refunded' |
| paid_at | timestamp | Payment date |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes:** sale_id, stripe_payment_intent_id, status

---

### invoices
Invoice generation and tracking

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| sale_id | bigint (FK) | Sale reference |
| invoice_number | varchar(100) | Unique invoice number |
| status | enum | 'draft', 'sent', 'paid', 'overdue', 'cancelled' |
| due_date | date | Payment due date |
| auto_reminder | boolean | Send auto reminders |
| last_reminder_sent | timestamp | Last reminder date |
| pdf_path | varchar(255) | Generated PDF path |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes:** sale_id, invoice_number, status, due_date

---

### returns
Product returns and refunds

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| sale_id | bigint (FK) | Original sale |
| user_id | bigint (FK) | Consultant reference |
| customer_id | bigint (FK) | Customer reference |
| return_number | varchar(100) | Unique return number |
| total_amount | decimal(10,2) | Refund amount |
| restore_inventory | boolean | Add back to inventory |
| reason | text | Return reason |
| status | enum | 'pending', 'approved', 'completed', 'rejected' |
| returned_at | timestamp | Return date |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes:** sale_id, user_id, customer_id, return_number, status

---

### return_items
Line items for returns

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| return_id | bigint (FK) | Return reference |
| sale_item_id | bigint (FK) | Original sale item |
| product_id | bigint (FK) | Product reference |
| variant_id | bigint (FK) | Variant reference (nullable) |
| quantity | int | Quantity returned |
| refund_amount | decimal(10,2) | Refund for this item |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes:** return_id, sale_item_id, product_id

---

## Event Tables

### events
Parties and consultations

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| user_id | bigint (FK) | Consultant owner |
| title | varchar(255) | Event title |
| type | enum | 'party', 'consultation', 'meeting', 'other' |
| description | text | Event description |
| location | varchar(255) | Event location |
| start_time | timestamp | Start date/time |
| end_time | timestamp | End date/time |
| hostess_id | bigint (FK) | Hostess customer ID (nullable) |
| hostess_reward_amount | decimal(10,2) | Reward value (nullable) |
| is_recurring | boolean | Recurring event |
| recurrence_rule | text | iCal RRULE format |
| status | enum | 'scheduled', 'completed', 'cancelled' |
| notes | text | Event notes |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes:** user_id, hostess_id, start_time, status, is_recurring

---

### event_attendees
Event RSVP and attendance

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| event_id | bigint (FK) | Event reference |
| customer_id | bigint (FK) | Customer reference (nullable) |
| name | varchar(255) | Name (for new leads) |
| email | varchar(255) | Email (for new leads) |
| phone | varchar(20) | Phone (for new leads) |
| rsvp_status | enum | 'invited', 'accepted', 'declined', 'maybe' |
| attended | boolean | Actually attended |
| is_new_lead | boolean | New contact captured |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes:** event_id, customer_id, rsvp_status, is_new_lead

---

## Recruiting Tables

### leads
Recruiting pipeline

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| user_id | bigint (FK) | Consultant owner |
| first_name | varchar(100) | First name |
| last_name | varchar(100) | Last name |
| email | varchar(255) | Email address |
| phone | varchar(20) | Phone number |
| stage | enum | 'prospect', 'contacted', 'interested', 'applied', 'recruited', 'not_interested' |
| how_met | varchar(255) | How they met |
| source | varchar(100) | Lead source |
| contacted_at | timestamp | First contact date |
| next_follow_up | timestamp | Next follow-up date |
| notes | text | Lead notes |
| materials_shared | text | Materials sent |
| converted_user_id | bigint (FK) | User ID if recruited (nullable) |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes:** user_id, email, phone, stage, next_follow_up, converted_user_id

---

### lead_activities
Activity log for leads

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| lead_id | bigint (FK) | Lead reference |
| activity_type | enum | 'call', 'email', 'meeting', 'note' |
| description | text | Activity description |
| occurred_at | timestamp | Activity date |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes:** lead_id, activity_type, occurred_at

---

## Team Tables

### team_structure
Genealogy tracking

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| user_id | bigint (FK) | Consultant |
| parent_id | bigint (FK) | Upline consultant (nullable) |
| level | int | Tree depth level |
| path | text | Materialized path |
| joined_at | timestamp | Join date |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes:** user_id, parent_id, level

---

### onboarding_checklists
Onboarding tasks

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| title | varchar(255) | Task title |
| description | text | Task description |
| order | int | Display order |
| is_system | boolean | System default task |
| created_by | bigint (FK) | Creator user ID (nullable) |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes:** is_system, order

---

### onboarding_progress
User onboarding completion

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| user_id | bigint (FK) | Consultant reference |
| checklist_id | bigint (FK) | Checklist item reference |
| completed | boolean | Completion status |
| completed_at | timestamp | Completion date (nullable) |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes:** user_id, checklist_id, completed

---

## Communication Tables

### messages
Internal team communication

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| sender_id | bigint (FK) | Sender user ID |
| recipient_id | bigint (FK) | Recipient user ID (nullable for announcements) |
| type | enum | 'direct', 'announcement', 'team_feed' |
| subject | varchar(255) | Message subject (nullable) |
| body | text | Message content |
| read_at | timestamp | Read timestamp (nullable) |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes:** sender_id, recipient_id, type, read_at

---

### reminders
Scheduled notifications

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| user_id | bigint (FK) | Consultant owner |
| type | varchar(100) | Reminder type |
| title | varchar(255) | Reminder title |
| message | text | Reminder message |
| related_type | varchar(100) | Related model type (nullable) |
| related_id | bigint | Related model ID (nullable) |
| send_via_email | boolean | Send email |
| send_via_sms | boolean | Send SMS |
| send_via_push | boolean | Send push notification |
| scheduled_for | timestamp | Send date/time |
| sent_at | timestamp | Actual send time (nullable) |
| status | enum | 'pending', 'sent', 'failed', 'cancelled' |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes:** user_id, type, scheduled_for, status

---

### notifications
Notification history

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| user_id | bigint (FK) | Recipient user ID |
| type | varchar(255) | Notification type |
| channel | enum | 'email', 'sms', 'push' |
| title | varchar(255) | Notification title |
| message | text | Notification content |
| data | json | Additional data |
| read_at | timestamp | Read timestamp (nullable) |
| sent_at | timestamp | Send timestamp |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes:** user_id, type, channel, read_at, sent_at

---

### notification_preferences
User notification settings

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| user_id | bigint (FK) | User reference |
| notification_type | varchar(100) | Type of notification |
| email_enabled | boolean | Email notifications |
| sms_enabled | boolean | SMS notifications |
| push_enabled | boolean | Push notifications |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes:** user_id, notification_type

---

## Expense Tables

### expenses
Business expense tracking

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| user_id | bigint (FK) | Consultant reference |
| category | varchar(100) | Expense category |
| description | text | Expense description |
| amount | decimal(10,2) | Expense amount |
| expense_date | date | Date of expense |
| receipt_path | varchar(255) | Receipt image path (nullable) |
| is_mileage | boolean | Mileage expense |
| miles | decimal(8,2) | Miles driven (nullable) |
| mileage_rate | decimal(5,3) | Rate per mile (nullable) |
| notes | text | Additional notes |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes:** user_id, category, expense_date, is_mileage

---

## Analytics Tables

### goals
Sales and recruiting goals

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| user_id | bigint (FK) | Consultant reference |
| type | enum | 'sales', 'recruitment', 'custom' |
| title | varchar(255) | Goal title |
| target_value | decimal(10,2) | Target amount/count |
| current_value | decimal(10,2) | Current progress |
| period_start | date | Goal period start |
| period_end | date | Goal period end |
| status | enum | 'active', 'completed', 'failed', 'cancelled' |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes:** user_id, type, status, period_end

---

### ai_insights
Cached AI analysis results

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| user_id | bigint (FK) | Consultant reference (nullable for platform-wide) |
| insight_type | varchar(100) | Type of insight |
| title | varchar(255) | Insight title |
| content | text | Insight content |
| data | json | Structured data |
| generated_at | timestamp | Generation timestamp |
| expires_at | timestamp | Cache expiration |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes:** user_id, insight_type, generated_at, expires_at

---

### product_associations
Frequently bought together tracking

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| product_a_id | bigint (FK) | First product |
| product_b_id | bigint (FK) | Second product |
| times_bought_together | int | Co-purchase count |
| confidence_score | decimal(5,4) | Association strength |
| last_occurred_at | timestamp | Last co-purchase |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes:** product_a_id, product_b_id, times_bought_together

---

## Settings Tables

### settings
System and user settings

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| user_id | bigint (FK) | User reference (nullable for system) |
| key | varchar(255) | Setting key |
| value | text | Setting value |
| type | varchar(50) | Data type |
| is_system | boolean | System setting |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes:** user_id, key, is_system

---

### api_usage
API usage tracking

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| user_id | bigint (FK) | User reference |
| service | varchar(100) | API service name |
| endpoint | varchar(255) | API endpoint |
| usage_count | int | Number of calls |
| usage_date | date | Usage date |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Indexes:** user_id, service, usage_date

---

## Relationships Summary

### One-to-Many
- users → subscriptions
- users → payment_methods
- users → products
- users → inventory
- users → customers
- users → sales
- users → events
- users → leads
- users → expenses
- users → goals
- users → messages (as sender)
- users → messages (as recipient)
- users → reminders
- users → notifications
- products → product_variants
- products → inventory
- sales → sale_items
- sales → payments
- sales → invoices
- events → event_attendees
- leads → lead_activities
- returns → return_items

### Many-to-Many
- customers ↔ customer_tags (via customer_tag_pivot)

### Self-Referencing
- users → users (recruited_by)
- team_structure → team_structure (parent_id)

### Polymorphic (via related_type/related_id)
- reminders → any model

---

## Indexes Strategy

### Primary Indexes
- All foreign keys
- Email addresses
- Phone numbers
- Status fields
- Date fields for reporting

### Composite Indexes
- (user_id, created_at) for user-scoped queries
- (user_id, status) for filtered lists
- (product_id, variant_id) for inventory lookups

---

## Data Retention

- Active users: Indefinite
- Cancelled users: 365 days then purge
- Sales history: Indefinite
- Notifications: 90 days
- AI insights cache: 7 days
- Logs: 30 days

---

**Schema Version:** 1.0  
**Last Updated:** 2024  
**Total Tables:** 40+
