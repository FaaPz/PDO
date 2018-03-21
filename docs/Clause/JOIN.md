# JOIN clause

> Used in [SELECT](../Statement/SELECT.md), [UPDATE](../docs/Statement/UPDATE.md) and [DELETE](../Statement/DELETE.md) statements.

##### `__construct($table, Conditional $on, $type = "")`

Parameter  | Type                                   | Default  | Description
---------- | -------------------------------------- | -------- | -----------
`$table`   | *string*                               | required | The table to join against
`$on`      | *[Conditional](Clause/CONDITIONAL.md)* | required | Conditional to join the above table on.
`$type`    | *string*                               | ""       | The type of join to perform.

### Methods

##### `__toString()`
Returns the prepared SQL string for this statement.

##### `getValues()`
Returns the values to be escaped for this statement.

### Examples

```php
// ... JOIN orders ON customers.id = orders.customer_id
$selectStatement->join(new Clause\Join("orders",
    new Clause\Conditional("customers.id",  "=", "orders.customer_id")
);

// ... INNER JOIN orders ON customers.id = orders.customer_id
$selectStatement->join(new Clause\Join("orders",
    new Clause\Conditional("customers.id",  "=", "orders.customer_id"),
    "INNER"
);

// ... LEFT OUTER JOIN orders ON customers.id = orders.customer_id
$selectStatement->join(new Clause\Join("orders",
    new Clause\Conditional("customers.id",  "=", "orders.customer_id"),
    "LEFT OUTER"
);

// ... RIGHT OUTER JOIN orders ON customers.id = orders.customer_id
$selectStatement->join(new Clause\Join("orders",
    new Clause\Conditional("customers.id",  "=", "orders.customer_id"),
    "RIGHT OUTER"
);

// ... FULL OUTER JOIN orders ON customers.id = orders.customer_id
$selectStatement->join(new Clause\Join("orders",
    new Clause\Conditional("customers.id",  "=", "orders.customer_id"),
    "FULL OUTER"
);
```
