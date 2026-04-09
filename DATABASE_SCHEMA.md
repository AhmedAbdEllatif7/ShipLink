# ShipLink - Database Schema Design

## Overview
This document outlines the final database structure for the ShipLink logistics system, designed for high performance, scalability, and clean data relationships.

---

## 📊 Tables & Structure

### 1. `users` (Core Profiles)
Stores authentication and shared profile data for all roles.
- `id` (PK)
- `name` (string)
- `email` (string, UNIQUE)
- `password` (string)
- `phone` (string, INDEX) - Shared for all roles.
- `address` (text) - Default address for the user.
- `type` (enum: `admin`, `merchant`, `driver`, INDEX) - For fast filtering.
- `created_at`, `updated_at`

### 2. `merchants` (Merchant Metadata)
- `id` (PK)
- `user_id` (FK -> users.id, UNIQUE)
- `company_name` (string)
- `created_at`, `updated_at`

### 3. `drivers` (Driver Metadata)
- `id` (PK)
- `user_id` (FK -> users.id, UNIQUE)
- `vehicle_type` (enum: `car`, `bike`, `truck`)
- `is_available` (boolean, INDEX, default: `true`)
- `created_at`, `updated_at`

---

### 4. `shipments` (Logistics Core)
- `id` (PK)
- `tracking_number` (string, UNIQUE, INDEX)
- `merchant_id` (FK -> merchants.id, INDEX)
- `driver_id` (FK -> drivers.id, INDEX, NULLABLE)
- `status` (enum, INDEX) - `pending`, `assigned`, `picked_up`, `in_transit`, `delivered`, `failed`
- `receiver_name` (string)
- `receiver_phone` (string, INDEX)
- `receiver_address` (text)
- `city` (string, INDEX) - For filtering and shipping rates.
- `cod_amount` (decimal, 10,2) - Amount to collect from customer.
- `assigned_at` (timestamp, NULLABLE)
- `delivered_at` (timestamp, NULLABLE)
- `created_at`, `updated_at`

### 5. `shipment_status_histories` (Audit Trail)
- `id` (PK)
- `shipment_id` (FK -> shipments.id, INDEX)
- `status` (string) - The new status.
- `changed_by` (FK -> users.id) - The user who performed the action.
- `notes` (text, NULLABLE)
- `created_at`

---

### 6. `wallets` (Financials)
- `id` (PK)
- `merchant_id` (FK -> merchants.id, UNIQUE)
- `balance` (decimal, 15,2, default: 0.00)
- `updated_at`

### 7. `wallet_transactions` (Ledger)
- `id` (PK)
- `wallet_id` (FK -> wallets.id, INDEX)
- `amount` (decimal, 15,2)
- `type` (enum: `credit`, `debit`)
- `reference_id` (unsignedBigInt, NULLABLE) - Link to Shipment or Withdrawal.
- `description` (string)
- `created_at`

### 8. `withdrawal_requests` (Cash Out)
- `id` (PK)
- `merchant_id` (FK -> merchants.id, INDEX)
- `amount` (decimal, 15,2)
- `status` (enum: `pending`, `approved`, `rejected`, INDEX)
- `admin_notes` (text, NULLABLE)
- `created_at`, `updated_at`

---

### 9. `notifications` (System Notifications)
*We will use Laravel's default notification system, but for clarity, it will store:*
- `id` (UUID)
- `type` (string) - The notification class.
- `notifiable_type` (string) - Always `App\Models\User`.
- `notifiable_id` (FK -> users.id)
- `data` (JSON) - Contains the message, action link, and shipment details.
- `read_at` (timestamp, NULLABLE, INDEX)
- `created_at`

---

## 🔗 Relationships Summary

- **Users & Roles**:
  - `User` hasOne `Merchant`
  - `User` hasOne `Driver`
- **Merchant Workflow**:
  - `Merchant` hasMany `Shipment`
  - `Merchant` hasOne `Wallet`
  - `Merchant` hasMany `WithdrawalRequest`
- **Driver Workflow**:
  - `Driver` hasMany `Shipment`
- **Shipment Tracking**:
  - `Shipment` hasMany `ShipmentStatusHistory`
- **Financials**:
  - `Wallet` hasMany `WalletTransaction`
- **Engagement**:
  - `User` hasMany `Notifications`

---

## ⚡ Key Indexes for Performance
1. `shipments(tracking_number)`: Essential for all tracking lookups.
2. `shipments(status, city)`: Frequently used combined filter.
3. `users(type)`: Used for internal logic and role-based counts.
4. `shipments(merchant_id)`: For merchant dashboard views.
5. `shipments(driver_id, status)`: For driver todo-list efficiency.
