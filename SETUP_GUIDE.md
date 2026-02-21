# Ashbrooke CRM - Development Setup Guide

## Prerequisites

Before you begin, ensure you have the following installed:

- **PHP 8.3+** with extensions:
  - OpenSSL
  - PDO
  - Mbstring
  - Tokenizer
  - XML
  - Ctype
  - JSON
  - BCMath
  - Fileinfo
  - GD (for image processing)

- **Composer** (latest version)
- **Node.js 18+** and NPM
- **MySQL 8.0+** or MariaDB 10.3+
- **Git**

### Optional but Recommended
- **Laravel Valet** (macOS) or **Laravel Herd** (macOS/Windows)
- **TablePlus** or **MySQL Workbench** (database GUI)
- **Postman** or **Insomnia** (API testing)

---

## Initial Setup

### 1. Clone the Repository

```bash
git clone https://github.com/yourusername/ashbrooke-crm.git
cd ashbrooke-crm
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node Dependencies

```bash
npm install
```

### 4. Environment Configuration

```bash
# Copy the example environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 5. Configure Database

Edit `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ashbrooke_crm
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Create the database:

```bash
# MySQL command line
mysql -u root -p
CREATE DATABASE ashbrooke_crm CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

### 6. Run Migrations

```bash
php artisan migrate
```

### 7. Seed Database (Optional)

```bash
# Seed with sample data for development
php artisan db:seed
```

### 8. Create Storage Symlink

```bash
php artisan storage:link
```

### 9. Compile Assets

```bash
# Development mode (with hot reload)
npm run dev

# Or for production build
npm run build
```

### 10. Start Development Server

```bash
php artisan serve
```

Visit: http://localhost:8000

---

## API Keys Setup

### Required for Full Functionality

#### Stripe (Payment Processing)

1. Create account at https://stripe.com
2. Get API keys from Dashboard → Developers → API keys
3. Add to `.env`:

```env
STRIPE_KEY=pk_test_your_publishable_key
STRIPE_SECRET=sk_test_your_secret_key
```

4. Set up webhook endpoint:
   - URL: `https://yourdomain.com/stripe/webhook`
   - Events: `customer.subscription.*`, `invoice.*`, `payment_intent.*`
   - Add webhook secret to `.env`:

```env
STRIPE_WEBHOOK_SECRET=whsec_your_webhook_secret
```

#### Twilio (SMS)

1. Create account at https://twilio.com
2. Get credentials from Console
3. Add to `.env`:

```env
TWILIO_SID=your_account_sid
TWILIO_AUTH_TOKEN=your_auth_token
TWILIO_PHONE_NUMBER=+1234567890
```

#### SendGrid (Email)

1. Create account at https://sendgrid.com
2. Create API key with full access
3. Add to `.env`:

```env
SENDGRID_API_KEY=your_api_key
SENDGRID_FROM_EMAIL=noreply@yourdomain.com
```

#### Groq (AI Analytics)

1. Create account at https://groq.com
2. Generate API key
3. Add to `.env`:

```env
GROQ_API_KEY=your_groq_api_key
GROQ_MODEL=mixtral-8x7b-32768
```

### Optional Integrations

#### Google Calendar

1. Go to https://console.cloud.google.com
2. Create project and enable Google Calendar API
3. Create OAuth 2.0 credentials
4. Add to `.env`:

```env
GOOGLE_CLIENT_ID=your_client_id
GOOGLE_CLIENT_SECRET=your_client_secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

#### Microsoft Outlook

1. Go to https://portal.azure.com
2. Register application
3. Add Microsoft Graph API permissions
4. Add to `.env`:

```env
MICROSOFT_CLIENT_ID=your_client_id
MICROSOFT_CLIENT_SECRET=your_client_secret
MICROSOFT_REDIRECT_URI=http://localhost:8000/auth/microsoft/callback
```

---

## Development Workflow

### Running the Application

```bash
# Terminal 1: Start Laravel server
php artisan serve

# Terminal 2: Watch and compile assets
npm run dev

# Terminal 3: Run queue worker (for background jobs)
php artisan queue:work

# Terminal 4: Run scheduler (for cron jobs)
php artisan schedule:work
```

### Common Artisan Commands

```bash
# Clear all caches
php artisan optimize:clear

# Run migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Fresh migration (WARNING: deletes all data)
php artisan migrate:fresh

# Fresh migration with seeding
php artisan migrate:fresh --seed

# Create new migration
php artisan make:migration create_table_name

# Create new model with migration
php artisan make:model ModelName -m

# Create Livewire component
php artisan make:livewire ComponentName

# List all routes
php artisan route:list

# Run tests
php artisan test
```

### Git Workflow

```bash
# Create feature branch
git checkout -b feature/your-feature-name

# Make changes and commit
git add .
git commit -m "Description of changes"

# Push to GitHub
git push origin feature/your-feature-name

# Create Pull Request on GitHub
# After review and approval, merge to main
```

---

## Project Structure

```
ashbrooke-crm/
├── app/
│   ├── Http/
│   │   ├── Controllers/      # HTTP controllers
│   │   ├── Livewire/         # Livewire components
│   │   └── Middleware/       # Custom middleware
│   ├── Models/               # Eloquent models
│   ├── Services/             # Business logic services
│   └── Helpers/              # Helper functions
├── bootstrap/
├── config/                   # Configuration files
├── database/
│   ├── migrations/           # Database migrations
│   ├── seeders/              # Database seeders
│   └── factories/            # Model factories
├── public/                   # Public assets
├── resources/
│   ├── views/                # Blade templates
│   ├── css/                  # CSS files
│   └── js/                   # JavaScript files
├── routes/
│   ├── web.php               # Web routes
│   ├── api.php               # API routes
│   └── console.php           # Console commands
├── storage/
│   ├── app/                  # Application files
│   ├── framework/            # Framework files
│   └── logs/                 # Log files
├── tests/                    # Test files
├── .env.example              # Environment template
├── composer.json             # PHP dependencies
├── package.json              # Node dependencies
└── README.md                 # Project documentation
```

---

## Coding Standards

### PHP (PSR-12)

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'sku',
        'price',
    ];

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
```

