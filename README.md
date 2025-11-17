# Booking management mini-system

## Description

A Laravel-based REST API designed to manage services and bookings with role-based authorization, structured service layers, custom validation, and well-formatted API resources.
Authentication is handled using JWT (JSON Web Tokens).

## Features

-   Full CRUD for Services
-   Full CRUD for Bookings
-   Role-based access control (Admin, Staff, User)
-   JWT Authentication
-   API Resources for clean JSON formatting
-   Pagination support
-   Centralized error handling
-   Service Layer architecture for clean code separation
-   Custom Form Requests
-   Policies for authorization

## Requirements

-   PHP 8.1+
-   XAMPP
-   Composer
-   Laravel 11+
-   MySQL
-   Postman Collection: Contains all API requests for easy testing and interaction with the API.

## How to Run the Project

1.  ### Clone the Repository
    ```bash
    git clone https://github.com/alialjndy/booking_management_mini_system.git
    cd booking_management_mini_system
    ```
2.  ### Install dependencies
    ```bash
    composer install
    ```
3.  ### Create environment file
    ```bash
    cp .env.example .env
    ```
4.  ### Generate app key
    ```bash
    php artisan key:generate
    ```
5.  ### Install JWT package
    ```bash
    composer require tymon/jwt-auth
    php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
    php artisan jwt:secret
    ```
6.  ### Run migrations and seeders
    ```bash
    Run migrations and seeders
    ```

### Project Structure

-   **Controllers** : Handle API requests and responses.
-   **Requests** : Contain validation and per-endpoint authorization logic.
-   **Resources** : Format JSON responses consistently.
-   **Policies** : Control what each user role is allowed to do.
-   **Services** : Hold business logic such as creating or updating services.

### Postman Collection:

You can access the Postman collection for this project by following this [link](https://documenter.getpostman.com/view/37833857/2sB3Wwqcpc). The collection includes all the necessary API requests for testing the application.
