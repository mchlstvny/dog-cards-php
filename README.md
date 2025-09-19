# Dog Cards PHP Project 🐶

A simple PHP project for managing **Dog Cards** with a database connection.  
This project uses **Composer** for dependency management and **dotenv** for environment variables.

---

## 📌 Features
- Manage dog data (name, age, breed, color, weight, image).
- Store data in a MySQL database.
- Use `.env` file for configuration (DB credentials, app settings), the format is in `.env.example`
- Organized using Composer.

---

## 📂 Project Structure
```
dog-cards-php/
├── src/                # Source code
├── vendor/             # Composer dependencies
├── .env                # Environment variables (ignored by Git)
├── .env.example        # Example env file (shared in repo)
├── composer.json       # Composer configuration
├── composer.lock       # Composer lock file
└── README.md           # Project documentation
```

---

## ⚙️ Installation

1. **Clone the repository**
   ```
   git clone https://github.com/michelestevany/dog-cards-php.git
   cd dog-cards-php
   ```
2. **Install dependencies**
   ```
   composer install
   ```
4. **Set up your environment file**
Copy `.env.example` to `.env:`

---

## Database Setup
MySQL file is sent on E-Learn (dog_db)
