# CALL statement

### Constructor

##### `__construct($dbh, $method = [])`

Parameter    | Type              | Default  | Description
------------ | ----------------- | -------- | -----------
`$dbh`       | *PDO*             | required | PDO object for database connection
`$procedure` | *MethodInterface* | null     | Procedure to call

### Methods

##### `method($procedure)`

Parameter     | Type              | Default  | Description
------------- | ----------------- | -------- | -----------
`$procedure`  | *MethodInterface* | required | Procedure to call

##### `__toString()`
Returns the prepared SQL string for this statement

##### `getValues()`
Returns the values to be escaped for this statement

### Clauses

+ [Method](Clause/METHOD.md)

### Examples

```php
// CALL MyProcedure(?, ?);
$deleteStatement = $pdo->call()
                        ->method(new Method("MyProcedure", 1, 2));

$deleteStatement->execute();
```
