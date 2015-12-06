### WHERE clause

##### Methods

+ `where()`
+ `orWhere()`
+ `whereBetween()`
+ `orWhereBetween()`
+ `whereNotBetween()`
+ `orWhereNotBetween()`
+ `whereIn()`
+ `orWhereIn()`
+ `whereNotIn()`
+ `orWhereNotIn()`
+ `whereLike()`
+ `orWhereLike()`
+ `whereNotLike()`
+ `orWhereNotLike()`
+ `whereNull()`
+ `orWhereNull()`
+ `whereNotNull()`
+ `orWhereNotNull()`
+ `whereMany()`

> Used in [SELECT](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Statement/SELECT.md), [UPDATE](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Statement/UPDATE.md) and [DELETE](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Statement/DELETE.md) statements.

##### Examples

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
