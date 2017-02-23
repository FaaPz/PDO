# JOIN clause

> Used only in [SELECT](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Statement/SELECT.md) statements.

### Methods

##### `join($table, $first, $operator = null, $second = null, $joinType = 'INNER')`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$table` | *string* | required | Table name
`$first` | *string* | required | Column name
`$operator` | *string* | `null` | Logical operator
`$second` | *string* | `null` | Column name
`$joinType` | *string* | `'INNER'` | Join type: `INNER`, `LEFT OUTER`, `RIGHT OUTER` or `FULL OUTER`

##### `leftJoin($table, $first, $operator = null, $second = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$table` | *string* | required | Table name
`$first` | *string* | required | Column name
`$operator` | *string* | `null` | Logical operator
`$second` | *string* | `null` | Column name

##### `rightJoin($table, $first, $operator = null, $second = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$table` | *string* | required | Table name
`$first` | *string* | required | Column name
`$operator` | *string* | `null` | Logical operator
`$second` | *string* | `null` | Column name

##### `fullJoin($table, $first, $operator = null, $second = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$table` | *string* | required | Table name
`$first` | *string* | required | Column name
`$operator` | *string* | `null` | Logical operator
`$second` | *string* | `null` | Column name

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
