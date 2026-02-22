# Ashbrooke CRM Landing Page

Standalone static landing page for Ashbrooke CRM.

## Structure

```
landing/
├── images/
│   └── ashbrookeLogo.png    # Place your logo here
├── css/
│   └── style.css
└── index.html
```

## Setup

1. Place your logo: `ashbrookeLogo.png` in the `images/` folder
2. Update the login link in `index.html` to point to your CRM login URL

## Deployment Options

### Option 1: Separate Domain/Subdomain
- Deploy to `ashbrookecrm.com` (landing)
- CRM at `app.ashbrookecrm.com`

### Option 2: Apache/Nginx
Configure your web server to serve this directory at the root.

### Option 3: Static Hosting
Upload to Netlify, Vercel, or any static host.

## Customization

- **Colors**: Edit `css/style.css` (currently purple gradient: #667eea to #764ba2)
- **Content**: Edit `index.html`
- **Login URL**: Update `/login` links to your CRM URL
