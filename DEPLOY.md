# Fendo — Deploy to live server

## 1. Server requirements

- PHP **8.2+** (mbstring, openssl, pdo_mysql, tokenizer, xml, ctype, json, fileinfo)
- **MySQL** 5.7+ / MariaDB
- **Composer**
- Apache or Nginx — document root → `public/`
- SSL (HTTPS)

---

## 2. Upload Laravel (Fendo)

Upload the project **except** `vendor/`, `node_modules/`, `.env`.

On the server:

```bash
cd /path/to/Fendo
composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate
```

Edit `.env`:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_DATABASE=...
DB_USERNAME=...
DB_PASSWORD=...

FIREBASE_WEB_API_KEY=your_key
SMS_API_URL=https://your-sms-api/send
SMS_API_TOKEN=your_token

APP_DEMO_ENABLED=false
```

Setup:

```bash
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Linux permissions:

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

**Document root = `public/`**

| URL | Path |
|-----|------|
| API | `https://yourdomain.com/api/v1` |
| Admin | `https://yourdomain.com/admin/login` |
| Health | `https://yourdomain.com/up` |

Admin default: `admin@gmail.com` / `12345678` — change after first login.

---

## 3. Test live API

```bash
curl -s https://yourdomain.com/up
curl -s -X POST https://yourdomain.com/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"phone":"01712345678","country_code":"+880","password":"12345678"}'
```

---

## 4. Build Flutter for live

Replace `yourdomain.com`:

```bash
cd fendo_apps
flutter build apk --release --dart-define=API_BASE=https://yourdomain.com/api/v1
```

APK: `build/app/outputs/flutter-apk/app-release.apk`

Play Store:

```bash
flutter build appbundle --release --dart-define=API_BASE=https://yourdomain.com/api/v1
```

Firebase: add release SHA-1, enable Phone auth, keep `google-services.json` in `android/app/`.

---

## 5. Production checklist

- [ ] `APP_DEBUG=false`
- [ ] `APP_URL` = your HTTPS domain
- [ ] `php artisan migrate --force`
- [ ] `php artisan storage:link`
- [ ] Admin password changed
- [ ] Firebase + SMS gateway set
- [ ] Flutter built with `--dart-define=API_BASE=...`
- [ ] `APP_DEMO_ENABLED=false` on live

---

## Local vs live

| | Local | Live |
|--|-------|------|
| API | `http://fendo.test/api/v1` | `https://yourdomain.com/api/v1` |
| Emulator app | `10.0.2.2/Fendo/public/api/v1` | `--dart-define=API_BASE=...` |
| Demo button | `APP_DEMO_ENABLED=true` | `false` |
