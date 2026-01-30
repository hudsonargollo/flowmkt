# FlowMkt Deployment - Quick Start Guide

Get your automated deployment up and running in 5 minutes!

## 🚀 Quick Setup

### Option 1: Automated Setup (Recommended)

Run the setup script and follow the prompts:

```bash
./setup-deployment.sh
```

The script will:
- Generate SSH keys
- Guide you through cPanel configuration
- Test the connection
- Set up Git on the server
- Provide GitHub secrets for you to copy

### Option 2: Manual Setup

#### 1. Generate SSH Key

```bash
ssh-keygen -t rsa -b 4096 -C "your_email@example.com" -f ~/.ssh/flowmkt_deploy
```

#### 2. Add Public Key to cPanel

```bash
# Display your public key
cat ~/.ssh/flowmkt_deploy.pub

# Copy the output and add it to cPanel:
# cPanel → Security → SSH Access → Manage SSH Keys → Import Key
```

#### 3. Test Connection

```bash
ssh -i ~/.ssh/flowmkt_deploy your_username@flow.clubemkt.digital
```

#### 4. Configure GitHub Secrets

Go to your GitHub repository → Settings → Secrets → Add these:

- `CPANEL_HOST`: `flow.clubemkt.digital`
- `CPANEL_USERNAME`: Your cPanel username
- `CPANEL_SSH_KEY`: Contents of `~/.ssh/flowmkt_deploy` (entire file)
- `CPANEL_SSH_PORT`: `22`
- `CPANEL_APP_PATH`: `public_html`

#### 5. Push to Deploy

```bash
git add .
git commit -m "Enable automated deployment"
git push origin main
```

## 📦 Deployment Methods

### Method 1: Automatic (GitHub Actions)

Every push to `main` branch automatically deploys:

```bash
git push origin main
```

Watch the deployment: GitHub → Actions tab

### Method 2: Manual Script

Deploy from your local machine:

```bash
# Set your username
export CPANEL_USER="your_username"

# Deploy
./deploy.sh
```

### Method 3: Direct SSH

SSH into the server and pull manually:

```bash
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital
cd ~/public_html
git pull origin main
cd core
composer install --no-dev --optimize-autoloader
npm ci && npm run build
php artisan config:cache
```

## 🔧 Common Commands

```bash
# Deploy manually
./deploy.sh

# Test SSH connection
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital

# Clear caches on server
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital \
  "cd public_html/core && php artisan cache:clear"

# View server logs
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital \
  "tail -f public_html/core/storage/logs/laravel.log"
```

## 🐛 Troubleshooting

### "Permission denied (publickey)"

```bash
# Add key to SSH agent
ssh-add ~/.ssh/flowmkt_deploy

# Test with verbose output
ssh -v -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital
```

### "Git pull failed"

```bash
# SSH into server and configure Git
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital
cd ~/public_html
git config credential.helper store
git pull  # Enter credentials when prompted
```

### GitHub Actions fails

1. Check all secrets are set correctly
2. Verify private key is complete (including header/footer)
3. Ensure key has no passphrase

## 📚 Full Documentation

For detailed information, see [DEPLOYMENT_GUIDE.md](DEPLOYMENT_GUIDE.md)

## ✅ Checklist

- [ ] SSH key generated
- [ ] Public key added to cPanel
- [ ] SSH connection tested
- [ ] Git configured on server
- [ ] GitHub secrets added
- [ ] Test deployment successful
- [ ] Automatic deployment working

## 🎯 Next Steps

1. Set up staging environment (optional)
2. Configure deployment notifications
3. Set up automated backups
4. Monitor deployment logs

---

**Need Help?** Check the full [DEPLOYMENT_GUIDE.md](DEPLOYMENT_GUIDE.md) or contact support.
