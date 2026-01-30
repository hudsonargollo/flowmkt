# TurboCloud SSH Setup Guide

## Your Connection Details

- **Username:** clubemkt
- **Server:** finn1080.com.br (or br.finn1080.com.br)
- **SSH Port:** 2222 (typical for TurboCloud)
- **Your IP:** 177.57.220.76
- **SSH Key:** ~/.ssh/flowmkt_deploy

## Steps to Enable SSH Access

### 1. Whitelist Your IP Address

In cPanel:
1. Go to **Segurança** → **Acesso SSH**
2. Look for **"Gerenciar acesso SSH"** or IP whitelist section
3. Add your IP: `177.57.220.76`
4. Save changes

### 2. Verify SSH Key is Authorized

✅ Already done - I can see "flow" key is authorized in your screenshot

### 3. Contact TurboCloud Support (if needed)

If you can't find the IP whitelist option, contact TurboCloud support:

**Message to send:**
```
Olá,

Preciso habilitar acesso SSH para minha conta.

Detalhes:
- Usuário: clubemkt
- Domínio: clubemkt.digital
- Meu IP: 177.57.220.76
- Chave SSH: já autorizada no cPanel

Por favor, podem:
1. Liberar meu IP no firewall para SSH
2. Confirmar a porta SSH (2222?)
3. Confirmar o hostname correto para conexão

Obrigado!
```

### 4. Test Connection

Once your IP is whitelisted, test with:

```bash
# Test with port 2222
ssh -i ~/.ssh/flowmkt_deploy -p 2222 clubemkt@finn1080.com.br

# Or try port 22
ssh -i ~/.ssh/flowmkt_deploy -p 22 clubemkt@finn1080.com.br

# Or with br subdomain
ssh -i ~/.ssh/flowmkt_deploy -p 2222 clubemkt@br.finn1080.com.br
```

## Common TurboCloud SSH Ports

- **2222** - Most common for shared hosting
- **22** - Standard SSH port (sometimes blocked)
- **2223** - Alternative port

## Troubleshooting

### "Operation timed out"
- Your IP is not whitelisted in the firewall
- Contact TurboCloud support to whitelist: 177.57.220.76

### "Permission denied"
- SSH key not authorized (already fixed ✅)
- Wrong username

### "Connection refused"
- Wrong port number
- SSH service not running

## After SSH is Working

Update deployment configuration:

```bash
# In .env.deploy or environment variables
CPANEL_USER=clubemkt
CPANEL_HOST=finn1080.com.br  # or br.finn1080.com.br
SSH_PORT=2222  # or whatever port works
SSH_KEY=~/.ssh/flowmkt_deploy
CPANEL_PATH=public_html/flow  # path to your application
```

Then test deployment:
```bash
./deploy.sh
```

## TurboCloud Support

- **Website:** https://turbocloud.com.br
- **Support:** suporte@turbocloud.com.br
- **Phone:** Check their website for current number

---

**Next Step:** Whitelist your IP (177.57.220.76) in cPanel or contact TurboCloud support.
