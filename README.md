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
