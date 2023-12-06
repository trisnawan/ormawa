# ORMAWA

## Requirement

-   PHP Versi 8 keatas
-   PHP Library `intl`
-   PHP Library `mbstring`
-   MySQL Database
-   Composer
-   Git

## Petunjuk Instalasi

Sebelum melakukan instalasi, silahkan untuk mengaktifkan MySQL.

1. Buat file `.env` di project root dan copy-paste file `env` ke `.env`
2. Buat database dengan nama 'ormawa' atau sesuaikan dengan `.env`
3. Buka terminal di projek ini lalu jalankan script migrasi `php spark migrate`
4. Jalankan script seeder `php spark db:seed UserSeeder`

## Cara Menjalankan Web

1. Silahkan jalankan projek dengan script di terminal `php spark serve`
2. Kunjungi `http://localhost:8080/` di browser untuk membuka projek

Jika Anda ingin restore data ke database, silahkan buka phpMyAdmin dan import file SQL.
