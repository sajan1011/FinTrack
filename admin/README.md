# 💰 FinTrack – Simple Personal Finance Tracker

**FinTrack** is a beginner-friendly PHP + MySQL project that allows users to **track income, expenses, and savings** through a clean and responsive Tailwind CSS interface. Built using **procedural PHP** and ideal for students or newcomers to backend development.

---

## 🧰 Features

- ✅ Login System 
- 💸 Add Income
- 🧾 Add Expenses
- 📊 Real-time Savings Calculation
- 📋 Transaction Table
- ❌ Delete transactions
---

## 📸 Screenshots

### 📥 Login Page
![Login Screenshot](admin\upload\login.png)

### 🧾 Dashboard 
![Dashboard Screenshot](admin\upload\dashboard.png)

> ⚠️ Make sure these screenshot files are correctly placed inside the `admin/upload/` folder and committed to the repo.

---

## 🗄️ Database Structure (MySQL)

Import this into your MySQL using **phpMyAdmin** or CLI.

```sql
CREATE TABLE `income` (
  `id` int NOT NULL AUTO_INCREMENT,
  `source` varchar(100) NOT NULL,
  `amount` double NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

CREATE TABLE `expenses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category` varchar(100) NOT NULL,
  `amount` double NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
);

-- Sample login user (password->2444)
INSERT INTO `users` (`email`, `password`) VALUES
('sajan@gmail.com', '2444'); 
