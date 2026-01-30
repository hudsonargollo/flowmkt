#!/bin/bash

# FlowMkt Deployment Setup Script
# This script helps you set up SSH keys and configure deployment

set -e

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

print_header() {
    echo -e "\n${BLUE}========================================${NC}"
    echo -e "${BLUE}$1${NC}"
    echo -e "${BLUE}========================================${NC}\n"
}

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

# Welcome message
clear
print_header "FlowMkt Deployment Setup"
echo "This script will help you set up automated deployment to cPanel."
echo ""

# Step 1: Generate SSH Key
print_header "Step 1: SSH Key Generation"

SSH_KEY_PATH="$HOME/.ssh/flowmkt_deploy"

if [ -f "$SSH_KEY_PATH" ]; then
    print_warning "SSH key already exists at $SSH_KEY_PATH"
    read -p "Do you want to use the existing key? (y/n): " use_existing
    if [ "$use_existing" != "y" ]; then
        read -p "Enter new key path (default: $SSH_KEY_PATH): " new_path
        SSH_KEY_PATH="${new_path:-$SSH_KEY_PATH}"
    fi
else
    print_info "Generating new SSH key..."
    read -p "Enter your email: " email
    ssh-keygen -t rsa -b 4096 -C "$email" -f "$SSH_KEY_PATH" -N ""
    print_status "SSH key generated successfully!"
fi

# Step 2: Display public key
print_header "Step 2: Add Public Key to cPanel"

echo "Copy the following public key and add it to your cPanel:"
echo ""
echo "----------------------------------------"
cat "${SSH_KEY_PATH}.pub"
echo "----------------------------------------"
echo ""
print_info "To add the key to cPanel:"
echo "  1. Log in to cPanel"
echo "  2. Go to Security → SSH Access → Manage SSH Keys"
echo "  3. Click 'Import Key'"
echo "  4. Paste the public key above"
echo "  5. Click 'Import' then 'Authorize'"
echo ""
read -p "Press Enter when you've added the key to cPanel..."

# Step 3: Test SSH connection
print_header "Step 3: Test SSH Connection"

read -p "Enter your cPanel username: " cpanel_user
read -p "Enter your cPanel host (default: flow.clubemkt.digital): " cpanel_host
cpanel_host="${cpanel_host:-flow.clubemkt.digital}"
read -p "Enter SSH port (default: 22): " ssh_port
ssh_port="${ssh_port:-22}"

print_info "Testing SSH connection..."
if ssh -i "$SSH_KEY_PATH" -p "$ssh_port" -o ConnectTimeout=10 "$cpanel_user@$cpanel_host" "echo 'Connection successful'" 2>/dev/null; then
    print_status "SSH connection successful!"
else
    print_error "SSH connection failed. Please check your settings and try again."
    exit 1
fi

# Step 4: Configure Git on server
print_header "Step 4: Configure Git on Server"

read -p "Enter your application path on cPanel (default: public_html): " app_path
app_path="${app_path:-public_html}"

print_info "Setting up Git repository on server..."
ssh -i "$SSH_KEY_PATH" -p "$ssh_port" "$cpanel_user@$cpanel_host" << ENDSSH
    cd ~/$app_path
    
    # Initialize Git if not already initialized
    if [ ! -d .git ]; then
        git init
        echo "Git repository initialized"
    fi
    
    # Check if remote exists
    if ! git remote get-url origin > /dev/null 2>&1; then
        read -p "Enter your GitHub repository URL (e.g., https://github.com/user/repo.git): " repo_url
        git remote add origin "\$repo_url"
        echo "Git remote added"
    fi
    
    echo "Git configuration complete"
ENDSSH

print_status "Git configured on server!"

# Step 5: GitHub configuration
print_header "Step 5: GitHub Configuration"

echo "To enable automatic deployment via GitHub Actions:"
echo ""
print_info "1. Go to your GitHub repository"
print_info "2. Navigate to Settings → Secrets and variables → Actions"
print_info "3. Add the following secrets:"
echo ""
echo "   CPANEL_HOST: $cpanel_host"
echo "   CPANEL_USERNAME: $cpanel_user"
echo "   CPANEL_SSH_PORT: $ssh_port"
echo "   CPANEL_APP_PATH: $app_path"
echo ""
echo "   CPANEL_SSH_KEY: (paste the content below)"
echo "   ----------------------------------------"
cat "$SSH_KEY_PATH"
echo "   ----------------------------------------"
echo ""
read -p "Press Enter when you've added the secrets to GitHub..."

# Step 6: Create environment file
print_header "Step 6: Create Deployment Configuration"

cat > .env.deploy << EOF
# FlowMkt Deployment Configuration
CPANEL_USER=$cpanel_user
CPANEL_HOST=$cpanel_host
CPANEL_PATH=$app_path
SSH_PORT=$ssh_port
SSH_KEY=$SSH_KEY_PATH
EOF

print_status "Configuration saved to .env.deploy"

# Step 7: Test deployment
print_header "Step 7: Test Deployment"

read -p "Do you want to test the deployment now? (y/n): " test_deploy

if [ "$test_deploy" = "y" ]; then
    print_info "Running test deployment..."
    source .env.deploy
    ./deploy.sh
    
    if [ $? -eq 0 ]; then
        print_status "Test deployment successful!"
    else
        print_error "Test deployment failed. Please check the errors above."
    fi
fi

# Final message
print_header "Setup Complete!"

echo "Your deployment is now configured!"
echo ""
print_status "Manual deployment: ./deploy.sh"
print_status "Automatic deployment: Push to main branch on GitHub"
print_status "Configuration file: .env.deploy"
echo ""
print_info "For more information, see DEPLOYMENT_GUIDE.md"
echo ""
