# SELECT statement

### Methods

##### `distinct()`

##### `from($table)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$table` | *string* | required | Table name

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

##### `groupBy($columns)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$columns` | *string* | required | String containing column names

##### `having($column, $operator = null, $value = null, $chainType = 'AND')`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | Column name
`$operator` | *string* | `null` | Logical operator
`$value` | *string* | `null` | Column value
`$chainType` | *string* | `'AND'` | Chain type: `AND` or `OR`

##### `orHaving($column, $operator = null, $value = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | Column name
`$operator` | *string* | `null` | Logical operator
`$value` | *string* | `null` | Column value

##### `havingCount($column, $operator = null, $value = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | Column name
`$operator` | *string* | `null` | Logical operator
`$value` | *string* | `null` | Column value

##### `havingMax($column, $operator = null, $value = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | Column name
`$operator` | *string* | `null` | Logical operator
`$value` | *string* | `null` | Column value

##### `havingMin($column, $operator = null, $value = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | Column name
`$operator` | *string* | `null` | Logical operator
`$value` | *string* | `null` | Column value

##### `havingAvg($column, $operator = null, $value = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | Column name
`$operator` | *string* | `null` | Logical operator
`$value` | *string* | `null` | Column value

##### `havingSum($column, $operator = null, $value = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | Column name
`$operator` | *string* | `null` | Logical operator
`$value` | *string* | `null` | Column value

##### `offset($number)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$number` | *int* | required | Number of rows

##### `execute()`

### Aggregate methods

##### `count($column = '*', $as = null, $distinct = false)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | `'*'` | String containing column names
`$as` | *string* | `null` | Column alias
`$distinct` | *bool* | `false` | Boolean **DISTINCT** clause

##### `distinctCount($column = '*', $as = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | `'*'` | String containing column names
`$as` | *string* | `null` | Column alias

##### `max($column, $as = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | Column name
`$as` | *string* | `null` | Column alias

##### `min($column, $as = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | Column name
`$as` | *string* | `null` | Column alias

##### `avg($column, $as = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | Column name
`$as` | *string* | `null` | Column alias

##### `sum($column, $as = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | Column name
`$as` | *string* | `null` | Column alias

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
