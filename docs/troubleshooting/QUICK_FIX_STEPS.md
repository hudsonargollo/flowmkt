# Quick Fix for 500 Error - 3 Simple Steps

## Step 1: Upload .env File (2 minutes)

1. **Download** the `production.env` file I created
2. **Rename** it to `.env` (remove "production" from the name)
3. **Upload** to cPanel:
   - Go to cPanel → File Manager
   - Navigate to: `/home/clubemkt/flow.clubemkt.digital/core/`
   - Click "Upload"
   - Upload the `.env` file
   - **Verify** it's named `.env` (not `production.env`)

## Step 2: Install Composer Dependencies

**Contact TurboCloud Support** and send this message:

```
Olá,

Preciso instalar as dependências do Composer no meu projeto Laravel em:
/home/clubemkt/flow.clubemkt.digital/core

Por favor, podem executar:

cd /home/clubemkt/flow.clubemkt.digital/core
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache
chmod -R 755 storage bootstrap/cache

Obrigado!
```

**Or if you have SSH access:**

```bash
ssh -i ~/.ssh/flowmkt_deploy -p 2222 clubemkt@finn1080.com.br
cd /home/clubemkt/flow.clubemkt.digital/core
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache
chmod -R 755 storage bootstrap/cache
```

## Step 3: Test Your Site

Visit: https://flow.clubemkt.digital

It should work now! 🎉

## If Still Not Working

Run the diagnostic again:
https://flow.clubemkt.digital/diagnose.php

And send me the output.

---

**That's it!** Just upload the .env file and run composer install.
