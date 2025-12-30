# 🔌 API Documentation - Lekker Ordering System

Base URL: `http://localhost:8000/api`

All API endpoints require authentication using Laravel Sanctum.

## Authentication

Include the following header in all requests:

```
Authorization: Bearer {token}
X-CSRF-TOKEN: {csrf_token}
```

For session-based auth (web), CSRF token is automatically handled.

---

## Products

### Get All Products

**Endpoint:** `GET /api/products`

**Description:** Retrieve all available products

**Response:**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Nasi Goreng Spesial",
            "description": "Nasi goreng dengan ayam, telur, dan sayuran segar",
            "price": "25000.00",
            "image_url": "http://localhost:8000/storage/products/sample-1.jpg",
            "is_available": true
        },
        {
            "id": 2,
            "name": "Mie Ayam Bakso",
            "description": "Mie ayam dengan bakso sapi dan pangsit goreng",
            "price": "20000.00",
            "image_url": "http://localhost:8000/storage/products/sample-2.jpg",
            "is_available": true
        }
    ]
}
```

**Status Codes:**

-   `200 OK` - Success

---

## Cart

### Add to Cart

**Endpoint:** `POST /api/cart/add`

**Description:** Add a product to the cart

**Request Body:**

```json
{
    "product_id": 1,
    "quantity": 2
}
```

**Validation Rules:**

-   `product_id`: required, must exist in products table
-   `quantity`: required, integer, minimum 1

**Response Success:**

```json
{
    "success": true,
    "message": "Produk ditambahkan ke keranjang.",
    "cart_count": 5
}
```

**Response Error (Product Not Available):**

```json
{
    "success": false,
    "message": "Produk tidak tersedia."
}
```

**Status Codes:**

-   `200 OK` - Success
-   `400 Bad Request` - Product not available
-   `422 Unprocessable Entity` - Validation error

---

### Update Cart

**Endpoint:** `POST /api/cart/update`

**Description:** Update quantity of a product in cart

**Request Body:**

```json
{
    "product_id": 1,
    "quantity": 3
}
```

**Note:** Set `quantity` to `0` to remove the item from cart

**Validation Rules:**

-   `product_id`: required, must exist in products table
-   `quantity`: required, integer, minimum 0

**Response:**

```json
{
    "success": true,
    "message": "Keranjang diperbarui.",
    "total": "75000",
    "cart_count": 3
}
```

**Status Codes:**

-   `200 OK` - Success
-   `422 Unprocessable Entity` - Validation error

---

### Remove from Cart

**Endpoint:** `POST /api/cart/remove`

**Description:** Remove a product from cart

**Request Body:**

```json
{
    "product_id": 1
}
```

**Response:**

```json
{
    "success": true,
    "message": "Item dihapus dari keranjang."
}
```

**Status Codes:**

-   `200 OK` - Success

---

## Orders

### Create Order

**Endpoint:** `POST /api/orders`

**Description:** Create a new order from cart items

**Request Body:**

```json
{
    "customer_name": "John Doe",
    "table_number": "A5",
    "items": [
        {
            "product_id": 1,
            "quantity": 2
        },
        {
            "product_id": 3,
            "quantity": 1
        }
    ]
}
```

**Validation Rules:**

-   `customer_name`: required, string, max 255 characters
-   `table_number`: required, string, max 50 characters
-   `items`: required, array, minimum 1 item
-   `items.*.product_id`: required, must exist in products table
-   `items.*.quantity`: required, integer, minimum 1

**Response Success:**

```json
{
    "success": true,
    "message": "Pesanan berhasil dibuat.",
    "data": {
        "order_code": "ORD-A1B2C3D4",
        "total_amount": "80000.00",
        "status": "pending"
    }
}
```

**Response Error:**

```json
{
    "success": false,
    "message": "Terjadi kesalahan: Product not found"
}
```

**Status Codes:**

-   `201 Created` - Success
-   `422 Unprocessable Entity` - Validation error
-   `500 Internal Server Error` - Server error

---

## User Info

### Get Current User

**Endpoint:** `GET /api/user`

**Description:** Get authenticated user information

**Response:**

```json
{
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "role": "customer",
    "email_verified_at": null,
    "created_at": "2024-01-01T00:00:00.000000Z",
    "updated_at": "2024-01-01T00:00:00.000000Z"
}
```

**Status Codes:**

-   `200 OK` - Success
-   `401 Unauthorized` - Not authenticated

---

## Error Responses

All API endpoints may return the following error responses:

### Validation Error (422)

```json
{
    "message": "The product id field is required.",
    "errors": {
        "product_id": ["The product id field is required."]
    }
}
```

### Unauthorized (401)

```json
{
    "message": "Unauthenticated."
}
```

### Server Error (500)

```json
{
    "success": false,
    "message": "Terjadi kesalahan: [error details]"
}
```

---

## Example Usage

### Using cURL

```bash
# Get all products
curl -X GET http://localhost:8000/api/products \
  -H "Accept: application/json"

# Add to cart
curl -X POST http://localhost:8000/api/cart/add \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "X-CSRF-TOKEN: your-csrf-token" \
  -d '{
    "product_id": 1,
    "quantity": 2
  }'

# Create order
curl -X POST http://localhost:8000/api/orders \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "X-CSRF-TOKEN: your-csrf-token" \
  -d '{
    "customer_name": "John Doe",
    "table_number": "A5",
    "items": [
      {"product_id": 1, "quantity": 2},
      {"product_id": 3, "quantity": 1}
    ]
  }'
```

### Using JavaScript (Fetch API)

```javascript
// Get all products
fetch("http://localhost:8000/api/products", {
    headers: {
        Accept: "application/json",
    },
})
    .then((response) => response.json())
    .then((data) => console.log(data));

// Add to cart
fetch("http://localhost:8000/api/cart/add", {
    method: "POST",
    headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
            .content,
    },
    body: JSON.stringify({
        product_id: 1,
        quantity: 2,
    }),
})
    .then((response) => response.json())
    .then((data) => console.log(data));
```

---

## Rate Limiting

API endpoints are subject to Laravel's default rate limiting:

-   60 requests per minute for authenticated users

Exceeding the rate limit will return a `429 Too Many Requests` response.

---

## Notes

1. All monetary values are returned as strings with 2 decimal places (e.g., "25000.00")
2. Timestamps follow ISO 8601 format
3. Product images return full URLs including domain
4. Cart operations use session storage for web requests
5. Order creation automatically generates unique order codes with format "ORD-XXXXXXXX"