### Livewire Components

```php
<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ProductList extends Component
{
    public $products;
    public $search = '';

    public function mount()
    {
        $this->loadProducts();
    }

    public function loadProducts()
    {
        $this->products = Product::where('name', 'like', "%{$this->search}%")
            ->get();
    }

    public function render()
    {
        return view('livewire.product-list');
    }
}
```

### Blade Templates

```blade
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">
        {{ $title }}
    </h1>

    @foreach($products as $product)
        <div class="bg-white rounded-lg shadow p-4 mb-4">
            <h2>{{ $product->name }}</h2>
            <p>{{ $product->description }}</p>
        </div>
    @endforeach
</div>
```

### Tailwind CSS

```html
<!-- Use utility classes -->
<button class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded">
    Click Me
</button>

<!-- Custom components in tailwind.config.js -->
<button class="btn btn-primary">
    Click Me
</button>
```

---

## Testing

### Running Tests

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/ProductTest.php

# Run with coverage
php artisan test --coverage

# Run in parallel
php artisan test --parallel
```

### Writing Tests

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;

class ProductTest extends TestCase
{
    public function test_user_can_create_product()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post('/products', [
                'name' => 'Test Product',
                'sku' => 'TEST-001',
                'price' => 29.99,
            ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
        ]);
    }
}
```

---

## Debugging

### Laravel Debugbar

```bash
# Install Laravel Debugbar
composer require barryvdh/laravel-debugbar --dev
```

### Logging

```php
// Log messages
\Log::info('User logged in', ['user_id' => $user->id]);
\Log::error('Payment failed', ['error' => $exception->getMessage()]);

// View logs
tail -f storage/logs/laravel.log
```

### Tinker (Laravel REPL)

```bash
php artisan tinker

# Test code interactively
>>> $user = User::first();
>>> $user->products()->count();
>>> Product::where('price', '>', 50)->get();
```

---

## Database Management

### Migrations

```bash
# Create migration
php artisan make:migration create_products_table

# Run migrations
php artisan migrate

# Rollback
php artisan migrate:rollback

# Reset and re-run all migrations
php artisan migrate:fresh
```

### Seeders

```bash
# Create seeder
php artisan make:seeder ProductSeeder

# Run specific seeder
php artisan db:seed --class=ProductSeeder

# Run all seeders
php artisan db:seed
```

### Factories

```php
// database/factories/ProductFactory.php
public function definition()
{
    return [
        'name' => $this->faker->words(3, true),
        'sku' => $this->faker->unique()->bothify('??-####'),
        'price' => $this->faker->randomFloat(2, 10, 100),
    ];
}

// Usage
Product::factory()->count(50)->create();
```

---

## Performance Optimization

### Caching

```php
// Cache data
Cache::put('products', $products, now()->addHours(1));

// Retrieve cached data
$products = Cache::remember('products', 3600, function () {
    return Product::all();
});

// Clear cache
Cache::forget('products');
php artisan cache:clear
```

### Query Optimization

```php
// Eager loading (prevents N+1 queries)
$products = Product::with('variants', 'category')->get();

// Chunking large datasets
Product::chunk(100, function ($products) {
    foreach ($products as $product) {
        // Process product
    }
});
```

---

## Troubleshooting

### Common Issues

#### "Class not found" error
```bash
composer dump-autoload
```

#### Assets not loading
```bash
npm run build
php artisan optimize:clear
```

#### Permission errors
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

#### Database connection failed
- Check `.env` database credentials
- Ensure MySQL is running
- Verify database exists

#### Queue jobs not processing
```bash
php artisan queue:restart
php artisan queue:work
```

---

## Deployment Checklist

### Pre-Deployment

- [ ] All tests passing
- [ ] Code reviewed and approved
- [ ] Environment variables configured
- [ ] Database migrations ready
- [ ] Assets compiled for production
- [ ] API keys configured
- [ ] SSL certificate installed

### Deployment Steps

```bash
# On server
git pull origin main
composer install --optimize-autoloader --no-dev
npm install
npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### Post-Deployment

- [ ] Verify application loads
- [ ] Test critical features
- [ ] Check error logs
- [ ] Monitor performance
- [ ] Verify cron jobs running
- [ ] Test payment processing
- [ ] Test email/SMS sending

---

## Resources

### Documentation
- [Laravel Documentation](https://laravel.com/docs)
- [Livewire Documentation](https://livewire.laravel.com/docs)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [Stripe API Documentation](https://stripe.com/docs/api)

### Community
- [Laravel Discord](https://discord.gg/laravel)
- [Laracasts](https://laracasts.com)
- [Laravel News](https://laravel-news.com)

### Tools
- [Laravel Shift](https://laravelshift.com) - Automated upgrades
- [Laravel Forge](https://forge.laravel.com) - Server management
- [Laravel Vapor](https://vapor.laravel.com) - Serverless deployment

---

## Getting Help

### Project Documentation
- Review PROJECT_PLAN.md for requirements
- Check QUICK_REFERENCE.md for decisions
- See DATABASE_SCHEMA.md for data structure
- Track progress in PROGRESS.md

### Support Channels
- GitHub Issues: Report bugs and request features
- Email: [your-email]
- Documentation: Review all .md files in project root

---

**Setup Guide Version:** 1.0  
**Last Updated:** 2024  
**Status:** Ready for Development
