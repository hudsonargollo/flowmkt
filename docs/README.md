# FlowMkt Documentation

Complete documentation for FlowMkt platform setup, deployment, and troubleshooting.

## 📚 Documentation Index

### 🚀 Deployment

Get your application deployed to production with automated CI/CD.

- **[Deployment Guide](deployment/DEPLOYMENT_GUIDE.md)** - Complete deployment documentation (15+ pages)
- **[Quick Start](deployment/DEPLOYMENT_QUICKSTART.md)** - Get deployed in 5 minutes
- **[Deployment Summary](deployment/DEPLOYMENT_SUMMARY.md)** - Overview of deployment system
- **[Cheat Sheet](deployment/DEPLOYMENT_CHEATSHEET.md)** - Quick command reference
- **[README](deployment/README_DEPLOYMENT.md)** - Deployment system overview

#### Platform-Specific Guides
- **[GitHub Secrets Setup](deployment/GITHUB_SECRETS_SETUP.md)** - Configure GitHub Actions
- **[TurboCloud SSH Setup](deployment/TURBOCLOUD_SSH_SETUP.md)** - Brazilian hosting setup
- **[Create GitHub Repository](deployment/CREATE_GITHUB_REPO.md)** - Repository setup guide

### ⚙️ Setup & Configuration

Initial setup and configuration guides.

- **[Server Setup Guide](setup/SERVER_SETUP_GUIDE.md)** - Complete server configuration
- **[Asset Replacement Requirements](setup/ASSET_REPLACEMENT_REQUIREMENTS.md)** - Logo and branding files
- **[Brand Assets Summary](setup/BRAND_ASSETS_REPLACEMENT_SUMMARY.md)** - Asset replacement status
- **[Brand Colors Update](setup/BRAND_COLORS_UPDATE_SUMMARY.md)** - Color scheme customization
- **[Testing Summary](setup/COMPREHENSIVE_TESTING_SUMMARY.md)** - Test suite overview
- **[Final Checkpoint](setup/FINAL_CHECKPOINT_STATUS.md)** - Deployment readiness check
- **[Manual Verification](setup/MANUAL_VERIFICATION_CHECKLIST.md)** - QA checklist
- **[Task Completion](setup/TASK_15_COMPLETION_SUMMARY.md)** - Implementation status
- **[Production Environment](setup/production.env)** - Sample .env file for production

### 🔧 Troubleshooting

Solutions for common problems and errors.

- **[Fix 500 Error](troubleshooting/FIX_500_ERROR.md)** - Resolve server errors
- **[Quick Fix Steps](troubleshooting/QUICK_FIX_STEPS.md)** - Emergency fixes (3 steps)

## 🎯 Quick Links

### For Developers
- [Local Development Setup](../README.md#local-development)
- [Testing Guide](../core/tests/TEST_EXECUTION_GUIDE.md)
- [Property-Based Tests](../core/tests/Property/README.md)

### For DevOps
- [Deployment Scripts](../scripts/deployment/)
- [Diagnostic Tools](../scripts/diagnostics/)
- [GitHub Actions Workflows](../.github/workflows/)

### For System Admins
- [Server Requirements](setup/SERVER_SETUP_GUIDE.md#server-requirements)
- [File Permissions](troubleshooting/FIX_500_ERROR.md#step-4-check-file-permissions)
- [Cache Management](../core/scripts/clear_all_caches.sh)

## 📖 Documentation by Task

### I want to...

#### Deploy the Application
1. Read: [Deployment Quick Start](deployment/DEPLOYMENT_QUICKSTART.md)
2. Setup: [GitHub Secrets](deployment/GITHUB_SECRETS_SETUP.md)
3. Deploy: Push to `main` branch or run `./scripts/deployment/deploy.sh`

#### Fix a 500 Error
1. Read: [Fix 500 Error Guide](troubleshooting/FIX_500_ERROR.md)
2. Run: `scripts/diagnostics/diagnose.php` on server
3. Follow: [Quick Fix Steps](troubleshooting/QUICK_FIX_STEPS.md)

#### Setup a New Server
1. Read: [Server Setup Guide](setup/SERVER_SETUP_GUIDE.md)
2. Upload: [production.env](setup/production.env) as `.env`
3. Run: `composer install` and Laravel setup commands

#### Replace Brand Assets
1. Read: [Asset Requirements](setup/ASSET_REPLACEMENT_REQUIREMENTS.md)
2. Prepare: Logo files (200x60px PNG)
3. Upload: To `assets/images/logo_icon/`

#### Configure Deployment
1. Read: [Deployment Guide](deployment/DEPLOYMENT_GUIDE.md)
2. Setup: SSH keys and GitHub secrets
3. Test: Run `./scripts/deployment/check-deployment.sh`

## 🛠️ Tools & Scripts

### Deployment Tools
- `scripts/deployment/deploy.sh` - Manual deployment script
- `scripts/deployment/setup-deployment.sh` - Interactive setup wizard
- `scripts/deployment/check-deployment.sh` - Verify deployment config

### Diagnostic Tools
- `scripts/diagnostics/diagnose.php` - Server health check
- `scripts/diagnostics/find-ssh-port.sh` - Find SSH port

### Maintenance Scripts
- `core/scripts/clear_all_caches.sh` - Clear all Laravel caches
- `core/scripts/verify_translations.php` - Check translation completeness
- `core/scripts/run_comprehensive_tests.sh` - Run full test suite

## 📞 Getting Help

### Documentation Not Clear?
- Check the [main README](../README.md)
- Review [troubleshooting guides](troubleshooting/)
- Check [GitHub Issues](https://github.com/hudsonargollo/flowmkt/issues)

### Found a Bug?
1. Check [troubleshooting docs](troubleshooting/)
2. Run diagnostic script
3. Open GitHub Issue with details

### Need Support?
- Email: contato@clubemkt.digital
- Documentation: This folder
- Repository: https://github.com/hudsonargollo/flowmkt

## 🔄 Keeping Documentation Updated

When adding new features:
1. Update relevant documentation
2. Add entry to this index
3. Update main README.md if needed
4. Keep examples current

## 📝 Documentation Standards

- Use clear, concise language
- Include code examples
- Provide step-by-step instructions
- Add troubleshooting sections
- Keep formatting consistent

---

**Last Updated:** January 30, 2026  
**Version:** 1.0.0  
**Maintainer:** ClubeMKT Team
