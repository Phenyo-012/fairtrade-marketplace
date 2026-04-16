<p align="center">
  <img src="public/images/FairTrade-Logo2.png" width="400">
</p>

# FairTrade – Secure Informal Trade Infrastructure
## Project Overview

FairTrade is a C2C (Consumer-to-Consumer) e-commerce marketplace designed to provide secure and structured digital infrastructure for informal traders in South Africa.

The platform bridges the gap between informal trade and formal e-commerce systems by providing:

- Identity verification for sellers

- Escrow-based payment processing

- Courier-based delivery confirmation

- Seller compliance monitoring

- Product moderation before listing

- Structured dispute resolution

## Core Objectives

- Enable secure C2C transactions

- Reduce fraud in informal trade

- Lower entry barriers for small sellers

- Provide structured digital trust mechanisms

- Support sustainable informal entrepreneurship

## Technology Stack

### Frontend:

- HTML

- Bootstrap

- CSS

- JavaScript

### Backend:

- Laravel (PHP Framework)

- MySQL Database

### Version Control:

Git + GitHub

## System Interfaces

The platform consists of three primary interfaces:

1. Buyer Interface

2. Seller Interface (with Store Management)

3. Admin Interface (Moderation & Compliance)

## Features
### General

- User authentication (buyer, seller, admin roles)

- Responsive navigation with role-based links

- Modern UI built with Tailwind CSS

- Dashboard overview for sellers and buyers

- Role-based permissions

### Seller Features

- Seller dashboard with:

    - Total revenue, orders, products listed, average ratings

    - Revenue and orders charts

    - Recent orders and reviews

    - Low-stock alerts

- Multi-image product upload (max 5 images per product)

- Products displayed as cards with standardized image sizes

- Full product management (add/edit/delete)

#### Deadline Handling

- Before shipment:

  - The system dynamically checks if the current time exceeds `seller_deadline`

- After shipment:

  - Deadline evaluation is no longer active
  
  - `is_late` becomes a stored snapshot value

### Marketplace

- Product browsing with:

    - Search

    - Category & condition filters

- Product pages with:

    - Multi-image gallery with thumbnails

    - Amazon-style image zoom & lightbox

    - “Add to cart” button with quantity selector

    - Related products section

- Clean and responsive layout

### Cart & Checkout

- Add products to cart

- Update quantity or remove items

- View total price

- Cart badge in the navigation menu showing total items

### Reviews

- Buyers can leave a review only if:

  - They are the order owner

  - The order status is `delivered` or `completed`

  - A review has not already been submitted

- Reviews are restricted to one per order

### Admin Features

- Admin dashboard

- Manage products, disputes, and user roles

### Authorization Rules

- Sellers can only manage orders that include their products

- Buyers can only review their own orders

- Duplicate reviews are prevented at both UI and backend levels

## Order Lifecycle

Orders follow this status flow:

- pending → awaiting_shipment → shipped → delivered → completed

### Shipping Rules

- When an order is marked as `shipped`:

  - `shipped_at` is recorded

  - `is_late` is calculated and stored

  - Deadline tracking stops affecting the order afterward

- After shipment:

  - Late status is frozen and no longer recalculated

## Status

Project Phase: UI Design and Backend Optimization

