# The Editorial Roast

![Symfony](https://img.shields.io/badge/Symfony-7.3-000000?style=for-the-badge&logo=symfony&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Doctrine](https://img.shields.io/badge/Doctrine-ORM-blue?style=for-the-badge)

The Editorial Roast is a fully-featured e-commerce web application built from scratch. This project was developed as an academic endeavor to learn and practice the Symfony PHP framework.

## Features

- Complete E-Commerce Flow: Browse products, view details, and manage a shopping cart.
- Multi-Step Checkout System: Handle multiple shipping addresses and payment methods.
- Secure Authentication: Registration, login, and password recovery.
- User Profiles: Dedicated customer dashboards.
- Beautiful UI/UX: Custom-designed interface built with Tailwind CSS.
- Database Integration: Relational data modeling using Doctrine ORM.

## Screenshots

### Home Page
![Home Page](Screenshots/Home%20Page.png)

### Shop Page
![Shop Page](Screenshots/Shop%20Page.png)

### Product Page
![Product Page](Screenshots/Product%20Page.png)

### Cart Page
![Cart Page](Screenshots/Cart%20Page.png)

### Sign In Page
![Sign In Page](Screenshots/Sign%20In%20Page.png)

### Sign Up Page
![Sign Up Page](Screenshots/Sign%20Up%20Page.png)

### Profile Page
![Profile Page](Screenshots/Profile%20Page.png)

## Getting Started

1. Clone the repository and navigate to the project directory.
2. Run `composer install` to install dependencies.
3. Copy `.env` to `.env.local` and configure your `DATABASE_URL`.
4. Run `php bin/console doctrine:database:create` and `php bin/console doctrine:migrations:migrate`.
5. Run `symfony server:start` and visit `http://localhost:8000`.

## Collaborators

* Oussama
* ALWAN Charaf Eddine
