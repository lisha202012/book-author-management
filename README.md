# Book & Author Management System

A simple Laravel backend application to manage Authors and Books with basic CRUD operations, proper relationships, and request validation.

## Setup Instructions

1. Clone the repository:

```bash
git clone https://github.com/lisha202012/book-author-management.git
cd book-author-management
```

2. Install dependencies:

```bash
composer install
npm install
npm run dev
```

3. Configure environment:

```bash
copy .env.example .env   # Windows
# or
cp .env.example .env     # macOS/Linux
```

Update `.env` with your database credentials:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=book_author_db
DB_USERNAME=root
DB_PASSWORD=
```

4. Create and import database:

```sql
CREATE DATABASE book_author_db;
```

```bash
mysql -u root -p book_author_db < database/sql/book_author_db.sql
```

5. Run the Laravel server:

```bash
php artisan key:generate
php artisan serve
```

Visit [http://127.0.0.1:8000](http://127.0.0.1:8000) to access the application.

## Notes

- SQL Export File: `database/sql/book_author_db.sql`
- Commit Message: "Add database SQL export"
- Branch: main
