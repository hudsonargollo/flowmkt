#!/bin/bash

# Script to find the correct SSH port for cPanel

HOST="flow.clubemkt.digital"
USER="clubemkt"
SSH_KEY="$HOME/.ssh/flowmkt_deploy"

echo "Testing SSH ports for $HOST..."
echo ""

# Common SSH ports for cPanel/WHM
PORTS=(22 2222 2223 2224 22222)

for PORT in "${PORTS[@]}"; do
    echo -n "Testing port $PORT... "
    
    # Try to connect with 5 second timeout
    timeout 5 ssh -i "$SSH_KEY" -p "$PORT" -o ConnectTimeout=5 -o StrictHostKeyChecking=no "$USER@$HOST" "echo 'SUCCESS'" 2>/dev/null
    
    if [ $? -eq 0 ]; then
        echo "✓ FOUND! SSH is running on port $PORT"
        echo ""
        echo "Update your deployment configuration:"
        echo "  SSH_PORT=$PORT"
        echo ""
        echo "Test connection:"
        echo "  ssh -i $SSH_KEY -p $PORT $USER@$HOST"
        exit 0
    else
        echo "✗ Failed"
    fi
done

echo ""
echo "Could not find SSH port. Please check:"
echo "1. SSH is enabled in cPanel"
echo "2. Your IP is not blocked by firewall"
echo "3. The SSH key is properly authorized in cPanel"
echo "4. Contact your hosting provider for the correct SSH port"
