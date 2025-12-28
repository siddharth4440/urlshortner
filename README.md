## Run Locally

Clone the project

```bash
  git clone https://github.com/siddharth4440/urlshortner.git
```

Go to the project directory

```bash
  cd urlshortner
```

Install dependencies

```bash
  composer install
  npm install
```

Migrate database

```bash
  php artisan migrate
  php artisan db:seed
```

Start the server

```bash
  composer run dev
  npm run start
```

## Tech Stack

**Client:** Blade, TailwindCSS

**Server:** Php, laravel
