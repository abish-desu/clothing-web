# Project Structure

This project is a basic PHP + MySQL clothing store with a separate admin area.

The goal of this document is to help you quickly understand:

- where the active code lives
- which files are part of the current app flow
- which folders are support/legacy content
- how to navigate the project safely

---

## Top-Level Structure

```/dev/null/project-structure.txt#L1-12
clothing-web/
├── admin/
├── css/
├── database/
├── docs/
├── images/
├── legacy/
├── pages/
├── PROJECT/
├── scripts/
└── index.php
```

---

## Main Entry Point

### `index.php`
Root entry point for the project.

- redirects to the user-facing app
- current target: `pages/home.php`

---

## Active User-Facing Application

All active user/customer pages are inside:

```/dev/null/pages-dir.txt#L1-1
pages/
```

### Key user pages

#### Auth
- `pages/login.html`  
  User login form
- `pages/login_process.php`  
  User login handler
- `pages/signup.html`  
  User registration form
- `pages/user_register.php`  
  User registration handler
- `pages/logout.php`  
  User logout

#### Storefront
- `pages/home.php`  
  Main landing page
- `pages/shop.php`  
  Product browsing page
- `pages/product_view.php`  
  Product details page
- `pages/contact.php`  
  Contact page
- `pages/contact-submit.php`  
  Contact form submit handler

#### Cart and orders
- `pages/manage_cart.php`  
  Add/remove/update cart items
- `pages/mycart.php`  
  Cart page
- `pages/checkout.php`  
  Checkout form
- `pages/place_order.php`  
  Order creation handler
- `pages/payment.php`  
  Post-order confirmation
- `pages/customer_order.php`  
  User order list
- `pages/customer_order_detail.php`  
  User order details

#### Product/data helpers
- `pages/connect.php`  
  Database connection bootstrap
- `pages/cart_store.php`  
  User-specific cart helper
- `pages/featured.php`  
  Featured product query helper
- `pages/new_arrival.php`  
  New arrival query helper
- `pages/summer_wear.php`  
  Summer wear query helper
- `pages/trendy_products.php`  
  Trendy product query helper
- `pages/all_products.php`  
  All products query helper
- `pages/get_products.php`  
  Product query helper used by some pages

#### Shared assets in `pages/`
- `pages/styleee.css`
- `pages/shop_style.css`
- `pages/style.css`
- `pages/signstyle.css`
- `pages/main.js`
- `pages/js/`
- `pages/css/`
- `pages/footer.html`

---

## Active Admin Application

All admin pages are inside:

```/dev/null/admin-dir.txt#L1-1
admin/
```

### Key admin pages

#### Auth/admin session
- `admin/login.php`  
  Admin login page
- `admin/logout.php`  
  Admin logout page
- `admin/index.php`  
  Admin dashboard

#### Product management
- `admin/products.php`  
  Product list
- `admin/add_products.php`  
  Add product form
- `admin/edit.php`  
  Edit product page

#### Order management
- `admin/customer_orders.php`  
  All orders list
- `admin/order_details.php`  
  View ordered items/details for an order

#### Admin action handlers
These were organized into a dedicated folder:

```/dev/null/admin-actions.txt#L1-3
admin/actions/
├── create_products.php
└── delete_product.php
```

These files handle:
- product creation
- product deletion

#### Admin templates
Shared admin layout files are inside:

```/dev/null/admin-templates.txt#L1-5
admin/templates/
├── top.php
├── navbar.php
├── sidebar.php
└── footer.php
```

#### Admin assets
- `admin/css/`
- `admin/js/`

---

## Database

Database-related files are in:

```/dev/null/database-dir.txt#L1-1
database/
```

### Important file
- `database/schema.sql`

This file contains:
- database creation
- tables
- seed data
- demo user/admin data
- product seed data

---

## Scripts

Project startup scripts are in:

```/dev/null/scripts-dir.txt#L1-3
scripts/
├── start_mysql.sh
└── start_app.sh
```

### Purpose
- `start_mysql.sh`
  - starts the private MySQL instance on port `3307`
- `start_app.sh`
  - starts the PHP application on port `8000`

---

## Images

### Main image storage
```/dev/null/images-main.txt#L1-1
images/
```

