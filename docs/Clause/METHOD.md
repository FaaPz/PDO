# METHOD clause

> Used in [SELECT](../Statement/SELECT.md), [UPDATE](../Statement/UPDATE.md), [INSERT](../Statement/INSERT.md)  and [DELETE](../Statement/DELETE.md) statements.

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
$selectStatement = $slimPdo->select(array(
                                new Clause\Method("MAX", "id")
                            ))
                           ->from("users");

$selectStatement = $slimPdo->select(array(
                                new Clause\Method("COUNT", "id")
                            ))
                           ->from("users")
                           ->groupBy("account_id");
```
