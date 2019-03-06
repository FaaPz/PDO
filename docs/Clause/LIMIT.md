# LIMIT clause

> Used in [SELECT](https://github.com/FaaPz/PDO/blob/master/docs/Statement/SELECT.md), [UPDATE](https://github.com/FaaPz/PDO/blob/master/docs/Statement/UPDATE.md) and [DELETE](https://github.com/FaaPz/PDO/blob/master/docs/Statement/DELETE.md) statements.

### Methods

##### `limit($number, $offset = null)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$number` | *int* | required | Number of rows
`$offset` | *int* | `null` | Offset value

### Examples

```php
// ... LIMIT 10
$statement->limit(10);

// ... LIMIT 10 , 30
$statement->limit(10, 30);
```
