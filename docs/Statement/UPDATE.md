# UPDATE statement

### Methods

##### `table($table)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$table` | *string* | required | Table name

##### `set(array $pairs)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$pairs` | *array* | required | Array containing pairs of columns with values

##### `execute()`

### Clauses

+ [WHERE](https://github.com/ParticleBits/PDO/blob/master/docs/Clause/WHERE.md)
+ [ORDER BY](https://github.com/ParticleBits/PDO/blob/master/docs/Clause/ORDER_BY.md)
+ [LIMIT](https://github.com/ParticleBits/PDO/blob/master/docs/Clause/LIMIT.md)

### Examples

```php
// UPDATE users SET pwd = ? WHERE id = ?
$updateStatement = $db->update(['pwd' => 'your_new_password'])
                      ->table('users')
                      ->where('id', '=', 1234);

// UPDATE users SET usr = ? , pwd = ? WHERE id = ?
$updateStatement = $db->update(['usr' => 'your_new_username'])
                      ->set(['pwd' => 'your_new_password'])
                      ->table('users')
                      ->where('id', '=', 1234);

$affectedRows = $updateStatement->execute();
```
