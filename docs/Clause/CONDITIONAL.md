# Conditional clause

> Used in [SELECT](../Statement/SELECT.md), [UPDATE](../Statement/UPDATE.md) and [DELETE](../Statement/DELETE.md) statements.

> Used by [GROUPING](../Clause/GROUPING.md) and [JOIN](../Clause/JOIN.md) clauses.

### Constructor

##### `__construct($column, $operator, $value)`
Parameter   | Type     | Default  | Description
----------- | -------- | -------- | -----------
`$column`   | *string* | required | Database column to match against
`$operator` | *string* | required | Operator to match against
`$value`    | *mixed*  | required | One or more values to be safely matched against

### Methods

##### `__toString()`
Returns the prepared SQL string for this clause.

##### `getValues()`
Returns the values to be escaped for this clause.

### Examples

```php
use FaaPz\PDO\Clause\Conditional;
use FaaPz\PDO\Clause\Grouping;

// ... WHERE usr = ? OR f_name = ?
$statement->where(
    new Clause\Grouping("OR", array(
        new Clause\Conditional("usr", "=", "FaaPz"),
        new Clause\Conditional("f_name", "=", 'Fabian')
    ))
);

// ... WHERE customer_id BETWEEN ? AND ?
$statement->where(
    new Clause\Conditional("customer_id", "BETWEEN", array(
        110, 220
    ))
);

// ... WHERE customer_id NOT BETWEEN ? AND ?
$statement->where(
    new Clause\Conditional("customer_id", "NOT BETWEEN", array(
        110, 220
    ))
);

// ... WHERE customer_id IN ( ?, ?, ?, ? )
$statement->where(
    new Clause\Conditional("customer_id", "IN", array(
        110, 120, 130, 140
    ))
);

// ... WHERE customer_id NOT IN ( ?, ?, ?, ? )
$statement->where(
    new Clause\Conditional("customer_id", "NOT IN", array(
        110, 120, 130, 140
    ))
);

// ... WHERE f_name LIKE ?
$statement->where(new Clause\Conditional("f_name", "LIKE", "Fab%"));

// ... WHERE l_name NOT LIKE ?
$statement->where(new Clause\Conditional("f_name", "NOT LIKE", "Fab%"));

// ... WHERE f_name IS NULL
$statement->where(new Clause\Conditional("f_name", "IS", null));

// ... WHERE l_name IS NOT NULL
$statement->where(new Clause\Conditional("f_name", "IS NOT", null));

// ... WHERE col_1 = ? AND (col_2 = ? OR col_3 = ?)
$statement->where(
    new Clause\Grouping("AND", array(
        new Clause\Conditional("col_1", "=", "val_1"),
        new Clause\Grouping("OR", array(
            new Clause\Conditional("col_2", "=", 'val_2'),
            new Clause\Conditional("col_3", "=", 'val_2')
        )
    ));
```
