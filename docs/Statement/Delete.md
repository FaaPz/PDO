# [FaaPz\PDO\Statement\Delete](../../src/Statement/Delete.php) extends [AdvancedStatement](../AdvancedStatement.md)

## Constructor

### `__construct(Database $dbh, $table = null)`

Parameter    | Description
------------ | -----------------------------------------
`$dbh`       | Database object for database connection
`$table`     | Optional table name

#### Example

```php
use FaaPz\PDO\Database;
use FaaPz\PDO\Statement\Delete;

$database = new Database('mysql:host=localhost;dbname=test_db;charset=UTF8');

// DELETE FROM users
$delete = new Delete($database, 'users');

if (($result = $delete->execute()) !== false) {
    $affectedRows = $result->rowCount();
}
```

## Methods

### `from($table): self`

The table to delete from.

Parameter    | Description
------------ | -----------------------------------------
`$table`     | Table name

#### Example

```php
use FaaPz\PDO\Database;
use FaaPz\PDO\Statement\Delete;

$database = new Database('mysql:host=localhost;dbname=test_db;charset=UTF8');

// DELETE FROM users
$database->delete()
         ->from('users');
```
