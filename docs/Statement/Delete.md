# [FaaPz\PDO\Statement\Delete](../../src/Statement/Delete.php) extends [AdvancedStatement](../AdvancedStatement.md) implements [StatementInterface](../StatementInterface.md)

## Constructor

### `__construct(Database $dbh, $table = null)`

Parameter    | Description
------------ | -----------------------------------------
`$dbh`       | Database object for database connection
`$table`     | Optional table name

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
$delete = new Delete($database);
$delete->from("users");

$affectedRows = $delete->execute()->rowCount();
```
