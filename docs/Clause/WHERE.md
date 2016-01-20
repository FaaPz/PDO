# WHERE clause

> Used in [SELECT](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Statement/SELECT.md), [UPDATE](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Statement/UPDATE.md) and [DELETE](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Statement/DELETE.md) statements.

### Methods

##### `where($column, $operator = null, $rule = 'AND')`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | ...
`$operator` | *string* | `null` | ...
`$rule` | *string* | `'AND'` | ...

##### `orWhere($column, $operator = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | ...
`$operator` | *string* | `null` | ...

##### `whereBetween($column, $rule = 'AND', $not = false)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | ...
`$rule` | *string* | `'AND'` | ...
`$not` | *bool* | `false` | ...

##### `orWhereBetween($column)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | ...

##### `whereNotBetween($column, $rule = 'AND')`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | ...
`$rule` | *string* | `'AND'` | ...

##### `orWhereNotBetween($column)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | ...

##### `whereIn($column, $placeholders, $rule = 'AND', $not = false)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | ...
`$placeholders` | *mixed* | required | ...
`$rule` | *string* | `'AND'` | ...
`$not` | *bool* | `false` | ...

##### `orWhereIn($column, $placeholders)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | ...
`$placeholders` | *mixed* | required | ...

##### `whereNotIn($column, $placeholders, $rule = 'AND')`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | ...
`$placeholders` | *mixed* | required | ...
`$rule` | *string* | `'AND'` | ...

##### `orWhereNotIn($column, $placeholders)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | ...
`$placeholders` | *mixed* | required | ...

##### `whereLike($column, $rule = 'AND', $not = false)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | ...
`$rule` | *string* | `'AND'` | ...
`$not` | *bool* | `false` | ...

##### `orWhereLike($column)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | ...

##### `whereNotLike($column, $rule = 'AND')`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | ...
`$rule` | *string* | `'AND'` | ...

##### `orWhereNotLike($column)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | ...

##### `whereNull($column, $rule = 'AND', $not = false)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | ...
`$rule` | *string* | `'AND'` | ...
`$not` | *bool* | `false` | ...

##### `orWhereNull($column)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | ...

##### `whereNotNull($column, $rule = 'AND')`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | ...
`$rule` | *string* | `'AND'` | ...

##### `orWhereNotNull($column)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | ...

##### `whereMany($columns, $operator = null, $rule = 'AND')`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$columns` | *mixed* | required | ...
`$operator` | *string* | `null` | ...
`$rule` | *string* | `'AND'` | ...

### Examples

```php
// ... WHERE usr = ? OR f_name = ?
$statement->where('usr', '=', 'FaaPz')->orWhere('f_name', '=', 'Fabian');

// ... WHERE customer_id BETWEEN ? AND ?
$statement->whereBetween('customer_id', array( 110, 220 ));

// ... WHERE customer_id NOT BETWEEN ? AND ?
$statement->whereNotBetween('customer_id', array( 330, 440 ));

// ... WHERE customer_id IN ( ?, ?, ?, ? )
$statement->whereIn('customer_id', array( 110, 120, 130, 140 ));

// ... WHERE customer_id NOT IN ( ?, ?, ?, ? )
$statement->whereNotIn('customer_id', array( 112, 124, 136, 148 ));

// ... WHERE f_name LIKE ?
$statement->whereLike('f_name', 'Fab___');

// ... WHERE l_name NOT LIKE ?
$statement->whereNotLike('l_name', 'Lae%');

// ... WHERE f_name IS NULL
$statement->whereNull('f_name');

// ... WHERE l_name IS NOT NULL
$statement->whereNotNull('l_name');

// ... WHERE col_1 = ? AND col_2 = ? AND col_3 = ?
$statement->whereMany(array('col_1' => 'val_1', 'col_2' => 'val_2', 'col_3' => 'val_3'), '=');
```
