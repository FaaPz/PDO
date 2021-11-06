# [FaaPz\PDO\Clause\Join](../../src/Clause/Join.php) implements [QueryInterface](../QueryInterface.md)

> Used in [Select](../Statement/Select.md), [Update](../Statement/Update.md) and [Delete](../Statement/Delete.md) statements.

## Constructor

### `__construct($table, Conditional $on, $type = "")`

Parameter     | Description
------------- | -----------------------------------------
`$table`      | The table to join against
`$on`         | Conditional to join the above table on
`$type`       | Optional type of join to perform

#### Example

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
