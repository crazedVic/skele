# Skele - Unopinionated

Rapid Laravel app development package.

To keep this package light and easy to integrate, please ensure you have livewire and tailwindcss installed.
- [TailwindCSS](https://tailwindcss.com/docs/guides/laravel)
- [Laravel Liveware](https://laravel-livewire.com/docs/2.x/installation)

#### Requirements

- Laravel 8
- PHP 7.4
- NPM

#### Packages Used

- [Laravel Timezone](https://github.com/jamesmills/laravel-timezone)
- [Doctrine DBAL](https://github.com/doctrine/dbal)
- [Honey](https://github.com/lukeraymonddowning/honey)
- [Blade Heroicons](https://github.com/blade-ui-kit/blade-heroicons)

#### Features

- Rapid scaffolding commands (auth, components, CRUD, models)
- Automatic routing, migrations, timezones, & password hashing
- Bare-bones blade views, ready for you to customize
- PWA integration (icons, manifest, swipe down refresh)
- Infinite scrolling & modal toggle support
- & more

## Installation

Create a new Laravel 8 project:

    laravel new my-app

Configure your `.env` app, database, and mail values:

    APP_*
    DB_*
    MAIL_*

Install Livewire and Tailwind

    composer require livewire/livewire
    php artisan livewire:publish --config
    
    npm install tailwindcss@latest postcss@latest autoprefixer@latest @tailwindcss/forms -D

Require Skele via composer:

    composer require redbastie/skele

Install Skele:

    php artisan skele:install

## Commands

### Install

    php artisan skele:install

Installs the base index component, user model & factory, config files, PWA icon & manifest, CSS & JS assets, index & layout views, and configures Tailwind via webpack.

### Auth

    php artisan skele:auth

Generates auth scaffolding components & views for login, logout, password forgot & reset, register, and home.

### Model

    php artisan skele:model {class}

Generates a new model & factory with automatic migration methods included.

#### Examples

    php artisan skele:model Vehicle
    php artisan skele:model Admin/Vehicle  

### Migrate

    php artisan skele:migrate {--fresh} {--seed}

Runs the automatic migrations via the `migration` methods in your models. This uses doctrine in order to diff & apply the necessary changes to your database. Traditional Laravel migration files will be run before automatic migration methods. Optionally use `--fresh` to wipe the database before, and `--seed` to run seeders after.

#### Examples

    php artisan skele:migrate
    php artisan skele:migrate --fresh
    php artisan skele:migrate --fresh --seed

### Component

    php artisan skele:component {class} {--full} {--modal}

Generates a new component & view file. Optionally use the `--full` option to generate a full-page component with automatic routing properties included, or `--modal` to generate a modal component.

#### Examples

    php artisan skele:component Partial
    php artisan skele:component Contact --full
    php artisan skele:component Alert --modal

### CRUD

    php artisan skele:crud {class}

Generates CRUD components & views for a specified model class. If the model does not currently exist, it will be created automatically.

#### Examples

    php artisan skele:crud Vehicle
    php artisan skele:crud Admin/Vehicle

### List

    php artisan skele:list {class} {--model=}

Generates a list component with searching & infinite scrolling for the specified model. A `--model` must be specified.

#### Examples

    php artisan skele:list Vehicles --model=Vehicle
    php artisan skele:list Admin/Vehicles --model=Admin/Vehicle
