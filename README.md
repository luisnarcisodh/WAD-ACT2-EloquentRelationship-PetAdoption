# PET ADOPTION & CARE SYSTEM

<img width="1066" height="531" alt="Screenshot 2026-04-04 012758" src="https://github.com/user-attachments/assets/2ba4435d-ca82-45ee-897e-1ea8926c9ba4" />


ERD
[Link here!](https://drive.google.com/file/d/1hcbljdBhpZIOWM_3IHU2548ahy1ccWSw/view?usp=sharing)


---

## Database Relationships Overview

| Relationship | Entities | Logic (Business Rule) | Laravel Method |
| :--- | :--- | :--- | :--- |
| **One-to-One (1:1)** | `Pet` ↔ `Vaccination` | A pet has one vaccination record. | `hasOne()` / `belongsTo()` |
| **One-to-Many (1:N)** | `User` ↔ `Adoption_Request` | A user can submit multiple adoption requests. | `hasMany()` / `belongsTo()` |
| **One-to-Many (1:N)** | `Pet` ↔ `Adoption_Request` | A pet can receive multiple adoption requests. | `hasMany()` / `belongsTo()` |
| **Many-to-Many (N:M)** | `Pet` ↔ `Vet` | A pet can be treated by multiple vets; a vet can treat multiple pets. | `belongsToMany()` |

---

## Tech Stack & Implementation

* **Framework:** Laravel 13 (Laravel Installer 5.25.1)
* **Language:** PHP 8.3
* **Database:** SQLite

# Pawsitive 🐾 - Pet Adoption System

## 📖 Description of the System
**Pawsitive** is a role-based web application built with Laravel that connects shelter pets with potential adopters. The system features two main roles: 
1. **Users (Adopters)** who can browse available pets and submit adoption requests.
2. **Administrators** who manage the pet catalog and review, approve, or reject adoption applications. 

The project demonstrates a secure, restricted environment where users are strictly limited to managing their own data, while admins have full control over the platform.

---

## ✨ List of Implemented Features

This system fully implements the required Laravel backend concepts:

### 1. Full CRUD Operations
* **Admin Capabilities:** Can **C**reate (add new pets), **R**ead (view pet list), **U**pdate (edit pet details), and **D**elete (remove pets) from the system.
* **User Capabilities:** Can **C**reate (submit adoption requests), **R**ead (view the catalog and their own requests), and **D**elete (cancel their own pending requests).

### 2. Authentication System
* Complete User Registration, Secure Login, and Logout functionality.
* Guests (unauthenticated visitors) are completely restricted and forced to log in before viewing the dashboard or pets.

### 3. Middleware (Security Guards)
* **`auth` Middleware:** Protects all internal routes from unauthorized access.
* **`IsAdmin` Custom Middleware:** Acts as a strict barrier. If a regular User tries to access an Admin URL (like `/pets/create` or `/adoptions/approve`), the middleware blocks them and throws an unauthorized error.

### 4. Authorization (Roles & Policies)
* Implemented strict permissions using Laravel Policies (`AdoptionRequestPolicy`).
* **Rule/Restriction:** User A can only view and cancel *their own* adoption requests. They cannot see, edit, or delete the adoption requests submitted by User B. 
* Admins automatically bypass these restrictions to manage everyone's requests.

### 5. Eloquent Database Relationships
* The database schema is fully connected using Laravel Eloquent:
  * **One-to-Many:** A `User` *hasMany* `AdoptionRequests`.
  * **One-to-Many:** A `Pet` *hasMany* `AdoptionRequests`.
  * **Inverse/BelongsTo:** Every `AdoptionRequest` *belongsTo* a specific `User` and a specific `Pet`.
  * Because of these relationships, the Admin can easily see exactly *who* requested *which* pet on their dashboard.