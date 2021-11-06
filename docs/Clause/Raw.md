# [FaaPz\PDO\Clause\Raw](../../src/Clause/Raw.php) implements [QueryInterface](../QueryInterface.md)

> Used in [Insert](../Statement/Update.md) and [Update](../Statement/Update.md) statements.

> Used by [Conditional](../Clause/Conditional.md) clauses.

## Constructor

### `__construct(string $sql)`

Parameter     | Description
------------- | -----------------------------------------
`$sql`        | Raw SQL string to use

#### Example

```php
use FaaPz\PDO\Clause\Conditional;
use FaaPz\PDO\Clause\Raw;

// ... WHERE col = MAX(1, 2)
$statement->where(new Conditional('col', '=', new Raw("MAX(1, 2)")));
```
