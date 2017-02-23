# ORDER BY clause

> Used in [SELECT](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Statement/SELECT.md), [UPDATE](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Statement/UPDATE.md) and [DELETE](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Statement/DELETE.md) statements.

### Methods

##### `orderBy($column, $direction = 'ASC')`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$column` | *string* | required | Column name
`$direction` | *string* | `'ASC'` | Direction: `ASC` or `DESC`

### Examples

```php
// ... ORDER BY l_name ASC
$statement->orderBy('l_name');
$statement->orderBy('l_name', 'ASC');

// ... ORDER BY l_name DESC
$statement->orderBy('l_name', 'DESC');
```
