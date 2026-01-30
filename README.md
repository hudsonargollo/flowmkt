# FlowMkt - Marketing Automation Platform

FlowMkt is a comprehensive marketing automation platform with WhatsApp integration, built with Laravel, React, and modern web technologies. Fully localized for Brazilian Portuguese.

## 🌟 Features

- ✅ **WhatsApp Integration** - Automated messaging and flow builder
- ✅ **Visual Flow Builder** - React-based drag-and-drop interface
- ✅ **Multi-language Support** - Brazilian Portuguese (pt-BR) primary
- ✅ **User Management** - Complete authentication and authorization
- ✅ **Template System** - Customizable message templates
- ✅ **Analytics Dashboard** - Real-time metrics and reporting
- ✅ **Automated Deployment** - GitHub Actions CI/CD pipeline

## 🚀 Quick Start

### Prerequisites

- PHP 8.1+
- Composer
- Node.js 18+
- MySQL 5.7+
- Git

### Local Development

```bash
# Clone repository
git clone https://github.com/hudsonargollo/flowmkt.git
cd flowmkt

# Install PHP dependencies
cd core
composer install

# Install Node dependencies
npm install

# Configure environment
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate

# Build assets
npm run build

# Start development server
php artisan serve
```

Visit: http://localhost:8000

## 📦 Deployment

### Automated Deployment (GitHub Actions)

Every push to `main` branch automatically deploys to production.

**Setup:**
1. Add GitHub secrets (see [docs/deployment/GITHUB_SECRETS_SETUP.md](docs/deployment/GITHUB_SECRETS_SETUP.md))
2. Push to main branch
3. GitHub Actions handles the rest!

### Manual Deployment

```bash
# Run deployment script
./scripts/deployment/deploy.sh
```

See [docs/deployment/DEPLOYMENT_GUIDE.md](docs/deployment/DEPLOYMENT_GUIDE.md) for detailed instructions.

## 📚 Documentation

### Deployment
- [Deployment Guide](docs/deployment/DEPLOYMENT_GUIDE.md) - Complete deployment documentation
- [Quick Start](docs/deployment/DEPLOYMENT_QUICKSTART.md) - 5-minute setup guide
- [Cheat Sheet](docs/deployment/DEPLOYMENT_CHEATSHEET.md) - Command reference
- [GitHub Secrets Setup](docs/deployment/GITHUB_SECRETS_SETUP.md) - Configure automated deployment
- [TurboCloud Setup](docs/deployment/TURBOCLOUD_SSH_SETUP.md) - Hosting-specific guide

### Setup & Configuration
- [Server Setup Guide](docs/setup/SERVER_SETUP_GUIDE.md) - Initial server configuration
- [Asset Replacement](docs/setup/ASSET_REPLACEMENT_REQUIREMENTS.md) - Logo and branding
- [Brand Colors](docs/setup/BRAND_COLORS_UPDATE_SUMMARY.md) - Color customization

### Troubleshooting
- [Fix 500 Error](docs/troubleshooting/FIX_500_ERROR.md) - Common server errors
- [Quick Fix Steps](docs/troubleshooting/QUICK_FIX_STEPS.md) - Emergency fixes

### Architecture
- [Deployment Architecture](.github/DEPLOYMENT_ARCHITECTURE.md) - System diagrams
- [Spec Documentation](.kiro/specs/flowmlkt-rebranding-localization/) - Requirements & design

## 🛠️ Tech Stack

- **Backend:** Laravel 11, PHP 8.4
- **Frontend:** React 18, Vite
- **Database:** MySQL
- **Styling:** Bootstrap 5, Custom CSS
- **Deployment:** GitHub Actions, SSH
- **Hosting:** TurboCloud (cPanel)

## 📁 Project Structure

```
flowmkt/
├── core/                          # Laravel application
│   ├── app/                       # Application code
│   ├── resources/                 # Views, JS, CSS
│   │   ├── js/flow_builder/      # React Flow Builder
│   │   ├── lang/pt/              # Portuguese translations
│   │   └── views/                # Blade templates
│   ├── tests/                     # Test suite
│   └── scripts/                   # Utility scripts
├── assets/                        # Public assets
│   ├── admin/                     # Admin panel assets
│   ├── global/                    # Shared assets
│   └── templates/                 # Theme templates
├── docs/                          # Documentation
│   ├── deployment/               # Deployment guides
│   ├── setup/                    # Setup instructions
│   └── troubleshooting/          # Problem solving
├── scripts/                       # Helper scripts
│   ├── deployment/               # Deployment automation
│   └── diagnostics/              # Diagnostic tools
└── .github/                       # GitHub Actions workflows

```

## 🔧 Scripts

### Deployment Scripts
- `scripts/deployment/deploy.sh` - Manual deployment
- `scripts/deployment/setup-deployment.sh` - Initial setup wizard
- `scripts/deployment/check-deployment.sh` - Verify configuration

### Diagnostic Scripts
- `scripts/diagnostics/diagnose.php` - Server diagnostics
- `scripts/diagnostics/find-ssh-port.sh` - SSH port finder

### Core Scripts
- `core/scripts/clear_all_caches.sh` - Clear Laravel caches
- `core/scripts/verify_translations.php` - Check translations
- `core/scripts/run_comprehensive_tests.sh` - Run test suite

## 🧪 Testing

```bash
cd core

# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature

# Run with coverage
php artisan test --coverage
```

## 🌍 Localization

FlowMkt is fully localized for Brazilian Portuguese:

- ✅ All UI elements translated
- ✅ Laravel framework messages
- ✅ React Flow Builder interface
- ✅ JavaScript notifications
- ✅ Email templates
- ✅ Error messages

Translation files: `core/resources/lang/pt/`

## 🔐 Security

- Environment variables in `.env` (never committed)
- SSH key authentication for deployment
- GitHub secrets for CI/CD
- HTTPS enforced in production
- CSRF protection enabled
- SQL injection prevention

## 📊 Performance

- Optimized autoloader
- Route caching
- View caching
- Config caching
- Asset minification
- CDN support (Cloudflare)

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 License

This project is proprietary software. All rights reserved.

## 🆘 Support

- **Documentation:** See `docs/` directory
- **Issues:** GitHub Issues
- **Email:** contato@clubemkt.digital

## 🎯 Roadmap

- [ ] Multi-language support (English, Spanish)
- [ ] Advanced analytics dashboard
- [ ] API documentation
- [ ] Mobile app integration
- [ ] Webhook system
- [ ] Plugin architecture

## 📈 Status

- **Version:** 1.0.0
- **Status:** Production
- **Environment:** https://flow.clubemkt.digital
- **Last Updated:** January 30, 2026

---

**Made with ❤️ by ClubeMKT**
