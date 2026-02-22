# Demo Data Guide

## Test Accounts

### Admin Account
- **Email:** ashley@ashbrooke.com
- **Password:** password123
- **Role:** Admin (full access)

### Consultant Accounts
- **Email:** emily@example.com
- **Password:** password123
- **Role:** Consultant (converted from customer Jennifer Wilson)

- **Email:** rachel@example.com
- **Password:** password123
- **Role:** Consultant (converted from customer Ashley Moore)

## Demo Data Overview

### Customers (10 Total)
- **Jane Doe** - VIP tag, recruiting interest, has notes about business opportunity
- **Sarah Smith** - Regular customer
- **Maria Garcia** - Recruiting interest, has follow-up notes
- **Lisa Brown** - VIP + Hostess tags, hosted successful party
- **Jennifer Wilson** - ✅ Converted to consultant (Emily Johnson)
- **Amanda Taylor** - Regular customer
- **Michelle Anderson** - Hostess tag, recruiting interest
- **Jessica Thomas** - Regular customer
- **Ashley Moore** - ✅ Converted to consultant (Rachel Martinez)
- **Stephanie Jackson** - Regular customer

### Products (6 Total)
**Skincare:**
- TimeWise Foundation ($30.00)
- Miracle Set ($90.00)

**Makeup:**
- Lipstick - Pink Passion ($16.00)
- Mascara - Ultimate ($20.00)
- Eye Shadow Palette ($36.00)

**Fragrance:**
- Bella Belara Perfume ($40.00)

### Sales (15 Total)
- Mix of **Direct**, **Party**, and **Online** sales
- Various payment methods: Cash, Card, Venmo, PayPal
- Multiple items per sale (1-4 products)
- Sales dated over the past 60 days
- Sale numbers: 0001-0015

### Returns (2 Total)
- Return numbers: RET-001, RET-002
- Reason: "Customer changed mind about color"
- Inventory restored to stock

### Customer Tags
- **VIP** (system tag) - Pink color
- **Hostess** (custom tag) - Purple color

### Customer Notes & Timeline
- Business opportunity discussions
- Call logs with 📞 emoji
- Party hosting notes
- Conversion tracking notes

## Features to Explore

### Recruiting Pipeline
1. View customers with recruiting interest (Jane, Maria, Michelle)
2. See converted customers (Jennifer → Emily, Ashley → Rachel)
3. Check customer notes showing recruiting journey
4. Use "Convert to Consultant" button on interested customers

### Sales & Invoices
1. Browse 15 sales with different types and payment methods
2. Download PDF invoices with logo
3. View sale details with line items
4. Check shipping amounts on online orders

### Returns Management
1. View 2 processed returns in Returns page
2. See "Most Returned Products" on dashboard
3. Process new returns from sale detail pages

### Product Analytics
1. Click product names to view detail pages
2. See sales history per product
3. Check total sold, revenue, and profit stats
4. View current stock levels

### Customer Management
1. View customer detail pages with purchase history
2. Add notes and log calls
3. Track recruiting interest
4. See customer stats (total spent, orders, last purchase)

### Settings
1. Go to Profile → Business Settings
2. Configure sale number starting point (1, 100, 1000, etc.)
3. Sale numbers auto-expand beyond 4 digits

## Resetting Demo Data

To reset and reload all demo data:

```bash
php artisan migrate:fresh --seed && php artisan db:seed --class=TestDataSeeder
```

To clear only test data (keeps admin user):

```bash
php artisan test:clear
```

## What's Included

✅ Customer CRM with tags and notes  
✅ Product catalog with categories  
✅ Sales tracking (direct, party, online)  
✅ Invoice PDF generation with logo  
✅ Returns processing with inventory restore  
✅ Recruiting pipeline (customer → consultant)  
✅ Payment tracking (multiple methods)  
✅ Customer timeline and interaction logs  
✅ Product analytics and sales history  
✅ Dashboard with stats and insights  
✅ Floating Action Button (FAB) for quick actions  
✅ Dark mode support  
✅ Global search  

---

**All passwords:** password123
