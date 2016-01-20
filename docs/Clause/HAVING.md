# HAVING clause

> Used only in [SELECT](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Statement/SELECT.md) statements.

### Methods

##### `having($column, $operator = null, $rule = 'AND')`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | ...
`$operator` | *string* | `null` | ...
`$rule` | *string* | `'AND'` | ...

##### `orHaving($column, $operator = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | ...
`$operator` | *string* | `null` | ...

##### `havingCount($column, $operator = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | ...
`$operator` | *string* | `null` | ...

##### `havingMax($column, $operator = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | ...
`$operator` | *string* | `null` | ...

##### `havingMin($column, $operator = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | ...
`$operator` | *string* | `null` | ...

##### `havingAvg($column, $operator = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | ...
`$operator` | *string* | `null` | ...

##### `havingSum($column, $operator = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | ...
`$operator` | *string* | `null` | ...

### Examples

```php
// ... HAVING MIN( price ) > ? OR MAX( price ) < ?
$selectStatement->having('MIN( price )', '>', 125)->orHaving('MAX( price )', '<', 250);

// ... HAVING COUNT( * ) > ?
$selectStatement->havingCount('*', '>', 1234);

// ... HAVING MIN|MAX( salary ) > ?
$selectStatement->havingMin('salary', '>', 25000);
$selectStatement->havingMax('salary', '<', 50000);

// ... HAVING AVG( price ) < ?
$selectStatement->havingAvg('price', '<', 12.5);

// ... HAVING SUM( votes ) > ?
$selectStatement->havingSum('votes', '>', 25);
```
