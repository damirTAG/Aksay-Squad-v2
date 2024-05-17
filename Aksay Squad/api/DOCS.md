# API Documentation

## Overview

This API provides access to a collection of quotes, allowing users to fetch all quotes, get a random quote, fetch a specific quote by ID, search for quotes, and fetch data from a specified URL.

## Endpoints

### 1. Get All Quotes

**Endpoint:** `/api/quotes`

**Method:** `GET`

**Description:** Fetches all quotes from the database.

**Response:**
```json
[
  {
    "id": 1,
    "title": "Author",
    "description": "Quote description",
    "create_date": "2024-05-18 12:00:00"
  },
]
```
### 2. Get a Random Quote
**Endpoint:** `/api/random`

**Method:** `GET`

**Description:** Fetches a random quote from the database.

**Response:**
```json
{
  "id": 5,
  "title": "Random Author",
  "description": "Random quote description",
  "create_date": "2024-05-17 10:00:00"
}
```
### 3. Fetch Data from URL
**Endpoint:** `/api/url.php?url={url}`

**Method:** `GET`

**Description:** Fetches data from the specified URL.

**Parameters:**
`url (string, required): The URL from which to fetch data.`

Response:

```json
{
  "data": "Fetched data from the specified URL."
}
Example:

```bash
GET /api/url.php?url=https://example.com
```

### 4. Get a Quote by ID
**Endpoint:** `/api/quotes/show.php?id={id}`

**Method:** `GET`

**Description:** Fetches a specific quote by its ID.

**Parameters:**
`id (int, required): The ID of the quote to fetch.`

**Response:**
```json
{
  "id": 1,
  "title": "Author",
  "description": "Quote description",
  "create_date": "2024-05-18 12:00:00"
}
```
**Example:**
```bash
GET /api/quotes/show.php?id=1
```

### 5. Search Quotes
**Endpoint:** `/api/quotes/search.php?query={query}&count={int}`

**Method:** `GET`

**Description:** Searches for quotes that match the specified query and returns a specified number of results.

**Parameters:**
`- query (string, required): The search query.`
`- count (int, optional): The number of results to return. Default is 10.`

**Response:**
```json
[
  {
    "id": 2,
    "title": "Author",
    "description": "Matching quote description",
    "create_date": "2024-05-17 11:00:00"
  },
  ...
]
```
**Example:**
```bash
GET /api/quotes/search.php?query=inspiration&count=5
```

### Error Handling
If an error occurs, the API will return a JSON response with an error field describing the problem.

Example Error Response:
```json
{
  "error": "Description of the error"
}
```

### Usage Notes
- Ensure that your requests are properly formatted and include all required parameters.
- The API responses are in JSON format.
- If you encounter any issues or have questions, please open an issue on the GitHub repository.
