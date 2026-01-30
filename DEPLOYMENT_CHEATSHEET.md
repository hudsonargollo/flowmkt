# FlowMkt Deployment Cheat Sheet

Quick reference for common deployment tasks.

## 🚀 Quick Commands

### Setup & Configuration

```bash
# Initial setup (run once)
./setup-deployment.sh

# Check deployment status
./check-deployment.sh

# Test SSH connection
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital
```

### Deployment

```bash
# Automatic deployment (push to GitHub)
git push origin main

# Manual deployment
./deploy.sh

# Deploy with custom settings
CPANEL_USER=myuser CPANEL_HOST=myhost.com ./deploy.sh
```

### Server Management

```bash
# SSH into server
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital

# View Laravel logs
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital \
  "tail -f public_html/core/storage/logs/laravel.log"

# Clear caches on server
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital \
  "cd public_html/core && php artisan cache:clear && php artisan config:clear"

# Check disk space
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital "df -h"
```

## 📁 File Locations

### Local Machine

```
~/.ssh/flowmkt_deploy          # Private SSH key
~/.ssh/flowmkt_deploy.pub      # Public SSH key
.env.deploy                     # Deployment configuration
```

### cPanel Server

```
~/public_html/                  # Application root
~/public_html/core/             # Laravel application
~/public_html/core/.env         # Environment configuration
~/public_html/core/storage/logs/# Application logs
~/.ssh/authorized_keys          # SSH public keys
```

### GitHub

```
.github/workflows/deploy-to-cpanel.yml   # Production workflow
.github/workflows/deploy-to-staging.yml  # Staging workflow
Settings → Secrets → Actions             # Deployment secrets
```

## 🔑 GitHub Secrets

Required secrets for GitHub Actions:

| Secret Name | Example Value |
|-------------|---------------|
| `CPANEL_HOST` | `flow.clubemkt.digital` |
| `CPANEL_USERNAME` | `your_username` |
| `CPANEL_SSH_KEY` | `-----BEGIN OPENSSH PRIVATE KEY-----...` |
| `CPANEL_SSH_PORT` | `22` |
| `CPANEL_APP_PATH` | `public_html` |

## 🔧 Troubleshooting

### SSH Issues

```bash
# Permission denied
ssh-add ~/.ssh/flowmkt_deploy

# Test with verbose output
ssh -v -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital

# Check key permissions
chmod 600 ~/.ssh/flowmkt_deploy
```

### Git Issues

```bash
# On server: configure Git credentials
cd ~/public_html
git config credential.helper store
git pull  # Enter credentials when prompted

# Reset to specific commit
git reset --hard <commit-hash>
```

### Laravel Issues

```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Rebuild caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Fix permissions
chmod -R 755 storage bootstrap/cache
```

### Deployment Fails

```bash
# Check GitHub Actions logs
# Go to: GitHub → Actions → Latest workflow

# Check server logs
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital \
  "tail -100 public_html/core/storage/logs/laravel.log"

# Manual deployment
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital
cd ~/public_html
git pull origin main
cd core
composer install --no-dev --optimize-autoloader
npm ci && npm run build
php artisan config:cache
```

## 🔄 Rollback

### Quick Rollback

```bash
# SSH into server
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital

# Rollback to previous commit
cd ~/public_html
git log --oneline -10  # Find commit hash
git reset --hard <previous-commit-hash>
cd core
composer install --no-dev --optimize-autoloader
npm ci && npm run build
php artisan cache:clear
```

### GitHub Rollback

```bash
# Revert commit locally
git revert <bad-commit-hash>
git push origin main
# Automatic deployment will trigger
```

## 📊 Monitoring

### Check Deployment Status

```bash
# GitHub Actions
# Go to: https://github.com/yourusername/your-repo/actions

# Server status
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital \
  "cd public_html/core && php artisan --version"

# Check if site is up
curl -I https://flow.clubemkt.digital
```

### View Logs

```bash
# Laravel logs (last 50 lines)
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital \
  "tail -50 public_html/core/storage/logs/laravel.log"

# Follow logs in real-time
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital \
  "tail -f public_html/core/storage/logs/laravel.log"

# Search for errors
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital \
  "grep ERROR public_html/core/storage/logs/laravel.log | tail -20"
```

## 🎯 Common Tasks

### Update Dependencies

```bash
# SSH into server
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital
cd ~/public_html/core

# Update Composer
composer update --no-dev --optimize-autoloader

# Update NPM
npm update
npm run build
```

### Database Operations

```bash
# Run migrations
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital \
  "cd public_html/core && php artisan migrate --force"

# Rollback migrations
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital \
  "cd public_html/core && php artisan migrate:rollback --force"

# Seed database
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital \
  "cd public_html/core && php artisan db:seed --force"
```

### Maintenance Mode

```bash
# Enable maintenance mode
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital \
  "cd public_html/core && php artisan down"

# Disable maintenance mode
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital \
  "cd public_html/core && php artisan up"

# Maintenance mode with secret
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital \
  "cd public_html/core && php artisan down --secret=my-secret-token"
# Access: https://flow.clubemkt.digital/my-secret-token
```

## 🔐 Security

### Rotate SSH Keys

```bash
# Generate new key
ssh-keygen -t rsa -b 4096 -C "your_email@example.com" -f ~/.ssh/flowmkt_deploy_new

# Add new key to cPanel
cat ~/.ssh/flowmkt_deploy_new.pub
# Add to cPanel → SSH Access → Manage SSH Keys

# Update GitHub secrets with new private key
cat ~/.ssh/flowmkt_deploy_new

# Test new key
ssh -i ~/.ssh/flowmkt_deploy_new username@flow.clubemkt.digital

# Remove old key from cPanel
# Update .env.deploy with new key path
```

### Check Permissions

```bash
# Check file permissions
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital \
  "ls -la public_html/core/storage"

# Fix permissions
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital \
  "cd public_html/core && chmod -R 755 storage bootstrap/cache"
```

## 📈 Performance

### Optimize Application

```bash
# SSH into server
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital
cd ~/public_html/core

# Optimize autoloader
composer dump-autoload --optimize

# Cache everything
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Clear old logs
php artisan log:clear
```

### Check Performance

```bash
# Check response time
time curl -I https://flow.clubemkt.digital

# Check server load
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital "uptime"

# Check memory usage
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital "free -h"
```

## 🆘 Emergency Commands

### Site Down

```bash
# Quick check
curl -I https://flow.clubemkt.digital

# Check if server is up
ping flow.clubemkt.digital

# SSH and check services
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital
cd ~/public_html/core
php artisan --version  # Check if PHP works
```

### Restore from Backup

```bash
# SSH into server
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital
cd ~/public_html

# Restore from Git
git fetch --all
git reset --hard origin/main

# Restore dependencies
cd core
composer install --no-dev --optimize-autoloader
npm ci && npm run build
php artisan cache:clear
```

## 📞 Quick Links

- **Application:** https://flow.clubemkt.digital
- **GitHub Actions:** https://github.com/yourusername/your-repo/actions
- **cPanel:** https://flow.clubemkt.digital:2083
- **Documentation:** `DEPLOYMENT_GUIDE.md`

## 💡 Tips

- Always test on staging first
- Keep backups before major changes
- Monitor logs after deployment
- Clear browser cache if changes don't appear
- Use maintenance mode for database migrations

---

**Print this page for quick reference!**
