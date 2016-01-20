# LIMIT clause

> Used in [SELECT](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Statement/SELECT.md), [UPDATE](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Statement/UPDATE.md) and [DELETE](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Statement/DELETE.md) statements.

### Methods

##### `limit($number, $end = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$number` | *int* | required | ...
`$end` | *int* | `null` | ...

### Examples

```php
// ... LIMIT 10
$statement->limit(10);

// ... LIMIT 10 , 30
$statement->limit(10, 30);
```
