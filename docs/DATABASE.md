# [FaaPz\PDO\Database]() extends [PDO](https://www.php.net/manual/en/class.pdo.php)

The Database class is an extension of PHP's PDO object that provides a number of factory style methods for the query
building statements supported by this library.  Because the Database object extends PDO, all PDO methods like
[::beginTransaction()](https://www.php.net/manual/en/pdo.begintransaction.php),
[::rollBack()](https://www.php.net/manual/en/pdo.rollback.php) and
[::commit()](https://www.php.net/manual/en/pdo.commit.php) are fully supported.

### Constructor

##### `__construct(string $dsn, ?string $username = null, ?string $password = null, array $options = [])`

All the same constructor parameters you would use to create a PDO object.  The Database class will apply the following
default options unless explicitly overridden:

    [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
    ]

Parameter    | Description
------------ | ----------------------------
`$dsn`       | Data source name
`$username`  | Database username
`$password`  | Database password
`$options`   | Key => value array of connection options.

### Methods

##### `call($procedure)`

Parameter     | Type              | Default  | Description
------------- | ----------------- | -------- | -----------
`$procedure`  | *MethodInterface* | null     | Procedure to call

##### `__toString()`
Returns the prepared SQL string for this statement

##### `getValues()`
Returns the values to be escaped for this statement

### Examples

```php
// CALL MyProcedure(?, ?);
$deleteStatement = $pdo->call()
                        ->method(new Method("MyProcedure", 1, 2));

$deleteStatement->execute();
```
