# iFixit Tutorials en Català de Hakim

Aquest projecte és una aplicació web desenvolupada amb Laravel que importa tutorials de reparació de dispositius des de la API d'[iFixit](https://www.ifixit.com/) i els tradueix automàticament al català. Inclou una interfície per consultar-los i cercar-los de forma intuïtiva.

## ✨ Funcionalitats

- ✅ Importació de tutorials des de l'API de iFixit
- 🌐 Traducció automàtica al català utilitzant [Stichoza Google Translate](https://github.com/Stichoza/google-translate-php)
- 🔎 Sistema de cerca per paraula clau
- 🧭 Visualització dels passos de reparació amb text i imatges
- 💾 Base de dades SQLite per a emmagatzematge local
- 📦 Organització per categories com "Mac", "Smartphones", etc.

## 🛠️ Requisits

- PHP >= 8.1
- Composer
- Laravel 10
- SQLite
- Extensió `pdo_sqlite` habilitada

## 🚀 Instal·lació

1️⃣ Clona el repositori:

   git clone https://github.com/elTeuUsuari/ifixit-tutorials.git
   cd ifixit-tutorials
   
2️⃣ Instal·la les dependències del projecte
composer install

3️⃣ Configura l'entorn i la base de dades SQLite
cp .env.example .env
touch database/database.sqlite
Després, edita el fitxer .env i assegura’t que tingui aquesta configuració:
env
DB_CONNECTION=sqlite
DB_DATABASE=./database/database.sqlite

4️⃣ Genera la clau de l’aplicació i executa les migracions
php artisan key:generate
php artisan migrate

5️⃣ Inicia el servidor de desenvolupament

php artisan serve
