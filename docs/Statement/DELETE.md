# DELETE statement

### Methods

##### `from($table)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$table` | *string* | required | Table name

##### `execute()`

### Clauses

+ [WHERE](https://github.com/ParticleBits/PDO/blob/master/docs/Clause/WHERE.md)
+ [ORDER BY](https://github.com/ParticleBits/PDO/blob/master/docs/Clause/ORDER_BY.md)
+ [LIMIT](https://github.com/ParticleBits/PDO/blob/master/docs/Clause/LIMIT.md)

### Examples

```php
// DELETE FROM users WHERE id = ?
$deleteStatement = $db->delete()
                      ->from('users')
                      ->where('id', '=', 1234);

$affectedRows = $deleteStatement->execute();
```
