# [FaaPz\PDO\Clause\Conditional](../../src/Clause/Conditional.php) implements [QueryInterface](../QueryInterface.md)

> Used in [Select](../Statement/Select.md), [Update](../Statement/Update.md) and [Delete](../Statement/Delete.md) statements.

> Used by [Grouping](../Clause/Grouping.md) and [Join](../Clause/Join.md) clauses.

## Constructor

### `__construct(string $column, string $operator, $value)`

All Conditional values are parameterized by default.  Please use the [Raw](Raw.md) class to prevent this behavior if 
not desired.

Parameter     | Description
------------- | -----------------------------------------
`$column`     | Database column to match against
`$operator`   | Operator to match against
`$value`      | One or more values to match against

### Example

```php
use FaaPz\PDO\Clause\Conditional;

// ... WHERE id BETWEEN ? AND ?
$statement->where(
    new Clause\Conditional("id", "BETWEEN", [
        110, 220
    ])
);

// ... WHERE id NOT BETWEEN ? AND ?
$statement->where(
    new Clause\Conditional("id", "NOT BETWEEN", [
        110, 220
    ])
);

// ... WHERE id IN (?, ?, ?, ?)
$statement->where(
    new Clause\Conditional("id", "IN", [
        110, 120, 130, 140
    ])
);

// ... WHERE id NOT IN (?, ?, ?, ?)
$statement->where(
    new Clause\Conditional("id", "NOT IN", [
        110, 120, 130, 140
    ])
);

// ... WHERE first_name LIKE ?
$statement->where(new Clause\Conditional("first_name", "LIKE", "Fab%"));

// ... WHERE first_name NOT LIKE ?
$statement->where(new Clause\Conditional("first_name", "NOT LIKE", "Fab%"));

// ... WHERE first_name IS NULL
$statement->where(new Clause\Conditional("first_name", "IS", null));

// ... WHERE first_name IS NOT NULL
$statement->where(new Clause\Conditional("first_name", "IS NOT", null));
```
