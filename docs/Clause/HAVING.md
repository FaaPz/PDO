# HAVING clause

> Used only in [SELECT](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Statement/SELECT.md) statements.

### Methods

##### `having($column, $operator = null, $chainType = 'AND')`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | Column name
`$operator` | *string* | `null` | Logic operator
`$chainType` | *string* | `'AND'` | Chain type: `AND` or `OR`

##### `orHaving($column, $operator = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | Column name
`$operator` | *string* | `null` | Logic operator

##### `havingCount($column, $operator = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | Column name
`$operator` | *string* | `null` | Logic operator

##### `havingMax($column, $operator = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | Column name
`$operator` | *string* | `null` | Logic operator

##### `havingMin($column, $operator = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | Column name
`$operator` | *string* | `null` | Logic operator

##### `havingAvg($column, $operator = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | Column name
`$operator` | *string* | `null` | Logic operator

##### `havingSum($column, $operator = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | Column name
`$operator` | *string* | `null` | Logic operator

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
