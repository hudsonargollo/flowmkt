# FlowMkt Deployment Guide

This guide explains how to set up automated deployment to cPanel using SSH keys and GitHub Actions.

## Table of Contents

1. [Prerequisites](#prerequisites)
2. [SSH Key Setup](#ssh-key-setup)
3. [cPanel Configuration](#cpanel-configuration)
4. [GitHub Actions Setup](#github-actions-setup)
5. [Manual Deployment](#manual-deployment)
6. [Troubleshooting](#troubleshooting)

---

## Prerequisites

- SSH access to your cPanel server
- Git installed on your cPanel server
- Composer installed on your cPanel server
- Node.js and NPM installed on your cPanel server
- GitHub repository with your code

---

## SSH Key Setup

### 1. Generate SSH Key (if you don't have one)

On your local machine:

```bash
ssh-keygen -t rsa -b 4096 -C "your_email@example.com" -f ~/.ssh/flowmkt_deploy
```

This creates two files:
- `~/.ssh/flowmkt_deploy` (private key - keep this secret!)
- `~/.ssh/flowmkt_deploy.pub` (public key - this goes on the server)

### 2. Add Public Key to cPanel

**Option A: Via cPanel Interface**

1. Log in to cPanel
2. Go to **Security** → **SSH Access**
3. Click **Manage SSH Keys**
4. Click **Import Key**
5. Paste the contents of `~/.ssh/flowmkt_deploy.pub`
6. Click **Import**
7. Click **Manage** next to the imported key
8. Click **Authorize** to add it to `authorized_keys`

**Option B: Via Command Line**

```bash
# Copy your public key to the server
ssh-copy-id -i ~/.ssh/flowmkt_deploy.pub username@flow.clubemkt.digital

# Or manually:
cat ~/.ssh/flowmkt_deploy.pub | ssh username@flow.clubemkt.digital "mkdir -p ~/.ssh && cat >> ~/.ssh/authorized_keys"
```

### 3. Test SSH Connection

```bash
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital
```

If successful, you should be logged into your cPanel server without a password prompt.

---

## cPanel Configuration

### 1. Initialize Git Repository

SSH into your cPanel server and run:

```bash
cd ~/public_html  # or your application directory
git init
git remote add origin https://github.com/yourusername/your-repo.git
git fetch
git checkout main
```

### 2. Set Up Git Credentials (for pulling)

**Option A: Personal Access Token (Recommended)**

```bash
# Create a Personal Access Token on GitHub:
# GitHub → Settings → Developer settings → Personal access tokens → Generate new token
# Give it 'repo' permissions

# Configure Git to use the token
git config --global credential.helper store
git pull  # Enter username and token when prompted
```

**Option B: Deploy Key**

1. Generate a deploy key on the server:
```bash
ssh-keygen -t rsa -b 4096 -C "deploy@flow.clubemkt.digital" -f ~/.ssh/github_deploy
```

2. Add the public key to GitHub:
   - Go to your repository → Settings → Deploy keys
   - Click "Add deploy key"
   - Paste contents of `~/.ssh/github_deploy.pub`
   - Check "Allow write access" if needed

3. Configure SSH to use the deploy key:
```bash
cat >> ~/.ssh/config << EOF
Host github.com
    HostName github.com
    User git
    IdentityFile ~/.ssh/github_deploy
EOF
```

### 3. Verify Required Tools

```bash
# Check PHP version
php -v

# Check Composer
composer --version

# Check Node.js
node -v

# Check NPM
npm -v

# Check Git
git --version
```

If any are missing, install them via cPanel or contact your hosting provider.

---

## GitHub Actions Setup

### 1. Add Secrets to GitHub Repository

Go to your GitHub repository → Settings → Secrets and variables → Actions → New repository secret

Add the following secrets:

| Secret Name | Value | Description |
|-------------|-------|-------------|
| `CPANEL_HOST` | `flow.clubemkt.digital` | Your cPanel server hostname |
| `CPANEL_USERNAME` | `your_cpanel_username` | Your cPanel SSH username |
| `CPANEL_SSH_KEY` | Contents of `~/.ssh/flowmkt_deploy` | Your private SSH key (entire file) |
| `CPANEL_SSH_PORT` | `22` | SSH port (usually 22) |
| `CPANEL_APP_PATH` | `public_html` | Path to your application on cPanel |

**To get your private key contents:**

```bash
cat ~/.ssh/flowmkt_deploy
```

Copy the entire output including `-----BEGIN OPENSSH PRIVATE KEY-----` and `-----END OPENSSH PRIVATE KEY-----`

### 2. Enable GitHub Actions

The workflow file `.github/workflows/deploy-to-cpanel.yml` is already created. It will automatically:

- Trigger on push to `main` or `production` branches
- Install dependencies
- Build assets
- Deploy to cPanel via SSH

### 3. Test the Workflow

1. Make a small change to your code
2. Commit and push to the `main` branch:
```bash
git add .
git commit -m "Test deployment"
git push origin main
```

3. Go to GitHub → Actions tab to see the deployment progress

---

## Manual Deployment

### Using the Deployment Script

The `deploy.sh` script allows you to deploy manually from your local machine:

```bash
# Set environment variables
export CPANEL_USER="your_cpanel_username"
export CPANEL_HOST="flow.clubemkt.digital"
export SSH_KEY="~/.ssh/flowmkt_deploy"

# Run deployment
./deploy.sh
```

**Or in one command:**

```bash
CPANEL_USER=your_username SSH_KEY=~/.ssh/flowmkt_deploy ./deploy.sh
```

### Direct SSH Deployment

You can also SSH into the server and deploy manually:

```bash
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital

# Once connected:
cd ~/public_html
git pull origin main
cd core
composer install --no-dev --optimize-autoloader
npm ci
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
chmod -R 755 storage bootstrap/cache
```

---

## Deployment Workflow

### Automatic Deployment (GitHub Actions)

```
┌─────────────────────────────────────────────────────────┐
│  Developer pushes code to GitHub                        │
└─────────────────────────────────────────────────────────┘
                          │
                          ▼
┌─────────────────────────────────────────────────────────┐
│  GitHub Actions workflow triggers                       │
│  - Checkout code                                        │
│  - Install dependencies                                 │
│  - Build assets                                         │
└─────────────────────────────────────────────────────────┘
                          │
                          ▼
┌─────────────────────────────────────────────────────────┐
│  SSH into cPanel server                                 │
│  - Pull latest code from GitHub                         │
│  - Install/update dependencies                          │
│  - Build frontend assets                                │
│  - Run Laravel optimizations                            │
│  - Set permissions                                      │
└─────────────────────────────────────────────────────────┘
                          │
                          ▼
┌─────────────────────────────────────────────────────────┐
│  Application deployed and live!                         │
│  https://flow.clubemkt.digital                          │
└─────────────────────────────────────────────────────────┘
```

### Manual Deployment

```bash
# Quick deployment from local machine
CPANEL_USER=username ./deploy.sh
```

---

## Troubleshooting

### SSH Connection Issues

**Problem:** "Permission denied (publickey)"

**Solution:**
```bash
# Check if your key is loaded
ssh-add -l

# Add your key to the SSH agent
ssh-add ~/.ssh/flowmkt_deploy

# Test connection with verbose output
ssh -v -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital
```

### Git Pull Fails

**Problem:** "Authentication failed"

**Solution:**
```bash
# On the cPanel server, reconfigure Git credentials
cd ~/public_html
git config credential.helper store
git pull  # Enter credentials when prompted
```

### Permission Errors

**Problem:** "Permission denied" when writing files

**Solution:**
```bash
# On the cPanel server
cd ~/public_html/core
chmod -R 755 storage bootstrap/cache
chown -R $USER:$USER storage bootstrap/cache
```

### Composer/NPM Not Found

**Problem:** "composer: command not found" or "npm: command not found"

**Solution:**
```bash
# Check if they're installed in a non-standard location
which composer
which npm

# If found, use full path in deployment script
/usr/local/bin/composer install
/usr/local/bin/npm ci

# Or add to PATH
export PATH=$PATH:/usr/local/bin
```

### GitHub Actions Fails

**Problem:** Workflow fails with SSH errors

**Solution:**
1. Verify all secrets are correctly set in GitHub
2. Check that the private key is complete (including header/footer)
3. Ensure the key has no passphrase
4. Test SSH connection manually from your machine

### Build Fails

**Problem:** "npm run build" fails

**Solution:**
```bash
# On the cPanel server, check Node.js version
node -v

# If version is too old, update Node.js
# Contact your hosting provider or use nvm:
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash
nvm install 18
nvm use 18
```

---

## Security Best Practices

1. **Never commit private keys to Git**
   - Add `*.pem`, `*.key`, `id_rsa*` to `.gitignore`

2. **Use separate deploy keys**
   - Don't use your personal SSH key for deployments
   - Create dedicated keys for each environment

3. **Limit key permissions**
   - Deploy keys should be read-only when possible
   - Use GitHub's deploy key feature with minimal permissions

4. **Rotate keys regularly**
   - Change deployment keys every 6-12 months
   - Revoke old keys immediately

5. **Use environment-specific branches**
   - `main` → production
   - `staging` → staging environment
   - `develop` → development environment

6. **Monitor deployments**
   - Check GitHub Actions logs regularly
   - Set up notifications for failed deployments

---

## Additional Resources

- [GitHub Actions Documentation](https://docs.github.com/en/actions)
- [SSH Key Management](https://docs.github.com/en/authentication/connecting-to-github-with-ssh)
- [cPanel SSH Access](https://docs.cpanel.net/knowledge-base/security/how-to-use-ssh-keys/)
- [Laravel Deployment](https://laravel.com/docs/deployment)

---

## Quick Reference

### Environment Variables

```bash
# For deploy.sh script
export CPANEL_USER="your_username"
export CPANEL_HOST="flow.clubemkt.digital"
export CPANEL_PATH="public_html"
export SSH_PORT="22"
export SSH_KEY="~/.ssh/flowmkt_deploy"
```

### Common Commands

```bash
# Deploy manually
./deploy.sh

# Test SSH connection
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital

# View deployment logs (GitHub Actions)
# Go to: https://github.com/yourusername/your-repo/actions

# Clear Laravel caches on server
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital "cd public_html/core && php artisan cache:clear && php artisan config:clear && php artisan view:clear"
```

---

## Support

If you encounter issues not covered in this guide:

1. Check the GitHub Actions logs for detailed error messages
2. SSH into the server and check Laravel logs: `core/storage/logs/laravel.log`
3. Verify all prerequisites are installed and up to date
4. Contact your hosting provider for server-specific issues

---

**Last Updated:** January 30, 2026
**Application:** FlowMkt
**Environment:** https://flow.clubemkt.digital
