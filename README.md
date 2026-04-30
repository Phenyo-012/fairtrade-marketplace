<p align="center">
  <img src="public/images/FairTrade-Logo2.png" width="400">
</p>

# FairTrade – Secure Informal Trade Infrastructure

##  Project Overview

FairTrade is a **C2C (Consumer-to-Consumer) e-commerce marketplace** designed to provide **secure, structured digital infrastructure for informal traders** in South Africa.

The platform introduces **trust, accountability, and financial safety** into informal trade by combining:

- Escrow-based payments (buyer protection)
- Seller verification and compliance tracking
- Structured product moderation
- Delivery-linked transaction completion
- Review and reputation systems

It aims to replicate the reliability of platforms like Amazon while remaining accessible to **small-scale and informal sellers**.

---

##  Core Objectives

- Enable **secure peer-to-peer commerce**
- Reduce fraud in informal markets
- Provide **financial protection via escrow**
- Build **trust through ratings, reviews, and compliance**
- Lower barriers to entry for small businesses
- Support sustainable digital entrepreneurship

---

##  System Architecture

### Frontend
- Blade Templates (Laravel)
- Tailwind CSS (primary UI system)
- JavaScript (interactivity, UI logic)

### Backend
- Laravel (PHP Framework)
- MySQL Database
- Eloquent ORM

### Dev Tools
- Git & GitHub
- Laravel Artisan CLI
- Visual Studio Code

---

## System Roles

### 1. Buyer
- Browse marketplace
- Add to cart & checkout
- Track orders
- Leave verified reviews

### 2. Seller
- Manage store & products
- Track orders, revenue, and performance
- View analytics dashboard
- Monitor escrow earnings

### 3. Admin
- Moderate products and reviews
- Handle disputes
- Enforce platform compliance

---

##  Marketplace Features

### Product Discovery
- Search (name & description)
- Category filtering
- Price range filtering
- Condition filtering (new/used)
- Offer filters (free shipping, sale items)
- Sorting:
  - Price (low/high)
  - Top-rated
  - Recent

### Product Page
- Multi-image gallery (with thumbnails)
- Lightbox + zoom functionality
- Dynamic pricing (discount support)
- Stock display
- Seller profile card
- Related products
- Rating breakdown + review filters

---

##  Cart & Checkout

- Add/remove/update cart items
- Quantity validation (prevents exceeding stock)
- Cart badge indicator
- Checkout disabled when cart is empty
- Server-side validation for stock consistency

---

##  Reviews & Ratings System

### Rules
- Only **verified buyers** can review
- Order must be:
  - `delivered` OR `completed`
- One review per order item
- Duplicate reviews are blocked (UI + backend)

### Features
- Rating (1–5 stars)
- Optional comments
- Image uploads
- Helpful / Not Helpful voting
- Review moderation (`pending`, `approved`)

### Advanced
- Seller rating aggregation
- Rating distribution breakdown
- Filter reviews by rating
- Sort by:
  - Most helpful
  - Highest rating
  - Lowest rating

---

##  Escrow System (Critical Feature)

FairTrade uses a **delayed release escrow model**:

### Flow
1. Buyer places order → funds held in escrow
2. Seller ships product
3. Order delivered
4. Order marked `completed`
5. Funds released to seller

### Dashboard Tracking
Sellers can see:
- Total earnings
- Escrow balance (pending funds)
- Completed payouts

### Behavior
- Escrow updates dynamically with:
  - New orders
  - Status changes
- Prevents early withdrawal
- Protects buyers from fraud

---

##  Order Lifecycle

pending → awaiting_shipment → shipped → delivered → completed


### Shipping Logic

- `shipped_at` is recorded on shipment
- `seller_deadline` determines lateness

### Late Detection

- Before shipping:
  - Late status is calculated dynamically
- After shipping:
  - `is_late` becomes permanent (snapshot)

---

##  Seller Dashboard

### Metrics
- Total revenue
- Total orders
- Active products
- Average rating
- Total reviews

### Advanced Stats
- On-time shipment rate
- Late shipment count
- Top-performing products
- Low stock alerts

### Charts
- Revenue over time
- Orders over time

---

##  Additional Seller Metrics

- Conversion indicator *(planned / partial)*
- Active discounts
- Pending orders count

---

##  Product Management

### Features
- Create/edit products
- Multi-image upload (max 5)
- Stock tracking
- Sale pricing support

---

##  Product Deletion Protection (Critical Fix)

Products **cannot be deleted** if they are linked to historical data:

- Orders
- Reviews
- Order items

### Why?
To preserve:
- Financial records
- Review integrity
- Marketplace analytics

---

##  Product Archiving System

Instead of deletion, products can be **archived**.

### Archived Products:
- Removed from marketplace
- Cannot be purchased
- Still exist in database
- Still linked to orders & reviews

### Seller Capabilities:
- Archive product
- Restore product

### UI Behavior:
- Archived badge displayed
- Reduced opacity (visual indicator)

---

##  Security & Authorization

### Role-Based Access Control

- Sellers can only manage **their own products/orders**
- Buyers can only review **their own purchases**
- Admins control moderation

### Data Integrity
- Foreign keys protected
- Historical records preserved
- Soft-dependency handling for deleted products

---

##  Smart System Behaviors

- Prevent adding more items than available stock
- Prevent checkout with empty cart
- Prevent reviewing before delivery
- Prevent duplicate reviews
- Dynamic late shipment detection
- Escrow auto-adjustment

---

##  Background Processing

### Scheduler Tasks

- Auto-complete orders
- Mark late shipments
- Maintain system consistency

##  UI/UX Features

- Responsive design  
- Modern card-based marketplace layout  
- Image carousel with auto-play + swipe  
- Lightbox viewing  
- Dynamic badges (sale, archived, etc.)  
- Clean dashboard analytics  

---

## Current Status

**Phase:** UI Enhancement & Mobile Optimization  

###  Completed:
- Core marketplace  
- Seller dashboard 
- Admin dashboard 
- Escrow logic  
- Review system  
- Product archiving  
- Order lifecycle  
- Dispute resolution system
- Seller performance scoring  
- Conversion tracking 
- Contact Support
- Courier Support (SIMULATED)
- Payment Support (SIMULATED)
- Buyer dashboard

###  In Progress:
- Mobile device Optimization
- UI refinements  

###  Planned:
- Beta Deployment
- Use Case Testing

---

##  Summary

FairTrade transforms informal trade into a **structured, secure, and scalable digital marketplace** by combining:

- Financial safeguards (escrow)  
- Trust systems (reviews & ratings)  
- Operational control (order lifecycle)  
- Data integrity (no destructive deletes)  