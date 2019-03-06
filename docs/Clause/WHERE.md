# WHERE clause

> Used in [SELECT](https://github.com/FaaPz/PDO/blob/master/docs/Statement/SELECT.md), [UPDATE](https://github.com/FaaPz/PDO/blob/master/docs/Statement/UPDATE.md) and [DELETE](https://github.com/FaaPz/PDO/blob/master/docs/Statement/DELETE.md) statements.

### Methods

##### `where($column, $operator = null, $chainType = 'AND')`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | Column name
`$operator` | *string* | `null` | Logic operator
`$chainType` | *string* | `'AND'` | Chain type: `AND` or `OR`

##### `orWhere($column, $operator = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | Column name
`$operator` | *string* | `null` | Logic operator

##### `whereBetween($column, $chainType = 'AND', $not = false)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | Column name
`$chainType` | *string* | `'AND'` | Chain type: `AND` or `OR`
`$not` | *bool* | `false` | Boolean **NOT** condition

##### `orWhereBetween($column)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | Column name

##### `whereNotBetween($column, $chainType = 'AND')`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | Column name
`$chainType` | *string* | `'AND'` | Chain type: `AND` or `OR`

##### `orWhereNotBetween($column)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | Column name

##### `whereIn($column, $placeholders, $chainType = 'AND', $not = false)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | Column name
`$placeholders` | *string* | required | String containing placeholders (?)
`$chainType` | *string* | `'AND'` | Chain type: `AND` or `OR`
`$not` | *bool* | `false` | Boolean **NOT** condition

##### `orWhereIn($column, $placeholders)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | Column name
`$placeholders` | *string* | required | String containing placeholders (?)

##### `whereNotIn($column, $placeholders, $chainType = 'AND')`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | Column name
`$placeholders` | *string* | required | String containing placeholders (?)
`$chainType` | *string* | `'AND'` | Chain type: `AND` or `OR`

##### `orWhereNotIn($column, $placeholders)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | Column name
`$placeholders` | *string* | required | String containing placeholders (?)

##### `whereLike($column, $chainType = 'AND', $not = false)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | Column name
`$chainType` | *string* | `'AND'` | Chain type: `AND` or `OR`
`$not` | *bool* | `false` | Boolean **NOT** condition

##### `orWhereLike($column)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | Column name

##### `whereNotLike($column, $chainType = 'AND')`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | Column name
`$chainType` | *string* | `'AND'` | Chain type: `AND` or `OR`

##### `orWhereNotLike($column)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | Column name

##### `whereNull($column, $chainType = 'AND', $not = false)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | Column name
`$chainType` | *string* | `'AND'` | Chain type: `AND` or `OR`
`$not` | *bool* | `false` | Boolean **NOT** condition

##### `orWhereNull($column)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | Column name

##### `whereNotNull($column, $chainType = 'AND')`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | Column name
`$chainType` | *string* | `'AND'` | Chain type: `AND` or `OR`

##### `orWhereNotNull($column)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | Column name

##### `whereMany(array $columns, $operator = null, $chainType = 'AND')`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$columns` | *array* | required | Array containing column names
`$operator` | *string* | `null` | Logic operator
`$chainType` | *string* | `'AND'` | Chain type: `AND` or `OR`

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
