# 🍽️ Meal Ordering System

![Laravel](https://img.shields.io/badge/Laravel-12-red?style=flat&logo=laravel) 
![FilamentPHP](https://img.shields.io/badge/Filament-3-blueviolet?style=flat&logo=laravel)
![License](https://img.shields.io/github/license/mahbub14/Meal-Ordering-System)
![Status](https://img.shields.io/badge/status-active-success)

A feature-rich **Multi-User Meal Ordering System** built with **Laravel 12** and **FilamentPHP v3**.  
Designed for **canteens, hostels, office kitchens**, and **restaurant chains** to manage meals, menus, and customer orders with ease.

📂 **Repository**: [https://github.com/mahbub14/Meal-Ordering-System](https://github.com/mahbub14/Meal-Ordering-System)

---

## ✨ Features

🔹 Filament 3 Admin Panel  
🍛 Meal Category & Item Management  
🗓️ Dynamic Daily Meal Menu  
🛒 Order Placement & Status Update  
📦 Meal Statuses: Pending, Preparing, Delivered  
📊 Filament Widgets: Today's Orders, Earnings  
👥 Multi-role Access (Admin, Kitchen Staff, Customer)  
🖼️ Custom Filament Icons (SVG-based)  
📱 Responsive Design (TailwindCSS)

---

## 👥 User Roles & Access

| Role          | Permissions                            |
|---------------|----------------------------------------|
| 👑 Admin       | Manage everything (CRUD, Users, Orders) |
| 👨‍🍳 Kitchen    | View & update order statuses            |
| 🙋 Customer     | Browse menu & place meal orders        |

---

## ⚙️ Tech Stack

| Layer        | Tools/Frameworks         |
|--------------|--------------------------|
| Backend      | Laravel 12               |
| UI & Admin   | FilamentPHP 3 + Tailwind |
| Database     | MySQL                    |
| Icons        | Custom SVG Icons         |
| Auth         | Laravel Breeze           |
| Deployment   | Localhost / cPanel       |

---

## 🧪 Screenshots

> Add screenshots under `public/screenshots/` folder (already linked here)


|![Dashboard](https://github.com/user-attachments/assets/682b6fba-f9c5-4838-815f-0aac55506e08) |
![Orders](https://github.com/user-attachments/assets/195b497d-2c7a-4816-89b0-155cdf0891c9) |
![Meals](https://github.com/user-attachments/assets/ccbbec0a-a0d0-4bbf-9081-8246cfcdcefb) |
![Kitchen](https://github.com/user-attachments/assets/a208a873-f7c6-4304-9e44-edef4b4537b6) |
| ![Stats](https://github.com/user-attachments/assets/b3422848-e95a-48c9-b20e-17e567e06853) |
![Add Meal](https://github.com/user-attachments/assets/b72f393e-e6e6-4bbe-b805-94b3cd6cb2bc) |
![Icons](https://github.com/user-attachments/assets/77b344a4-39f4-47f0-8b19-a744046abf4c) |

---

## 🚀 Installation Guide

To run this project locally, follow the steps below:

```bash
# 1. Clone the Repository
git clone https://github.com/mahbub14/Meal-Ordering-System.git
cd Meal-Ordering-System

# 2. Install Backend Dependencies
composer install

# 3. Install Frontend Dependencies
npm install && npm run build

# 4. Environment Setup
cp .env.example .env
php artisan key:generate

# 5. Run Database Migration & Seeders
php artisan migrate --seed

# 6. Serve the Application
php artisan serve
