# [FaaPz\PDO\Statement\Call](../../src/Statement/Call.php) extends [AbstractStatement](../AbstractStatement.md)

## Constructor

### `__construct(Database $dbh, ?MethodInterface $procedure = null)`

Parameter    | Description
------------ | -----------------------------------------
`$dbh`       | Database object
`$procedure` | Optional procedure to call

#### Example

```php
use FaaPz\PDO\Database;
use FaaPz\PDO\Statement\Call;

$database = new Database('mysql:host=localhost;dbname=test_db;charset=UTF8');

// CALL MyProcedure(?, ?)
$call = new Call($database, new Method('MyProcedure', 1, 2));

$call->execute();
```

## Methods

### `method(MethodInterface $procedure): self`

Adds a stored procedure [Method](../Clause/Method.md) clause to the call statement.

Parameter    | Description
------------ | -----------------------------------------
`$procedure` | Procedure to call

#### Example

```php
use FaaPz\PDO\Clause\Method;
use FaaPz\PDO\Statement\Call;
use FaaPz\PDO\Database;

$database = new Database('mysql:host=localhost;dbname=test_db;charset=UTF8');

// CALL MyProcedure(?, ?)
$database->call()
         ->method(new Method('MyProcedure', 1, 2));
```
