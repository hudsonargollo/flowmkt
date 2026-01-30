# Create GitHub Repository for FlowMkt

## Option 1: Create via GitHub Website (Recommended)

### Step 1: Create Repository

1. Go to https://github.com/new
2. Fill in the details:
   - **Repository name:** `flowmkt` (or `flowmkt-app`)
   - **Description:** `FlowMkt - Marketing Automation Platform with WhatsApp Integration`
   - **Visibility:** Choose Private or Public
   - **DO NOT** initialize with README, .gitignore, or license (we already have these)
3. Click **"Create repository"**

### Step 2: Push Your Code

After creating the repository, GitHub will show you commands. Use these:

```bash
# Set the new remote URL (replace YOUR_USERNAME with your GitHub username)
git remote set-url origin https://github.com/YOUR_USERNAME/flowmkt.git

# Or if you prefer SSH:
git remote set-url origin git@github.com:YOUR_USERNAME/flowmkt.git

# Push your code
git push -u origin main
```

## Option 2: Quick Commands

If you want to use a specific repository name, run these commands:

```bash
# For repository name "flowmkt"
git remote set-url origin https://github.com/hudsonargollo/flowmkt.git
git push -u origin main

# Or for "flowmkt-app"
git remote set-url origin https://github.com/hudsonargollo/flowmkt-app.git
git push -u origin main
```

## After Pushing Successfully

### Set Up GitHub Secrets for Automated Deployment

Go to your repository → Settings → Secrets and variables → Actions → New repository secret

Add these secrets:

| Secret Name | Value |
|-------------|-------|
| `CPANEL_HOST` | `finn1080.com.br` or `br.finn1080.com.br` |
| `CPANEL_USERNAME` | `clubemkt` |
| `CPANEL_SSH_KEY` | Contents of `~/.ssh/flowmkt_deploy` (entire private key) |
| `CPANEL_SSH_PORT` | `2222` (or the correct port for TurboCloud) |
| `CPANEL_APP_PATH` | `public_html/flow` (or your app path) |

### Get Your Private Key

```bash
cat ~/.ssh/flowmkt_deploy
```

Copy the entire output including:
```
-----BEGIN OPENSSH PRIVATE KEY-----
...
-----END OPENSSH PRIVATE KEY-----
```

## Troubleshooting

### "Repository not found"
- Make sure you created the repository on GitHub first
- Check that the repository name matches exactly
- Verify you're logged into the correct GitHub account

### "Permission denied"
- You may need to authenticate with GitHub
- Try using HTTPS with a Personal Access Token
- Or set up SSH keys for GitHub

### Generate GitHub Personal Access Token (if using HTTPS)

1. Go to https://github.com/settings/tokens
2. Click "Generate new token (classic)"
3. Give it a name: "FlowMkt Deployment"
4. Select scopes: `repo` (full control of private repositories)
5. Click "Generate token"
6. Copy the token (you won't see it again!)
7. Use it as your password when pushing:
   ```bash
   git push origin main
   # Username: your_github_username
   # Password: paste_your_token_here
   ```

## Repository Recommendations

### Repository Name Suggestions
- `flowmkt` - Simple and clean
- `flowmkt-app` - More descriptive
- `flowmkt-platform` - Professional
- `flow-marketing` - Descriptive

### Repository Settings After Creation

1. **Add Description:** "FlowMkt - Marketing Automation Platform with WhatsApp Integration"
2. **Add Topics:** `laravel`, `php`, `whatsapp`, `marketing-automation`, `react`, `brazilian-portuguese`
3. **Enable Issues:** For bug tracking
4. **Enable Discussions:** For community support
5. **Set up Branch Protection:** Protect the `main` branch

---

**Next Steps After Repository is Created:**

1. Push your code (see commands above)
2. Add GitHub secrets for deployment
3. Verify GitHub Actions workflow runs successfully
4. Set up SSH access on TurboCloud (whitelist your IP)
5. Test automated deployment

**Your current IP to whitelist:** `177.57.220.76`
