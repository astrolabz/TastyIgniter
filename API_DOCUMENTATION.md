# De Vishal Den Helder - API Documentation

## Overview

API REST per il sistema di e-commerce "De Vishal Den Helder". Include endpoint per la gestione del menu prodotti ittici con caratteristiche specifiche (freschezza, allergeni, origine) e gestione dell'inventario stock.

Base URL: `https://devishal.nl/api`

---

## Autenticazione

### Endpoint Pubblici
Gli endpoint del menu (`/api/menu/*`) sono accessibili pubblicamente senza autenticazione.

### Endpoint Protetti
Gli endpoint di gestione stock (`/api/stock/*`) richiedono autenticazione con **Laravel Sanctum**.

**Headers richiesti:**
```http
Authorization: Bearer {your_token}
Accept: application/json
Content-Type: application/json
```

---

## Menu Endpoints

### GET /api/menu

Ottieni lista prodotti con filtri avanzati.

**Query Parameters:**

| Parametro | Tipo | Descrizione | Esempio |
|-----------|------|-------------|---------|
| `category_id` | integer | Filtra per categoria | `1` |
| `catch_method` | enum | Filtra per metodo cattura | `wild`, `farmed`, `organic` |
| `origin_region` | string | Filtra per regione origine | `Noordzee` |
| `exclude_allergens` | string | Escludi prodotti con allergeni (comma-separated) | `SHELLFISH,GLUTEN` |
| `freshness` | enum | Filtra per freschezza | `today`, `fresh`, `catch_of_day` |
| `search` | string | Ricerca in nome/descrizione | `zalm` |
| `sort_by` | enum | Campo ordinamento | `menu_name`, `menu_price`, `freshness_date`, `created_at` |
| `sort_order` | enum | Direzione ordinamento | `asc`, `desc` |
| `per_page` | integer | Risultati per pagina (max 100) | `20` |

**Response Example:**
```json
{
  "success": true,
  "data": {
    "current_page": 1,
    "data": [
      {
        "menu_id": 1,
        "menu_name": "Verse Atlantische Zalm",
        "menu_description": "Wild gevangen zalm uit de Noordzee",
        "menu_price": "18.50",
        "menu_photo": "/storage/menu/zalm.jpg",
        "freshness_date": "2025-01-13",
        "freshness_status": "today",
        "is_fresh": true,
        "is_catch_of_day": true,
        "catch_method": "wild",
        "origin_region": "Noordzee - Nederland",
        "storage_temp": "2.5",
        "preparation_notes": "Best te grillen of te bakken",
        "allergens": [
          {
            "code": "FISH",
            "name": "Vis",
            "icon_class": "fas fa-fish"
          }
        ],
        "categories": ["Verse Vis", "Vangst van de Dag"]
      }
    ],
    "total": 45,
    "per_page": 20,
    "last_page": 3
  },
  "filters_applied": {
    "category_id": null,
    "catch_method": "wild",
    "origin_region": null,
    "exclude_allergens": null,
    "freshness": "catch_of_day",
    "search": null
  }
}
```

---

### GET /api/menu/{menuId}

Ottieni dettagli completi di un singolo prodotto.

**Path Parameters:**
- `menuId` (integer, required) - ID del prodotto menu

**Response Example:**
```json
{
  "success": true,
  "data": {
    "menu_id": 1,
    "menu_name": "Verse Atlantische Zalm",
    "menu_description": "Wild gevangen zalm uit de Noordzee",
    "menu_price": "18.50",
    "menu_photo": "/storage/menu/zalm.jpg",
    "menu_status": 1,
    "freshness_date": "2025-01-13",
    "freshness_status": "today",
    "is_fresh": true,
    "is_catch_of_day": true,
    "catch_method": "wild",
    "origin_region": "Noordzee - Nederland",
    "storage_temp": "2.5",
    "preparation_notes": "Best te grillen of te bakken",
    "current_stock": 45,
    "allergens": [
      {
        "id": 1,
        "code": "FISH",
        "name_en": "Fish",
        "name_nl": "Vis",
        "localized_name": "Vis",
        "icon_class": "fas fa-fish"
      }
    ],
    "categories": [...],
    "options": [...]
  }
}
```

---

### GET /api/menu/catch-of-day

Ottieni solo i prodotti "Vangst van de Dag" (Catch of the Day).

