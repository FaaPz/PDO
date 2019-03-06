# Aggregates

> Used only in [SELECT](https://github.com/FaaPz/PDO/blob/master/docs/Statement/SELECT.md) statements.

### Methods

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

### Examples

```php
// ... COUNT( * )
$selectStatement->count();

// ... COUNT( votes ) AS all_votes
$selectStatement->count('votes', 'all_votes');

// ... COUNT( DISTINCT customer_id )
$selectStatement->distinctCount('customer_id');

// ... MIN|MAX( salary ) , AVG( price ) , SUM( votes )
$selectStatement->min('salary');
$selectStatement->max('salary');
$selectStatement->avg('price');
$selectStatement->sum('votes');
```
