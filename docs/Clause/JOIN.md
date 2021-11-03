# JOIN clause

> Used in [SELECT](../Statement/SELECT.md), [UPDATE](../Statement/UPDATE.md) and [DELETE](../Statement/DELETE.md) statements.

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
use FaaPz\PDO\Clause\Conditional;
use FaaPz\PDO\Clause\Join;
use FaaPz\PDO\Clause\Raw;

// ... JOIN orders ON customers.id = orders.customer_id
$statement->join(new Join("orders",
    new Conditional("customers.id",  "=", new Raw("orders.customer_id"))
);

// ... INNER JOIN orders ON customers.id = orders.customer_id
$statement->join(new Join("orders",
    new Conditional("customers.id",  "=", new Raw("orders.customer_id")),
    "INNER"
);

// ... LEFT OUTER JOIN orders ON customers.id = orders.customer_id
$statement->join(new Join("orders",
    new Conditional("customers.id",  "=", new Raw("orders.customer_id")),
    "LEFT OUTER"
);

// ... RIGHT OUTER JOIN orders ON customers.id = orders.customer_id
$statement->join(new Join("orders",
    new Conditional("customers.id",  "=", new Raw("orders.customer_id")),
    "RIGHT OUTER"
);

// ... FULL OUTER JOIN orders ON customers.id = orders.customer_id
$statement->join(new Join("orders",
    new Conditional("customers.id",  "=", new Raw("orders.customer_id")),
    "FULL OUTER"
);
```
