# [FaaPz\PDO\Clause\Limit](../../src/Clause/Limit.php) implements [QueryInterface](../QueryInterface.md)

> Used in [Select](../Statement/Select.md), [Update](../Statement/Update.md) and [Delete](../Statement/Delete.md) statements.

## Constructor

### `__construct(int $size, ?int $offset = null)`

Parameter     | Description
------------- | -----------------------------------------
`$rowCount`   | The number of rows to effect
`$offset`     | The offset to start counting at

#### Example
```php
use FaaPz\PDO\Clause\Limit;

// ... LIMIT ?
$statement->limit(new Limit(10));

// ... LIMIT ? OFFSET ?
$statement->limit(new Limit(10, 30));
```