This is the main product/site image source folder.

### Compatibility copy
```/dev/null/images-project.txt#L1-1
PROJECT/images/
```

This exists so older absolute image paths like `/PROJECT/images/...` continue to work.

### Important note
- the database stores image names/paths
- the actual files live in `images/` and `PROJECT/images/`

---

## Legacy / Archived Files

Unused or older files were moved into:

```/dev/null/legacy-dir.txt#L1-3
legacy/
├── admin/
└── pages/
```

These are kept only for reference and should not be treated as part of the active app.

### Examples of archived legacy files
#### `legacy/pages/`
- `add_to_cart.php`
- `login-submit.php`
- `login_success.html`
- `orderdetail.php`
- `trymycart.php`

#### `legacy/admin/`
- `edit_product.php`
- `header.php`
- `logged_in.php`
- `nav.php`

---

## Recommended Navigation Order

If you are new to the project, read files in this order.

### User flow
1. `index.php`
2. `pages/home.php`
3. `pages/shop.php`
4. `pages/product_view.php`
5. `pages/manage_cart.php`
6. `pages/mycart.php`
7. `pages/checkout.php`
8. `pages/place_order.php`
9. `pages/payment.php`
10. `pages/customer_order.php`
11. `pages/customer_order_detail.php`

### User auth flow
1. `pages/login.html`
2. `pages/login_process.php`
3. `pages/signup.html`
4. `pages/user_register.php`
5. `pages/logout.php`

### Admin flow
1. `admin/login.php`
2. `admin/index.php`
3. `admin/products.php`
4. `admin/add_products.php`
5. `admin/edit.php`
6. `admin/actions/create_products.php`
7. `admin/actions/delete_product.php`
8. `admin/customer_orders.php`
9. `admin/order_details.php`

### Data layer
1. `pages/connect.php`
2. `database/schema.sql`
3. product query helpers in `pages/`

---

## Which Files You Should Edit First

### For store UI changes
Edit:
- `pages/home.php`
- `pages/shop.php`
- `pages/styleee.css`
- `pages/shop_style.css`

### For cart behavior
Edit:
- `pages/manage_cart.php`
- `pages/mycart.php`
- `pages/cart_store.php`

### For order behavior
Edit:
- `pages/checkout.php`
- `pages/place_order.php`
- `pages/customer_order.php`
- `pages/customer_order_detail.php`
- `admin/customer_orders.php`
- `admin/order_details.php`

### For auth/session behavior
Edit:
- `pages/login_process.php`
- `pages/user_register.php`
- `pages/logout.php`
- `admin/login.php`
- `admin/logout.php`

### For DB schema/data
Edit:
- `database/schema.sql`

---

## Run Guide

After cloning the project, the normal run flow is:

```/dev/null/run-guide.txt#L1-4
cd clothing-web
sh scripts/start_mysql.sh
mysql -h 127.0.0.1 -P 3307 -uroot < database/schema.sql
sh scripts/start_app.sh
```

Then open:

```/dev/null/run-url.txt#L1-1
http://127.0.0.1:8000/
```

---

## Demo Credentials

### User
- Email: `user@example.com`
- Password: `User@123`

### Admin
- Email: `admin@gmail.com`
- Password: `admin@12`

Admin URL:

```/dev/null/admin-url.txt#L1-1
http://127.0.0.1:8000/admin/login.php
```

---

## Maintenance Notes

### Active code should stay in:
- `pages/`
- `admin/`
- `admin/actions/`
- `admin/templates/`
- `database/`
- `scripts/`

### Avoid placing new active files in:
- `legacy/`

### Good future improvements
If you want even better structure later, you can split further into:
- `pages/auth/`
- `pages/orders/`
- `pages/shop/`
- `pages/partials/`
- `pages/helpers/`

But for this project’s current size, the present structure is already much easier to navigate and maintain.

---

## Summary

Use these folders as the main guide:

```/dev/null/summary.txt#L1-8
pages/           -> customer-facing app
admin/           -> admin-facing pages
admin/actions/   -> admin form handlers
admin/templates/ -> admin shared layout
database/        -> schema and seed data
scripts/         -> startup commands
images/          -> actual image assets
legacy/          -> archived unused files
```
