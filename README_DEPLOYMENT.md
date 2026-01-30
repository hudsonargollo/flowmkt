# FlowMkt - Automated Deployment System

Complete automated deployment solution for FlowMkt to cPanel using SSH keys and GitHub Actions.

## 📋 Overview

This deployment system provides:

- ✅ **Automated deployment** via GitHub Actions on every push
- ✅ **Manual deployment** via command-line script
- ✅ **Secure SSH key authentication** (no passwords needed)
- ✅ **Zero-downtime deployments**
- ✅ **Automatic dependency installation** (Composer & NPM)
- ✅ **Asset building and optimization**
- ✅ **Laravel cache management**

## 🚀 Quick Start

### 1. Run Setup Script

```bash
./setup-deployment.sh
```

This interactive script will:
- Generate SSH keys
- Guide you through cPanel configuration
- Test your connection
- Configure Git on the server
- Provide GitHub secrets

### 2. Add GitHub Secrets

Go to your GitHub repository → Settings → Secrets and add the secrets provided by the setup script.

### 3. Deploy!

**Automatic:** Push to main branch
```bash
git push origin main
```

**Manual:** Run deployment script
```bash
./deploy.sh
```

## 📁 Files Included

| File | Purpose |
|------|---------|
| `deploy.sh` | Manual deployment script |
| `setup-deployment.sh` | Interactive setup wizard |
| `check-deployment.sh` | Verify deployment configuration |
| `.github/workflows/deploy-to-cpanel.yml` | Production deployment workflow |
| `.github/workflows/deploy-to-staging.yml` | Staging deployment workflow |
| `DEPLOYMENT_GUIDE.md` | Complete documentation |
| `DEPLOYMENT_QUICKSTART.md` | Quick reference guide |

## 🔧 Usage

### Check Deployment Status

```bash
./check-deployment.sh
```

### Manual Deployment

```bash
# Using environment variables
CPANEL_USER=your_username ./deploy.sh

# Or with .env.deploy file
./deploy.sh
```

### Deploy to Staging

```bash
git push origin staging
```

### View Deployment Logs

**GitHub Actions:**
- Go to your repository → Actions tab

**Server Logs:**
```bash
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital \
  "tail -f public_html/core/storage/logs/laravel.log"
```

## 🔐 Security

- SSH keys are used for authentication (no passwords)
- Private keys are stored as GitHub secrets
- Keys are never committed to the repository
- `.gitignore` protects sensitive files

## 📚 Documentation

- **Quick Start:** [DEPLOYMENT_QUICKSTART.md](DEPLOYMENT_QUICKSTART.md)
- **Full Guide:** [DEPLOYMENT_GUIDE.md](DEPLOYMENT_GUIDE.md)

## 🐛 Troubleshooting

### SSH Connection Issues

```bash
# Test connection
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital

# Add key to agent
ssh-add ~/.ssh/flowmkt_deploy
```

### Deployment Fails

```bash
# Check status
./check-deployment.sh

# View GitHub Actions logs
# Go to: https://github.com/yourusername/your-repo/actions
```

### Permission Errors

```bash
# SSH into server and fix permissions
ssh -i ~/.ssh/flowmkt_deploy username@flow.clubemkt.digital
cd ~/public_html/core
chmod -R 755 storage bootstrap/cache
```

## 🎯 Deployment Workflow

```
Local Development
       ↓
   Git Commit
       ↓
   Git Push (main branch)
       ↓
GitHub Actions Triggered
       ↓
   Build & Test
       ↓
SSH to cPanel Server
       ↓
   Git Pull
       ↓
Install Dependencies
       ↓
   Build Assets
       ↓
Laravel Optimization
       ↓
   Live! 🎉
```

## 📊 Deployment Checklist

Before first deployment:

- [ ] SSH key generated
- [ ] Public key added to cPanel
- [ ] SSH connection tested
- [ ] Git configured on server
- [ ] GitHub secrets added
- [ ] `.env` file configured on server
- [ ] Database configured
- [ ] File permissions set correctly

## 🔄 Continuous Deployment

### Production (main branch)

```bash
git checkout main
git merge develop
git push origin main
# Automatically deploys to production
```

### Staging (staging branch)

```bash
git checkout staging
git merge develop
git push origin staging
# Automatically deploys to staging
```

## 🛠️ Server Requirements

- PHP 8.1+
- Composer
- Node.js 18+
- NPM
- Git
- SSH access

## 📞 Support

If you encounter issues:

1. Run `./check-deployment.sh` to diagnose problems
2. Check [DEPLOYMENT_GUIDE.md](DEPLOYMENT_GUIDE.md) for detailed troubleshooting
3. Review GitHub Actions logs for deployment errors
4. Check server logs: `core/storage/logs/laravel.log`

## 🎓 Learn More

- [GitHub Actions Documentation](https://docs.github.com/en/actions)
- [SSH Key Management](https://docs.github.com/en/authentication/connecting-to-github-with-ssh)
- [Laravel Deployment](https://laravel.com/docs/deployment)

---

**Application:** FlowMkt  
**Environment:** https://flow.clubemkt.digital  
**Last Updated:** January 30, 2026
