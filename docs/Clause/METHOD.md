# METHOD clause

> Used in [CALL](../Statement/CALL.md) statement.

### Constructor

##### `__construct($name, $values)`

Parameter  | Type     | Default  | Description
---------- | -------- | -------- | -----------
`$name`    | *string* | required | Name of the method to call.
`$values`  | *array*  | []       | Array of escaped arguments for this method.

### Methods

##### `__toString()`
Returns the prepared SQL string for this statement.

##### `getValues()`
Returns the values to be escaped for this statement.

### Examples

```php
$callStatement = $pdo->call(new Method("MyProcedure", "arg1", 2));
```
