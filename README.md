# 🚀 ShipLink - Professional Logistics & Delivery Management System

**ShipLink** is a robust, scalable, and modern logistics management system built with **Laravel 12**. Designed to streamline the shipping process for merchants and drivers, it provides a secure and efficient platform for managing deliveries, tracking packages, and ensuring seamless communication across all logistics roles.

---

## ✨ Key Features

-   **🔐 Multi-Auth Verification (OTP)**: Enhanced security with a custom 6-digit Email Verification system (OTP) to ensure verified account activation.
-   **🏢 Role-Based Access Control**:
    -   **Admin**: Full system management and auditing.
    -   **Merchant**: Manage shipments, track orders, and view delivery statistics.
    -   **Driver**: Real-time delivery management and status updates.
-   **📦 Shipment Lifecycle**: Professional tracking from pickup to delivery.
-   **🎨 Premium UI/UX**: Crafted with a focus on aesthetics using Tailwind CSS for a professional, branded experience.
-   **⚙️ Service-Oriented Architecture**: Decoupled logic using the Service Pattern for high maintainability and scalability.
-   **📧 Real-time Notifications**: Integrated email notification system with branded templates.

---

## 🛠️ Tech Stack

-   **Framework**: [Laravel 12](https://laravel.com)
-   **Language**: PHP 8.2+
-   **Frontend**: Tailwind CSS & Vite
-   **Database**: MySQL
-   **Authentication**: Custom OTP-based Email Verification
-   **Mailing**: SMTP Integration (Mailtrap for development)

---

## 🚀 Getting Started

### Prerequisites

-   PHP 8.2+
-   Composer
-   Node.js & NPM
-   MySQL

### Installation

1.  **Clone the repository**:
    ```bash
    git clone https://github.com/AhmedAbdEllatif7/ShipLink.git
    cd ShipLink
    ```

2.  **Install dependencies**:
    ```bash
    composer install
    npm install
    ```

3.  **Environment Setup**:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Database Configuration**:
    Configure your `.env` file with your database credentials.

5.  **Run Migrations**:
    ```bash
    php artisan migrate
    ```

6.  **Start Development Server**:
    ```bash
    php artisan serve
    npm run dev
    ```

---

## 🏗️ Architecture Overview

The project follows the **Service-Oriented Architecture (SOA)** pattern to ensure that the business logic is decoupled from the controllers. This makes the codebase:
-   **Testable**: Services can be unit-tested independently.
-   **Scalable**: Logic can be reused across different parts of the application (APIs, CLI, Web).
-   **Clean**: Controllers remain thin and focused on handling requests and responses.

---

## 🔒 Security

We prioritize security through:
-   **Hashed Passwords**: Using Argon2/Bcrypt.
-   **Email Verification**: Forced OTP verification on all protected routes.
-   **Protection**: CSRF, SQL Injection, and XSS protection built into the core.

---

## 🤝 Contributing

Contributions are what make the open-source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📄 License

Distributed under the MIT License. See `LICENSE` for more information.

---

<p align="center">
  Made with ❤️ by <b>Ahmed Abd Ellatif</b>
</p>
