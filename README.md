# EcoSaldo

> **Sampahmu, Saldomu.**
> Platform bank sampah digital — ubah sampah jadi saldo nyata.

---

## Fitur Utama

| Fitur | Deskripsi |
|---|---|
| Setor Sampah | Admin mencatat setoran, saldo nasabah otomatis bertambah |
| Tarik Saldo | Nasabah tarik saldo ke rekening bank via Midtrans Iris |
| Tukar Reward | Katalog reward: pulsa, sembako, token listrik |
| Laporan | Dashboard analitik, filter tanggal, dan export Excel |
| Notifikasi | Real-time notification untuk setiap aktivitas |

---

## Tech Stack

| Layer | Teknologi |
|---|---|
| Backend | Laravel 11 · PHP 8.3 |
| Frontend | Blade · Alpine.js · Tailwind CSS · Chart.js |
| Database | MySQL |
| Payment | Midtrans Iris (Disbursement) |
| Auth | Laravel Breeze · Spatie Permission |
| Export | PhpSpreadsheet |
| Icons | Heroicons |

---

## Arsitektur

```
app/
├── Http/
│   ├── Controllers/     # Thin controllers
│   └── Requests/        # Form validation
├── Models/              # Eloquent + Enum casts
├── Services/            # Business logic layer
└── Enums/               # Status types

resources/
└── views/components/    # Blade UI components
```

Standar yang diterapkan: Service Layer, Form Requests, Enum, Anonymous Blade Components, Rate Limiting, WCAG AA Accessibility, SEO (Open Graph, JSON-LD, sitemap).

---

## Keamanan

- CSRF protection
- XSS auto-escape (Blade)
- SQL Injection prevention (Eloquent)
- Mass assignment protection
- Rate limiting
- Role-based authorization (Spatie)

---

## Instalasi Lokal

```bash
git clone https://github.com/faizdev/ecosaldo.git
cd ecosaldo
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm install && npm run build
php artisan serve
```

**Login default**

| Role | Email | Password |
|---|---|---|
| Admin | admin@ecosaldo.test | password |
| Nasabah | Register via `/register` | — |

---

## Environment Variables

```env
APP_NAME=EcoSaldo
APP_URL=http://localhost:8000

DB_DATABASE=db_ecosaldo

MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxx
MIDTRANS_MERCHANT_ID=Gxxxxx
MIDTRANS_IS_PRODUCTION=false
```

---

## Status Proyek

| Fase | Status |
|---|---|
| MVP Development | Selesai |
| Midtrans Integration | Menunggu aktivasi Iris |
| Deployment | Belum dimulai |

---

## Lisensi

Proprietary. Hak cipta dilindungi.

---

Dibangun untuk bumi dan ekonomi sirkular Indonesia.