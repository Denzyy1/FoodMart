# 🛒 FoodMart – Online Grocery Shopping Platform

**FoodMart** is a web-based online grocery shopping application built with **Laravel**. It provides customers with a convenient and user-friendly shopping experience, allowing them to browse grocery products, explore categories, manage their shopping carts, and place orders online.

The platform aims to simplify grocery shopping through an intuitive interface and an organized shopping experience.

---

## ✨ Features

- **Product Management** – Browse and explore available grocery products.
- **Category Management** – Navigate products through organized categories.
- **Shopping Cart** – Add, remove, and manage products in your cart.
- **Search Functionality** – Find products quickly and easily.
- **Order Management** – Place and manage grocery orders.
- **User Authentication** – Secure registration and login functionality.
- **Responsive Design** – Accessible across different screen sizes.
- **Admin Dashboard** – Manage products, categories, and orders.

---

## 🛠️ Technologies Used

| Technology | Purpose |
|---|---|
| PHP | Backend Programming |
| Laravel | Backend Framework |
| MySQL | Database Management |
| HTML5 | Page Structure |
| CSS3 | Styling |
| JavaScript | Frontend Interactivity |
| Bootstrap | Responsive UI |

---

## 📸 Screenshots

Add screenshots of your application here to showcase its interface.


---

## ⚙️ Installation & Setup

Follow these steps to run FoodMart locally.

### 1. Clone the Repository

```bash
git clone YOUR_REPOSITORY_URL
```

### 2. Navigate to the Project Directory

```bash
cd foodmart
```

### 3. Install Dependencies

```bash
composer install
```

### 4. Configure Environment Variables

Create your environment file:

```bash
cp .env.example .env
```

Update your database configuration inside `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=foodmart
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Run Database Migrations

```bash
php artisan migrate
```

If the project includes database seeders:

```bash
php artisan db:seed
```

### 7. Install Frontend Dependencies

```bash
npm install
npm run build
```

### 8. Start the Development Server

```bash
php artisan serve
```

Open your browser and visit:

`http://127.0.0.1:8000`

---



## 🔐 Security

- Environment variables are used to manage sensitive configuration.
- Authentication protects restricted application areas.
- Laravel's built-in security features help protect application data.

---

## 🚀 Future Improvements

- Online payment gateway integration.
- Order tracking and delivery management.
- Product reviews and ratings.
- Wishlist functionality.
- Advanced product filtering.
- Customer notifications.

---

## 👨‍💻 Developer

**Developed by: Karim (Denzy)**

---

## 📄 License

This project is available for educational and development purposes. Licensing
