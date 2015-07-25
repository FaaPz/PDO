### ORDER BY clause

##### Methods

+ `orderBy()`

> Used in [SELECT](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Statement/SELECT.md), [UPDATE](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Statement/UPDATE.md) and [DELETE](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Statement/DELETE.md) statements.

##### Examples of ordering

```php
// ... ORDER BY l_name ASC
$statement->orderBy('l_name');
$statement->orderBy('l_name', 'ASC');

// ... ORDER BY l_name DESC
$statement->orderBy('l_name', 'DESC');
```