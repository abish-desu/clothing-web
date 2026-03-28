# Royal Butterfly — Clothing E-Commerce

A PHP-based clothing store with a customer-facing storefront and a separate admin panel.

---

## Quick Start

1. Start a local PHP + MySQL server (e.g. XAMPP or WAMP)
2. Import the database: `database/schema.sql`
3. Update the DB credentials in `pages/connect.php`
4. Visit `http://localhost/clothing-web/` in your browser

---

## Folder Structure

```
clothing-web/
│
├── index.php                  # Entry point — redirects to pages/home.php
│
├── pages/                     # ── Customer-facing site ──────────────────
│   │
│   ├── connect.php            # Database connection (edit credentials here)
│   │
│   │── ── Pages ─────────────────────────────────────────────────────────
│   ├── home.php               # Homepage with featured products
│   ├── shop.php               # Full product listing
│   ├── product_view.php       # Single product detail page
│   ├── contact.php            # Contact page
│   ├── contact-submit.php     # Handles contact form submission
│   ├── profile.php            # Logged-in user profile
│   │
│   ├── login.html             # Login form
│   ├── login_process.php      # Handles login form submission
│   ├── logout.php             # Logs the user out
│   ├── signup.html            # Sign-up form
│   ├── signup-success.html    # Shown after successful registration
│   ├── user_register.php      # Handles sign-up form submission
│   │
│   ├── mycart.php             # Shopping cart page
│   ├── manage_cart.php        # Add / remove / update cart items
│   ├── checkout.php           # Checkout form
│   ├── place_order.php        # Saves order to database
│   ├── payment.php            # Payment confirmation page
│   │
│   ├── customer_order.php     # Customer's order history list
│   ├── customer_order_detail.php  # Detail view for a single order
│   │
│   │── ── Product Data Helpers ───────────────────────────────────────────
│   ├── featured.php           # Queries featured / spring-collection products
│   ├── new_arrival.php        # Queries new-arrival products
│   ├── summer_wear.php        # Queries summer-wear products
│   ├── trendy_products.php    # Queries trendy-dress products
│   ├── all_products.php       # Queries all products (used by shop.php)
│   ├── get_products.php       # Generic product query helper
│   │
│   │── ── Stylesheets ────────────────────────────────────────────────────
│   ├── styleee.css            # Main stylesheet (home, cart, checkout, orders)
│   ├── shop_style.css         # Stylesheet for shop and contact pages
│   ├── style.css              # Stylesheet for login and signup pages
│   │
│   └── footer.html            # Shared HTML footer included by home.php
│
├── admin/                     # ── Admin panel ────────────────────────────
│   │
│   ├── login.php              # Admin login page
│   ├── logout.php             # Admin logout
│   ├── index.php              # Admin dashboard (overview + quick links)
│   ├── products.php           # List all products
│   ├── add_products.php       # Form to add a new product
│   ├── edit.php               # Form to edit an existing product
│   ├── customer_orders.php    # List all customer orders
│   ├── order_details.php      # Detail view for a single order
│   │
│   ├── actions/               # Form action handlers (POST targets)
│   │   ├── create_products.php    # Saves a new product to the database
│   │   └── delete_product.php     # Deletes a product from the database
│   │
│   ├── templates/             # Shared layout pieces included on every page
│   │   ├── top.php            # <head> tag, CSS links, opens <body>
│   │   ├── navbar.php         # Top navigation bar
│   │   ├── sidebar.php        # Left sidebar + opens main content area
│   │   └── footer.php         # Closes body, loads Chart.js + dashboard.js
│   │
│   ├── css/
│   │   └── dashboard.css      # Admin panel stylesheet (no Bootstrap)
│   │
│   └── js/
│       └── dashboard.js       # Admin chart (vanilla JS, no jQuery)
│
├── images/                    # Product and UI images (used by pages/ via ../images/)
├── PROJECT/images/            # Same images (used via /PROJECT/images/ absolute paths)
│
├── database/
│   └── schema.sql             # SQL to create all tables from scratch
│
├── scripts/                   # Developer helper scripts
│   ├── setup_db.sh            # Creates the database and imports schema
│   ├── start_app.sh           # Starts the PHP dev server
│   └── start_mysql.sh         # Starts MySQL if not already running
│
└── README.md                  # This file
```

---

## Key Files to Know First

| File | Why it matters |
|---|---|
| `pages/connect.php` | DB credentials — update this before anything works |
| `database/schema.sql` | Run this once to create all tables |
| `pages/home.php` | Start of the customer site |
| `admin/login.php` | Start of the admin panel |
| `pages/styleee.css` | Main CSS for the customer site |
| `admin/css/dashboard.css` | All CSS for the admin panel |

---

## Admin Login

Default credentials are set directly in `admin/login.php`:

```php
$adminEmail    = "admin@gmail.com";
$adminPassword = "admin@12";
```

Change these before deploying.

---

## Database Tables

| Table | Purpose |
|---|---|
| `all_products` | Product catalogue (name, category, price, image) |
| `orders` | Customer orders (name, phone, address, total, status) |
| `order_items` | Individual items inside each order |
| `users` | Registered customer accounts |

---

## Tech Stack

- **Backend:** PHP (no framework)
- **Database:** MySQL / MariaDB
- **Frontend:** HTML, CSS (custom, no Bootstrap), vanilla JavaScript
- **Icons:** Font Awesome 5
- **Charts:** Chart.js (admin dashboard only)