#!/bin/bash

# FlowMkt Deployment Status Checker
# This script checks if your deployment is properly configured

set -e

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

print_status() {
    echo -e "${GREEN}[✓]${NC} $1"
}

print_error() {
    echo -e "${RED}[✗]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[!]${NC} $1"
}

print_info() {
    echo -e "${BLUE}[i]${NC} $1"
}

echo -e "\n${BLUE}FlowMkt Deployment Status Check${NC}\n"

# Check 1: SSH Key
echo "Checking SSH key..."
if [ -f "$HOME/.ssh/flowmkt_deploy" ]; then
    print_status "SSH key exists at $HOME/.ssh/flowmkt_deploy"
else
    print_error "SSH key not found at $HOME/.ssh/flowmkt_deploy"
    echo "  Run: ssh-keygen -t rsa -b 4096 -C 'your_email@example.com' -f ~/.ssh/flowmkt_deploy"
fi

# Check 2: Deployment script
echo "Checking deployment script..."
if [ -f "deploy.sh" ] && [ -x "deploy.sh" ]; then
    print_status "Deployment script exists and is executable"
else
    print_error "Deployment script not found or not executable"
    echo "  Run: chmod +x deploy.sh"
fi

# Check 3: GitHub Actions workflow
echo "Checking GitHub Actions workflow..."
if [ -f ".github/workflows/deploy-to-cpanel.yml" ]; then
    print_status "GitHub Actions workflow exists"
else
    print_error "GitHub Actions workflow not found"
fi

# Check 4: .gitignore
echo "Checking .gitignore..."
if [ -f ".gitignore" ]; then
    if grep -q "*.key" .gitignore && grep -q "*.pem" .gitignore; then
        print_status ".gitignore properly configured"
    else
        print_warning ".gitignore exists but may not protect SSH keys"
    fi
else
    print_error ".gitignore not found"
fi

# Check 5: Environment configuration
echo "Checking deployment configuration..."
if [ -f ".env.deploy" ]; then
    print_status "Deployment configuration exists"
    source .env.deploy
    
    if [ -n "$CPANEL_USER" ] && [ -n "$CPANEL_HOST" ]; then
        print_status "Configuration variables set"
        
        # Test SSH connection
        echo "Testing SSH connection..."
        if ssh -i "$SSH_KEY" -p "${SSH_PORT:-22}" -o ConnectTimeout=10 "$CPANEL_USER@$CPANEL_HOST" "echo 'OK'" > /dev/null 2>&1; then
            print_status "SSH connection successful"
        else
            print_error "SSH connection failed"
            echo "  Check your credentials and SSH key"
        fi
    else
        print_warning "Configuration incomplete"
    fi
else
    print_warning "Deployment configuration not found"
    echo "  Run: ./setup-deployment.sh"
fi

# Check 6: Git repository
echo "Checking Git repository..."
if [ -d ".git" ]; then
    print_status "Git repository initialized"
    
    # Check remote
    if git remote get-url origin > /dev/null 2>&1; then
        remote_url=$(git remote get-url origin)
        print_status "Git remote configured: $remote_url"
    else
        print_warning "Git remote not configured"
    fi
else
    print_error "Not a Git repository"
fi

# Check 7: Required tools
echo "Checking required tools..."

if command -v php > /dev/null 2>&1; then
    php_version=$(php -v | head -n 1)
    print_status "PHP installed: $php_version"
else
    print_error "PHP not found"
fi

if command -v composer > /dev/null 2>&1; then
    composer_version=$(composer --version | head -n 1)
    print_status "Composer installed: $composer_version"
else
    print_error "Composer not found"
fi

if command -v node > /dev/null 2>&1; then
    node_version=$(node -v)
    print_status "Node.js installed: $node_version"
else
    print_error "Node.js not found"
fi

if command -v npm > /dev/null 2>&1; then
    npm_version=$(npm -v)
    print_status "NPM installed: v$npm_version"
else
    print_error "NPM not found"
fi

# Summary
echo ""
echo -e "${BLUE}========================================${NC}"
echo -e "${BLUE}Summary${NC}"
echo -e "${BLUE}========================================${NC}"
echo ""

if [ -f ".env.deploy" ]; then
    source .env.deploy
    echo "Configuration:"
    echo "  Host: $CPANEL_HOST"
    echo "  User: $CPANEL_USER"
    echo "  Path: $CPANEL_PATH"
    echo "  SSH Key: $SSH_KEY"
    echo ""
fi

echo "Next steps:"
echo "  1. If any checks failed, run: ./setup-deployment.sh"
echo "  2. Add GitHub secrets (see DEPLOYMENT_GUIDE.md)"
echo "  3. Test deployment: ./deploy.sh"
echo "  4. Push to GitHub to trigger automatic deployment"
echo ""
