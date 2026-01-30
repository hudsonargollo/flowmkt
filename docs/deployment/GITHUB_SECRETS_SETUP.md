# GitHub Secrets Setup for FlowMkt Deployment

Your code is now on GitHub! 🎉

**Repository:** https://github.com/hudsonargollo/flowmkt

## Next Step: Add GitHub Secrets

To enable automated deployment, you need to add secrets to your GitHub repository.

### 1. Go to Repository Settings

Visit: https://github.com/hudsonargollo/flowmkt/settings/secrets/actions

Or manually:
1. Go to https://github.com/hudsonargollo/flowmkt
2. Click **Settings** (top menu)
3. Click **Secrets and variables** → **Actions** (left sidebar)
4. Click **New repository secret**

### 2. Add These Secrets

Click "New repository secret" for each one:

#### Secret 1: CPANEL_HOST
- **Name:** `CPANEL_HOST`
- **Value:** `finn1080.com.br` (or `br.finn1080.com.br`)

#### Secret 2: CPANEL_USERNAME
- **Name:** `CPANEL_USERNAME`
- **Value:** `clubemkt`

#### Secret 3: CPANEL_SSH_KEY
- **Name:** `CPANEL_SSH_KEY`
- **Value:** Your private SSH key (see below)

To get your private key, run this command:
```bash
cat ~/.ssh/flowmkt_deploy
```

Copy the **entire output** including:
```
-----BEGIN OPENSSH PRIVATE KEY-----
b3BlbnNzaC1rZXktdjEAAAAABG5vbmUAAAAEbm9uZQAAAAAAAAABAAABlwAAAAdzc2gtcn
... (many lines) ...
-----END OPENSSH PRIVATE KEY-----
```

#### Secret 4: CPANEL_SSH_PORT
- **Name:** `CPANEL_SSH_PORT`
- **Value:** `2222` (TurboCloud typically uses port 2222)

#### Secret 5: CPANEL_APP_PATH
- **Name:** `CPANEL_APP_PATH`
- **Value:** `public_html/flow` (or wherever your app is located)

### 3. Summary of Secrets

| Secret Name | Value |
|-------------|-------|
| `CPANEL_HOST` | `finn1080.com.br` |
| `CPANEL_USERNAME` | `clubemkt` |
| `CPANEL_SSH_KEY` | Contents of `~/.ssh/flowmkt_deploy` |
| `CPANEL_SSH_PORT` | `2222` |
| `CPANEL_APP_PATH` | `public_html/flow` |

### 4. Verify Secrets Are Added

After adding all secrets, you should see 5 secrets listed at:
https://github.com/hudsonargollo/flowmkt/settings/secrets/actions

### 5. Test Automated Deployment

Once secrets are added and your IP is whitelisted on TurboCloud:

1. Make a small change to any file
2. Commit and push:
   ```bash
   git add .
   git commit -m "Test automated deployment"
   git push origin main
   ```
3. Watch the deployment at: https://github.com/hudsonargollo/flowmkt/actions

## Important: TurboCloud SSH Access

**Before automated deployment will work, you need to:**

1. **Whitelist your IP on TurboCloud**
   - Your IP: `177.57.220.76`
   - Contact TurboCloud support or add it in cPanel

2. **Verify SSH port**
   - TurboCloud typically uses port `2222`
   - Confirm with your hosting provider

3. **Test SSH connection manually**
   ```bash
   ssh -i ~/.ssh/flowmkt_deploy -p 2222 clubemkt@finn1080.com.br
   ```

## What Happens After Setup

Once everything is configured:

1. **Every push to `main` branch** → Automatic deployment
2. **GitHub Actions** will:
   - Pull latest code on your server
   - Install dependencies (Composer & NPM)
   - Build assets
   - Optimize Laravel
   - Set permissions
3. **Your site updates automatically** at https://flow.clubemkt.digital

## Troubleshooting

### GitHub Actions fails with "Connection timeout"
- Your IP is not whitelisted on TurboCloud
- Contact support to whitelist: `177.57.220.76`

### GitHub Actions fails with "Permission denied"
- SSH key secret might be incomplete
- Make sure you copied the entire private key including header/footer

### GitHub Actions fails with "Repository not found"
- Check that Git is configured on your server
- SSH into server and run: `cd ~/public_html/flow && git remote -v`

## Next Steps

1. ✅ Code pushed to GitHub
2. ⏳ Add GitHub secrets (do this now)
3. ⏳ Whitelist IP on TurboCloud
4. ⏳ Test automated deployment
5. ⏳ Verify site is live

---

**Quick Links:**
- Repository: https://github.com/hudsonargollo/flowmkt
- Add Secrets: https://github.com/hudsonargollo/flowmkt/settings/secrets/actions
- View Actions: https://github.com/hudsonargollo/flowmkt/actions
- Live Site: https://flow.clubemkt.digital