**Response Example:**
```json
{
  "success": true,
  "data": [
    {
      "menu_id": 1,
      "menu_name": "Verse Atlantische Zalm",
      "menu_description": "Wild gevangen zalm uit de Noordzee",
      "menu_price": "18.50",
      "menu_photo": "/storage/menu/zalm.jpg",
      "freshness_date": "2025-01-13",
      "origin_region": "Noordzee - Nederland",
      "catch_method": "wild",
      "allergens": ["FISH"]
    }
  ]
}
```

---

## Stock Management Endpoints

⚠️ **Richiedono autenticazione Sanctum**

### GET /api/stock/{menuItemId}

Ottieni stato stock corrente per un prodotto.

**Path Parameters:**
- `menuItemId` (integer, required) - ID del menu item

**Response Example:**
```json
{
  "success": true,
  "data": {
    "menu_item_id": 1,
    "menu_name": "Verse Atlantische Zalm",
    "current_stock": 45,
    "freshness_date": "2025-01-13",
    "is_fresh": true,
    "freshness_status": "today"
  }
}
```

---

### PUT /api/stock/{menuItemId}

Aggiorna stock per un prodotto (incremento o decremento).

**Path Parameters:**
- `menuItemId` (integer, required) - ID del menu item

**Request Body:**
```json
{
  "change": 10,
  "reason": "restocking",
  "reference": "PO-2025-001",
  "notes": "Consegna mattutina fornitore XYZ"
}
```

**Body Parameters:**

