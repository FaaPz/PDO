# SELECT statement

### Methods

##### `distinct()`

##### `from($table)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$table` | *string* | required | ...

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

##### `groupBy($statement)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$statement` | *string* | required | ...

##### `having($column, $operator = null, $value = null, $rule = 'AND')`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | ...
`$operator` | *string* | `null` | ...
`$value` | *string* | `null` | ...
`$rule` | *string* | `'AND'` | ...

##### `orHaving($column, $operator = null, $value = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | ...
`$operator` | *string* | `null` | ...
`$value` | *string* | `null` | ...

##### `havingCount($column, $operator = null, $value = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | ...
`$operator` | *string* | `null` | ...
`$value` | *string* | `null` | ...

##### `havingMax($column, $operator = null, $value = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | ...
`$operator` | *string* | `null` | ...
`$value` | *string* | `null` | ...

##### `havingMin($column, $operator = null, $value = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | ...
`$operator` | *string* | `null` | ...
`$value` | *string* | `null` | ...

##### `havingAvg($column, $operator = null, $value = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | ...
`$operator` | *string* | `null` | ...
`$value` | *string* | `null` | ...

##### `havingSum($column, $operator = null, $value = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | ...
`$operator` | *string* | `null` | ...
`$value` | *string* | `null` | ...

##### `offset($number)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$number` | *int* | required | ...

##### `execute()`

### Aggregate methods

##### `count($column = '*', $as = null, $distinct = false)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | `'*'` | ...
`$as` | *string* | `null` | ...
`$distinct` | *bool* | `false` | ...

##### `distinctCount($column = '*', $as = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | `'*'` | ...
`$as` | *string* | `null` | ...

##### `max($column, $as = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | ...
`$as` | *string* | `null` | ...

##### `min($column, $as = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | ...
`$as` | *string* | `null` | ...

##### `avg($column, $as = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | ...
`$as` | *string* | `null` | ...

##### `sum($column, $as = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | ...
`$as` | *string* | `null` | ...

> Example code? Click [here](https://github.com/FaaPz/Slim-PDO/blob/master/docs/AGGREGATES.md)!

### Clauses

+ [JOIN](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Clause/JOIN.md)
+ [WHERE](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Clause/WHERE.md)
+ [GROUP BY](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Clause/GROUP_BY.md)
+ [HAVING](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Clause/HAVING.md)
+ [ORDER BY](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Clause/ORDER_BY.md)
+ [LIMIT](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Clause/LIMIT.md)
+ [OFFSET](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Clause/OFFSET.md)

### Examples

```php
// SELECT * FROM users WHERE id = ?
$selectStatement = $slimPdo->select()
                           ->from('users')
                           ->where('id', '=', 1234);

$stmt = $selectStatement->execute();
$data = $stmt->fetch();
```
