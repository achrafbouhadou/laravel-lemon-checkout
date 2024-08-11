# Laravel Lemon Squeezy Checkout

This is a simple Laravel-based checkout system integrated with Lemon Squeezy, designed for selling digital goods. The application uses Inertia.js with Vue 3 for a seamless user experience and follows Laravel's best practices.

## Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [User Story](#User Story)
- [Configuration](#configuration)
- [Installation](#installation)
- [Usage](#usage)
- [Webhooks](#webhooks)
- [Testing Webhooks Locally](#testing-webhooks-locally)

## Features
- Simple checkout form .
- Integration with Lemon Squeezy API for processing payments.
- Webhook handling for payment notifications.
- Order management with status tracking.
- Modern UI with Tailwind CSS and Vue 3.

## Requirements

- PHP 8.3 or higher
- Laravel 11
- Node.js and npm
- Composer
- MySQL

## User Story
### 1. Create a Lemon Squeezy Account
Visit [Lemon Squeezy](https://www.lemonsqueezy.com) and sign up for an account.
- Complete the onboarding process by providing all necessary information about your store.

## Configuration

### 1. Lemon Squeezy API Key

- Navigate to your Lemon Squeezy dashboard.
- Go to **Settings** -> **API**.
- Click on **plus icon** to generate a new key for your integration.
- Save the API key securely, as you will need it to authenticate API requests.

### 2. Lemon Squeezy Store ID

- In your Lemon Squeezy dashboard, go to **Settings** -> **Stores**.
- You will see a list of your stores. The store ID is displayed as `#` followed by a big integer (e.g., `#yourstoreid`).
- Note this store ID, as it will be required for various API calls.

### 3. Lemon Squeezy Product Variant ID

- Go to the **Products** section in the Lemon Squeezy dashboard.
- Click **plus icon** and provide the necessary details, such as the course name, description, and pricing.
- Save the product to generate a unique Product ID.
- After saving, locate the product in the list, click the three dots at the end of the listed product, and select **Copy Variant ID**. You will need this ID when creating the product in your LMS.

### 4. Lemon Squeezy Webhook

#### Testing Webhooks Locally

To test webhooks locally, you can use Ngrok to expose your local server. If you're using Laravel Herd, follow these steps:

- Run Ngrok with the following command to expose your local environment:

  ```bash
  ngrok http --host-header=rewrite http://laravel-lemon-checkout.test/
  ```
If your Laravel application is running on port 8000, you can expose it using Ngrok with the following command:

  ```bash
  ngrok http 8000
  ```
- After setting up Ngrok and getting your public URL, go to your Lemon Squeezy dashboard and navigate to **Settings** -> **Webhooks**.
- Click on **plus icon**.
- In the **URL** field, enter the Ngrok URL followed by followed by `/lemonsqueezy/webhook`. For example, if your Ngrok URL 
- **Signing Secret:** In the **Signing Secret** field, enter a strong secret key. This secret is crucial as it will be used by your Laravel application to validate the authenticity of incoming webhook requests from Lemon Squeezy. Make sure to store this secret securely in your environment configuration (e.g., `.env` file).

- **Event Subscription:** Scroll down to the events section and subscribe to the `order_created` event. This event will trigger the webhook whenever a new order is created in your Lemon Squeezy store.

- Click **Save** to finalize the webhook setup.

## Installation

1. **Clone the repository:**

   ```bash
   git clone https://github.com/achrafbouhadou/laravel-lemon-checkout.git
   cd laravel-lemon-checkout
   ```
2. **Install dependencies**
    ```bash
    composer install
    npm install
    ```
3. **Set up your environment variables**
   Copy the .env.example file to .env and update the following variables:
   
    ```bash
    APP_NAME="Laravel Lemon Checkout"
    APP_URL=http://yourdomain.test
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=lemon_checkout
    DB_USERNAME=root
    DB_PASSWORD=yourpassword
    
    # Lemon Squeezy API configuration
    LEMON_SQUEEZY_API_KEY=your_lemon_squeezy_api_key
    LEMON_SQUEEZY_STORE_ID=your_store_id
    LEMON_SQUEEZY_WEBHOOK_SECRET=your_webhook_secret (Signing Secret)
    ```

### 3. Run Migration and Seed the Database

- Before seeding the database, open the `ProductSeeder.php` file located in the `database/seeders` directory of your Laravel application.

- Locate the line where the `lemonsqueezy_variant_id` is being set. Replace the placeholder value with the actual Product Variant ID that you generated earlier from Lemon Squeezy:
  
    ```bash
    php artisan migrate --seed
    ```
4. **Serve the application**
    ```bash
    php artisan serve
    npm run dev 
    ```