| Campo | Tipo | Required | Descrizione | Valori |
|-------|------|----------|-------------|--------|
| `change` | decimal | ✅ | Quantità da aggiungere (+) o togliere (-) | Positivo = aggiunta, Negativo = sottrazione |
| `reason` | enum | ✅ | Motivo movimento | `order`, `manual`, `spoilage`, `restocking` |
| `reference` | string | ❌ | Riferimento esterno (es. PO#) | Max 255 char |
| `notes` | text | ❌ | Note aggiuntive | - |

**Response Example:**
```json
{
  "success": true,
  "message": "Stock updated successfully",
  "data": {
    "menu_item_id": 1,
    "previous_stock": 35,
    "change": 10,
    "current_stock": 45
  }
}
```

**Error Response:**
```json
{
  "success": false,
  "errors": {
    "change": ["The change field is required."],
    "reason": ["The selected reason is invalid."]
  }
}
```

---

### GET /api/stock/{menuItemId}/history

Ottieni storico movimenti stock per un prodotto (paginato, 50 per pagina).

**Path Parameters:**
- `menuItemId` (integer, required) - ID del menu item

**Response Example:**
```json
{
  "success": true,
  "data": {
    "menu_item_id": 1,
    "menu_name": "Verse Atlantische Zalm",
    "current_stock": 45,
    "history": {
      "current_page": 1,
      "data": [
        {
          "id": 153,
          "menu_item_id": 1,
          "change": "-2.00",
          "reason": "order",
          "reference": "ORDER-2025-456",
          "notes": "Customer order #456",
          "created_at": "2025-01-13T10:30:00.000000Z"
        },
        {
          "id": 152,
          "menu_item_id": 1,
          "change": "20.00",
          "reason": "restocking",
          "reference": "PO-2025-001",
          "notes": "Morning delivery",
          "created_at": "2025-01-13T06:15:00.000000Z"
        }
      ],
      "total": 153,
      "per_page": 50
    }
  }
}
```

---

### POST /api/stock/batch

Aggiorna stock per multipli prodotti in una singola richiesta.

**Request Body:**
```json
{
  "updates": [
    {
      "menu_item_id": 1,
      "change": -5,
      "reason": "order",
      "reference": "ORDER-2025-789",
      "notes": "Bulk order processing"
    },
    {
      "menu_item_id": 3,
      "change": 15,
      "reason": "restocking",
      "reference": "PO-2025-002"
    }
  ]
}
```

**Response Example (Success):**
```json
{
  "success": true,
  "message": "All stock updates successful",
  "results": [
    {
      "menu_item_id": 1,
      "success": true,
      "current_stock": 40
    },
    {
      "menu_item_id": 3,
      "success": true,
      "current_stock": 28
    }
  ],
  "errors": []
}
```

**Response Example (Partial Success - HTTP 207 Multi-Status):**
```json
{
  "success": false,
  "message": "Some stock updates failed",
  "results": [
    {
      "menu_item_id": 1,
      "success": true,
      "current_stock": 40
    }
  ],
  "errors": [
    {
      "menu_item_id": 999,
      "error": "No query results for model [Igniter\\Cart\\Models\\Menu] 999"
    }
  ]
}
```

---

## Console Commands

### Stock Refresh

Resetta/registra stock giornaliero per tutti i menu items.

```bash
php artisan stock:refresh [--dry-run]
```

**Options:**
- `--dry-run` - Esegui senza modificare il database (test mode)

**Schedulato:** Giornaliero alle 03:00 (Europe/Amsterdam)

**Output Example:**
```
Starting daily stock refresh...
Processing 45 menu items...
✓ Verse Atlantische Zalm: Current stock 45
✓ Hollandse Garnalen: Current stock 120
...

Stock refresh complete!
┌─────────┬───────┐
│ Metric  │ Value │
├─────────┼───────┤
│ Updated │ 45    │
│ Errors  │ 0     │
│ Total   │ 45    │
└─────────┴───────┘
```

---

### Freshness Check

Controlla prodotti scaduti/scadenti e invia alert.

```bash
php artisan freshness:check [--notify]
```

**Options:**
- `--notify` - Invia notifiche email/SMS agli admin (TODO: da implementare)

**Schedulato:** Due volte al giorno (06:00 e 14:00, Europe/Amsterdam)

**Output Example:**
```
Checking freshness status...
Checking 45 items with freshness dates...

⚠ 3 EXPIRED ITEMS:
  - Kabeljauw Filet (expired 2 day(s) ago)
  - Zeebaars (expired 1 day(s) ago)
  - Dorade (expired 3 day(s) ago)

⚠ 5 items expiring TODAY:
  - Verse Atlantische Zalm
  - Hollandse Garnalen
  ...

ℹ 4 items expiring TOMORROW:
  - Tonijn Steak
  - Makreel
  ...

┌──────────────────┬───────┐
│ Status           │ Count │
├──────────────────┼───────┤
│ Expired          │ 3     │
│ Expiring Today   │ 5     │
│ Expiring Tomorrow│ 4     │
│ Total Checked    │ 45    │
└──────────────────┴───────┘
```

---

## Error Codes

| HTTP Status | Descrizione |
|-------------|-------------|
| 200 | Success |
| 207 | Multi-Status (batch operations con successi parziali) |
| 401 | Unauthorized (token mancante/invalido) |
| 404 | Not Found (risorsa non esistente) |
| 422 | Unprocessable Entity (validazione fallita) |
| 500 | Internal Server Error |

---

## Rate Limiting

API endpoints pubblici: **60 richieste/minuto** per IP
API endpoints protetti: **120 richieste/minuto** per utente autenticato

Headers nella response:
```http
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
Retry-After: 3600
```

---

## Esempi d'Uso

### Esempio 1: Cerca prodotti senza glutine, freschi oggi

```bash
curl -X GET "https://devishal.nl/api/menu?exclude_allergens=GLUTEN&freshness=today" \
     -H "Accept: application/json"
```

### Esempio 2: Aggiorna stock dopo ordine cliente

```bash
curl -X PUT "https://devishal.nl/api/stock/1" \
     -H "Authorization: Bearer {token}" \
     -H "Content-Type: application/json" \
     -d '{
       "change": -2,
       "reason": "order",
       "reference": "ORDER-2025-456",
       "notes": "Customer order #456"
     }'
```

### Esempio 3: Batch update stock dopo consegna fornitore

```bash
curl -X POST "https://devishal.nl/api/stock/batch" \
     -H "Authorization: Bearer {token}" \
     -H "Content-Type: application/json" \
     -d '{
       "updates": [
         {
           "menu_item_id": 1,
           "change": 20,
           "reason": "restocking",
           "reference": "PO-2025-001"
         },
         {
           "menu_item_id": 3,
           "change": 15,
           "reason": "restocking",
           "reference": "PO-2025-001"
         }
       ]
     }'
```

---

## Sviluppi Futuri

- [ ] Webhook notifications per stock basso
- [ ] Export CSV storico movimenti
- [ ] GraphQL endpoint alternativo
- [ ] Filtri geografici per zone delivery
- [ ] Integrazione barcode scanner per aggiornamento stock
