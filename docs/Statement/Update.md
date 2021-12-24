# [FaaPz\PDO\Statement\Update](../../src/Statement/Update.php) extends [AdvancedStatement](../AdvancedStatement.md)

## Constructor

### `__construct(Database $dbh, array $pairs = [])`

Parameter    | Description
------------ | -----------------------------------------
`$dbh`       | Database object for database connection
`$pairs`     | Array of key => value pairs to update

#### Example

```php
use FaaPz\PDO\Database;
use FaaPz\PDO\Statement\Update;

$database = new Database('mysql:host=localhost;dbname=test_db;charset=UTF8');

// INSERT INTO users (id , username , password) VALUES (? , ? , ?)
$update = new Update($database, [
              'id',
              'username',
              'password'
          ]);

if (($result = $insert->execute()) !== false) {
    $affectedRows = $result->rowCount();
}
```

## Methods

### `table(string $table): self`

Parameter    | Description
------------ | -----------------------------------------
`$table`     | Table name

#### Example

```php
use FaaPz\PDO\Database;
use FaaPz\PDO\Statement\Update;

$database = new Database('mysql:host=localhost;dbname=test_db;charset=UTF8');

// UPDATE users ...
$database->update()
         ->table('users');
```

### `set(string $column, $value): self`

Parameter    | Description
------------ | -----------------------------------------
`$column`    | Column to insert to
`$value`     | Value of the column

#### Example

```php
use FaaPz\PDO\Database;
use FaaPz\PDO\Statement\Update;

$database = new Database('mysql:host=localhost;dbname=test_db;charset=UTF8');

// UPDATE users SET username = ?, password = ?
$database->update()
         ->table('users')
         ->set('username', 'user')
         ->set('password', 'passwd');
```

### `pairs(array $pairs): self`

Parameter    | Description
------------ | -----------------------------------------
`$pairs`     | Column / Value pairs to insert

#### Example

```php
use FaaPz\PDO\Database;
use FaaPz\PDO\Statement\Update;

$database = new Database('mysql:host=localhost;dbname=test_db;charset=UTF8');

// UPDATE users SET username = ?, password = ?
$database->update()
         ->table('users')
         ->pairs([
             'username' => 'user',
             'password' => 'passwd'
         ]);
```
