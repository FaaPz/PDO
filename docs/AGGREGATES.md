# Aggregates

> Used only in [SELECT](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Statement/SELECT.md) statements.

### Methods

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
