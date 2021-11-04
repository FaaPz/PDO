# [FaaPz\PDO\Clause\Method](../../src/Clause/Method.php) implements [QueryInterface](../QueryInterface.md)

> Used in [Call](../Statement/Call.md) statement.

## Constructor

### `__construct(string $name, ...$args)`

All Method args are parameterized by default.  Please use the [Raw](Raw.md) class to prevent this behavior if
not desired.

Parameter     | Description
------------- | -----------------------------------------
`$name`       | Name of the method to call
`$values`     | Array of arguments for this method

### Example

```php
use FaaPz\PDO\Clause\Method;

// CALL MyProcedure(?, ?)
$statement = $database->call(new Method("MyProcedure", "arg1", 2));
```
