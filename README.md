# 🤖 AI Notes - Laravel + Gemini AI

> AI-powered Notes Management System built with Laravel 13, Google Gemini AI, and Tailwind CSS.

![Laravel](https://img.shields.io/badge/Laravel-13-red)
![PHP](https://img.shields.io/badge/PHP-8.3-blue)
![Gemini](https://img.shields.io/badge/Google-Gemini-purple)
![License](https://img.shields.io/badge/license-MIT-green)

---

# 📖 Project Overview

AI Notes is an intelligent Notes Management System that combines traditional CRUD operations with Generative AI capabilities.

The application allows users to:

- Create and manage notes
- Generate AI-powered summaries using Google Gemini
- Perform semantic search using Gemini Embeddings
- Search notes based on meaning rather than keywords
- View similarity scores for search results
- Browse notes using pagination
- Access REST APIs through Swagger documentation

---

# 🚀 Features

## Notes Management

- Create Note
- Update Note
- Delete Note
- View Single Note
- View Notes List
- Pagination Support

---

## AI Features

### AI Summary

Generate concise summaries using Google Gemini.

Endpoint

```
POST /api/v1/notes/{id}/summary
```

---

### Semantic Search

Search notes using embeddings instead of keyword matching.

Features

- Google Gemini Embeddings
- Cosine Similarity
- Similarity Score
- Ranked Search Results

Endpoint

```
POST /api/v1/search
```

---

## API Documentation

Swagger/OpenAPI documentation

```
/api/documentation
```

---

# 🛠 Tech Stack

## Backend

- Laravel 13
- PHP 8.3
- SQLite
- REST API
- Service Layer Architecture

## AI

- Google Gemini 2.5 Flash
- Gemini Embedding API

## Frontend

- Blade
- Tailwind CSS
- Vanilla JavaScript
- Axios
- Vite

## Documentation

- Swagger (L5 Swagger)

---

# 📂 Project Structure

```
app/
│
├── Http/
│   ├── Controllers/
│   ├── Requests/
│   ├── Resources/
│
├── Models/
├── Providers/
├── Services/
├── Traits/
└── OpenApi/

database/
│
├── migrations/
└── seeders/

resources/
│
├── js/
├── css/
└── views/

routes/
config/
```

---

# 🏗 Architecture

The project follows a layered architecture.

```
Request
    │
    ▼
Controller
    │
    ▼
Service Layer
    │
    ▼
Gemini API / Database
    │
    ▼
Resource
    │
    ▼
JSON Response
```

### Components

- Controllers handle HTTP requests.
- Form Requests validate user input.
- Services contain business logic.
- Resources transform API responses.
- Traits provide reusable response helpers.
- Models interact with the database.

---

# 🗄 Database Schema

## notes

| Column | Type |
|---------|------|
| id | bigint |
| title | string |
| content | longText |
| summary | text (nullable) |
| embedding | JSON (nullable) |
| created_at | timestamp |
| updated_at | timestamp |

---

# 🔌 Installation

Clone repository

```bash
git clone https://github.com/riteshbeliev/ai-notes.git
```

Go to project

```bash
cd ai-notes
```

Install dependencies

```bash
composer install
```

Install frontend packages

```bash
npm install
```

Create environment

```bash
cp .env.example .env
```

Generate application key

```bash
php artisan key:generate
```

Configure database in `.env`

Run migrations

```bash
php artisan migrate
```

Build frontend

```bash
npm run dev
```

Start server

```bash
php artisan serve
```

---

# ⚙ Environment Variables

Add the following variables to `.env`

```env
APP_NAME="AI Notes Pro"

APP_ENV=local

APP_DEBUG=true

APP_URL=http://127.0.0.1:8000

DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=

GEMINI_API_KEY=AQ.Ab8RN6K-DmU9FODy26gdZ0t_DIjgUmttUETaxnyUnbxF7IuVng
```

---

# 📚 API Endpoints

## Notes

| Method | Endpoint |
|---------|----------|
| GET | /api/v1/notes |
| GET | /api/v1/notes/{id} |
| POST | /api/v1/notes |
| PUT | /api/v1/notes/{id} |
| DELETE | /api/v1/notes/{id} |

---

## AI Summary

| Method | Endpoint |
|---------|----------|
| POST | /api/v1/notes/{id}/summary |

---

## Semantic Search

| Method | Endpoint |
|---------|----------|
| POST | /api/v1/search |

---

# 📄 Sample Search Request

```json
{
    "query":"Laravel service layer"
}
```

---

# 📄 Sample Search Response

```json
{
    "success": true,
    "results": [
        {
            "title":"Architecture",
            "summary":"Service layer keeps controllers clean.",
            "score":0.94
        }
    ]
}
```

---

# 🤖 AI Tools Used

The project was developed using multiple AI-assisted tools.

- ChatGPT
- Google Gemini

AI was used for

- UI generation
- Code suggestions
- Prompt refinement
- Semantic search implementation
- Documentation assistance
- Architecture discussions

All generated code was manually reviewed, tested, and refactored before integration.

---

# 💬 AI Prompts Used

Examples of prompts used during development

- Generate a modern Laravel dashboard UI.
- Implement semantic search using Gemini embeddings.
- Create a clean Service Layer architecture.
- Build RESTful CRUD APIs.
- Generate AI summaries using Gemini.
- Design a responsive Tailwind interface.
- Improve pagination and API responses.

---

# 🔒 Security

Implemented

- Request Validation
- SQL Injection Protection (Eloquent ORM)
- Mass Assignment Protection
- API Exception Handling
- CSRF Protection
- Environment-based configuration
- Structured JSON responses

---

# 📷 Screenshots

- Dashboard   -> https://prnt.sc/RPuAQUGoqGcq
- Notes List -> https://prnt.sc/6Mlsd3yVZ0uB
- Create Note -> https://prnt.sc/wWDQhEEMuFEI
- AI Summary -> https://prnt.sc/l8gshzOkyid7
- Semantic Search -> https://prnt.sc/0BcAejNheSaK
- Swagger Documentation -> https://prnt.sc/E6_Nph82L2ue

---

# 📈 Future Improvements

- User Authentication
- Role-based Authorization
- Redis Caching
- Vector Database Integration
- Docker Support
- Unit Testing
- Full-text Search Indexing

---

# 👨‍💻 Author

**Ritesh**

Junior Software Developer

GitHub

https://github.com/riteshbeliev

---

# 📜 License

This project was developed as part of a PHP Backend + AI Usage Assessment.