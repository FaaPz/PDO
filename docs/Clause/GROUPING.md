# GROUPING clause

> Used in [SELECT](../Statement/SELECT.md), [UPDATE](../docs/Statement/UPDATE.md) and [DELETE](../Statement/DELETE.md) statements.
> Used by [GROUPING](../Clause/GROUPING.md) and [JOIN](../docs/Statement/JOIN.md) clauses.

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
$statement->where(
    new Clause\Grouping("AND", array(
        new Clause\Conditional("col_1", "=", "val_1"),
        new Clause\Grouping("OR", array(
            new Clause\Conditional("col_2", "=", 'val_2'),
            new Clause\Conditional("col_3", "=", 'val_2')
        )
    ));
```
