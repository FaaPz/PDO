# GROUP BY clause

> Used only in [SELECT](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Statement/SELECT.md) statements.

### Methods

##### `groupBy($statement)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$statement` | *string* | required | ...

### Examples

```php
// ... GROUP BY f_name
$selectStatement->groupBy('f_name');
```
