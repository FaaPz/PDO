# LIMIT clause

> Used in [SELECT](../Statement/SELECT.md), [UPDATE](../docs/Statement/UPDATE.md) and [DELETE](../Statement/DELETE.md) statements.

##### `__construct($table, Conditional $on, $type = "")`

Parameter  | Type              | Default  | Description
---------- | ----------------- | -------- | -----------
`$rowCount`| *int*             | required | The number of rows to effect.
`$offset`  | *int|null*        | null     | The offset to start counting at.

### Methods

##### `__toString()`
Returns the prepared SQL string for this statement.

##### `getValues()`
Returns the values to be escaped for this statement.

### Examples
```php
// ... LIMIT 10
$statement->limit(new Limit(10));

// ... LIMIT 30, 10
$statement->limit(new Limit(10, 30));
```
