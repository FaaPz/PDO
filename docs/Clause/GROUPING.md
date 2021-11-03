# GROUPING clause

> Used in [SELECT](../Statement/SELECT.md), [UPDATE](../Statement/UPDATE.md) and [DELETE](../Statement/DELETE.md) statements.

> Used by [GROUPING](../Clause/GROUPING.md) and [JOIN](../Clause/JOIN.md) clauses.

##### `__construct($rule, $clauses)`

Parameter  | Type     | Default  | Description
---------- | -------- | -------- | -----------
`$rule`    | *string* | required | Rule to use when combining conditionals
`$clauses` | *array*  | required | Array of conditionals to combine.

### Methods

##### `__toString()`
Returns the prepared SQL string for this statement.

##### `getValues()`
Returns the values to be escaped for this statement.

### Examples

```php
use FaaPz\PDO\Clause\Conditional;
use FaaPz\PDO\Clause\Grouping;

// ... WHERE col_1 = val_1 AND (col_2 = val_2 OR col_3 = val_3)
$statement->where(
    new Grouping("AND", array(
        new Conditional("col_1", "=", "val_1"),
        new Grouping("OR", array(
            new Conditional("col_2", "=", 'val_2'),
            new Conditional("col_3", "=", 'val_3')
        )
    ));
```
