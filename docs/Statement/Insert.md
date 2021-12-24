# [FaaPz\PDO\Statement\Insert](../../src/Statement/Insert.php) extends [AbstractStatement](../AbstractStatement.md)

## Constructor

### `__construct(Database $dbh, array $columns = [])`

Parameter    | Description
------------ | -----------------------------------------
`$dbh`       | PDO object for database connection
`$pairs`     | Array of key => value pairs to update

#### Example

```php
use FaaPz\PDO\Database;
use FaaPz\PDO\Statement\Insert;

$database = new Database('mysql:host=localhost;dbname=test_db;charset=UTF8');

// INSERT INTO users (id , username , password) VALUES (? , ? , ?)
$insert = new Insert($database, ['id', 'username', 'password']);
$insert->into('users')
       ->values(1234, 'user', 'passwd');

if ($insert->execute()) {
    $insertId = $database->lastInsertId();
}
```

## Methods

### `into($table)`

Parameter    | Description
------------ | -----------------------------------------
`$table`     | Table name

#### Example

```php
use FaaPz\PDO\Database;
use FaaPz\PDO\Statement\Insert;

$database = new Database('mysql:host=localhost;dbname=test_db;charset=UTF8');

// INSERT INTO users ...
$database->insert()
         ->into('users');
```

### `columns(array $columns)`

Parameter    | Description
------------ | -----------------------------------------
`$columns`   | Array containing column names

#### Example

```php
use FaaPz\PDO\Database;
use FaaPz\PDO\Statement\Insert;

$database = new Database('mysql:host=localhost;dbname=test_db;charset=UTF8');
    
// INSERT INTO users (id, username, password) ...
$database->insert()
         ->into('users')
         ->columns(['id', 'username', 'password']);
```

### `values(array $values)`

Parameter    | Description
------------ | -----------------------------------------
`$values`    | Array containing column values

#### Example

```php
use FaaPz\PDO\Database;
use FaaPz\PDO\Statement\Insert;

$database = new Database('mysql:host=localhost;dbname=test_db;charset=UTF8');
    
// INSERT INTO users (id, username, password) VALUES (? , ? , ?), (? , ? , ?)
$insert = new Insert($database, ['id', 'username', 'password']);
$insert->into('users')
         ->values([1, 'user1', 'passwd1'])
         ->values([2, 'user2', 'passwd2']);

if (($result = $delete->execute()) !== false) {
    $affectedRows = $result->rowCount();
}
```
