# GROUP BY clause

> Used only in [SELECT](https://github.com/ParticleBits/PDO/blob/master/docs/Statement/SELECT.md) statements.

### Methods

##### `groupBy($columns)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$columns` | *array* | required | Array containing column names, appended

### Examples

```php
// ... GROUP BY f_name
$selectStatement->groupBy(['f_name']);

// ... GROUP BY f_name, l_name
$selectStatement->groupBy(['f_name', 'l_name']);

// or
$selectStatement->groupBy(['f_name'])
                ->groupBy(['l_name']);
```
