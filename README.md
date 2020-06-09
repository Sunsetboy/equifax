## Test task for the Russian credit bureau

### Installation

Create a database for the project (UTF-8) and specify access in config/db.php

Run migrations:
```
./yii migrate
```

Seed the database with fake data:
```
./yii seed-db
```

Start a built-in web server
```
./yii serve
```

### 1. Get IDs of payments without credits

Run the command from terminal
```
./yii export-credits/get-payments-without-credits
```
Results will be stored in the /runtime/payments_without_credits.txt file.

### Export credits with overdue to XML and validate it

```
./yii export-credits/export-credits-with-overdue
```

### 2. Bookstore

Open http://localhost:8080/ in browser