# JOIN clause

> Used only in [SELECT](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Statement/SELECT.md) statements.

### Methods

##### `join($table, $first, $operator = null, $second = null, $type = 'INNER')`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$table` | *string* | required | ...
`$first` | *string* | required | ...
`$operator` | *string* | `null` | ...
`$second` | *string* | `null` | ...
`$type` | *string* | `'INNER'` | ...

##### `leftJoin($table, $first, $operator = null, $second = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$table` | *string* | required | ...
`$first` | *string* | required | ...
`$operator` | *string* | `null` | ...
`$second` | *string* | `null` | ...

##### `rightJoin($table, $first, $operator = null, $second = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$table` | *string* | required | ...
`$first` | *string* | required | ...
`$operator` | *string* | `null` | ...
`$second` | *string* | `null` | ...

##### `fullJoin($table, $first, $operator = null, $second = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$table` | *string* | required | ...
`$first` | *string* | required | ...
`$operator` | *string* | `null` | ...
`$second` | *string* | `null` | ...

### Examples

```php
// ... INNER JOIN orders ON customers.id = orders.customer_id
$selectStatement->join('orders', 'customers.id', '=', 'orders.customer_id');
$selectStatement->join('orders', 'customers.id', '=', 'orders.customer_id', 'INNER');

// ... LEFT OUTER JOIN orders ON customers.id = orders.customer_id
$selectStatement->leftJoin('orders', 'customers.id', '=', 'orders.customer_id');

// ... RIGHT OUTER JOIN orders ON customers.id = orders.customer_id
$selectStatement->rightJoin('orders', 'customers.id', '=', 'orders.customer_id');

// ... FULL OUTER JOIN orders ON customers.id = orders.customer_id
$selectStatement->fullJoin('orders', 'customers.id', '=', 'orders.customer_id');
```
