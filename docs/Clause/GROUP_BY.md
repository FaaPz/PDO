# GROUP BY clause

> Used only in [SELECT](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Statement/SELECT.md) statements.

### Methods

##### `groupBy($columns)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$columns` | *string* | required | String containing column names

### Examples

```php
// ... GROUP BY f_name
$selectStatement->groupBy('f_name');
```
