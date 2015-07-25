### JOIN clause

##### Methods

+ `join()`
+ `leftJoin()`
+ `rightJoin()`
+ `fullJoin()`

> Used only in [SELECT](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Statement/SELECT.md) statements.

##### Examples

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