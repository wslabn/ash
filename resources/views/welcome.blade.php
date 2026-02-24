<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ashbrooke CRM - Inventory & CRM for Mary Kay Consultants</title>
    <meta name="description" content="Professional inventory and CRM system designed specifically for Mary Kay consultants. Manage customers, track sales, and grow your business.">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
        }

        .hero-content {
            max-width: 800px;
        }

        .logo {
            max-width: 200px;
            margin-bottom: 2rem;
            border-radius: 50%;
        }

        h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .tagline {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            opacity: 0.95;
        }

        .cta-button {
            display: inline-block;
            background: white;
            color: #667eea;
            padding: 1rem 3rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: transform 0.2s, box-shadow 0.2s;
            margin-top: 1rem;
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .features {
            padding: 4rem 2rem;
            background: #f8f9fa;
        }

        .features-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .features h2 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 3rem;
            color: #333;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .feature-card h3 {
            color: #667eea;
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }

        .feature-card p {
            color: #666;
        }

        .pricing {
            padding: 4rem 2rem;
            text-align: center;
            background: white;
        }

        .pricing h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #333;
        }

        .price {
            font-size: 3rem;
            color: #667eea;
            font-weight: 700;
            margin: 1rem 0;
        }

        .price span {
            font-size: 1.5rem;
            color: #666;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }
            
            .tagline {
                font-size: 1.2rem;
            }
            
            .features h2, .pricing h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <img src="{{ asset('images/ashbrookeLogo.png') }}" alt="Ashbrooke CRM" class="logo">
            <h1>Grow Your Mary Kay Business</h1>
            <p class="tagline">Professional inventory and CRM system built for consultants who mean business</p>
            <a href="{{ route('login') }}" class="cta-button">Login to Your Account</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="features-container">
            <h2>Why Ashbrooke CRM?</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <h3>📊 Complete Customer Management</h3>
                    <p>Track every customer interaction, purchase history, and preferences. Build stronger relationships with detailed CRM tools designed for direct sales.</p>
                </div>

                <div class="feature-card">
                    <h3>📦 Smart Inventory Control</h3>
                    <p>Never run out of your best sellers. Real-time inventory tracking, low stock alerts, and automatic adjustments keep you always ready to sell.</p>
                </div>

                <div class="feature-card">
                    <h3>💰 Sales & Commission Tracking</h3>
                    <p>Record retail, party, and online sales instantly. Track payments, generate professional invoices, and monitor your earnings in real-time.</p>
                </div>

                <div class="feature-card">
                    <h3>🎉 Party Management</h3>
                    <p>Plan and track your parties with ease. Manage guest lists, record sales, and follow up with attendees to maximize every event.</p>
                </div>

                <div class="feature-card">
                    <h3>👥 Team & Recruiting Tools</h3>
                    <p>Build your team with built-in recruiting pipeline. Track prospects, manage your downline, and grow your Mary Kay business.</p>
                </div>

                <div class="feature-card">
                    <h3>📱 Access Anywhere</h3>
                    <p>Cloud-based system accessible from any device. Manage your business at home, at parties, or on the go.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="pricing">
        <h2>Simple, Affordable Pricing</h2>
        <div class="price">$9.99<span>/month</span></div>
        <p style="color: #666; font-size: 1.1rem; margin-bottom: 2rem;">Everything you need to run your Mary Kay business professionally</p>
        <a href="{{ route('login') }}" class="cta-button">Get Started Today</a>
    </section>
</body>
</html>
