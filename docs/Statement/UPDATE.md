### UPDATE statement

##### Methods

+ `table()`
+ `set()`

##### Clauses

+ [WHERE](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Clause/WHERE.md)
+ [ORDER BY](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Clause/ORDER_BY.md)
+ [LIMIT](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Clause/LIMIT.md)

##### Examples

```php
// UPDATE users SET pwd = ? WHERE id = ?
$updateStatement = $slimPdo->update(array('pwd' => 'your_new_password'))
                           ->table('users')
                           ->where('id', '=', 1234);

// UPDATE users SET usr = ? , pwd = ? WHERE id = ?
$updateStatement = $slimPdo->update(array('usr' => 'your_new_username'))
                           ->set(array('pwd' => 'your_new_password'))
                           ->table('users')
                           ->where('id', '=', 1234);

$affectedRows = $updateStatement->execute();
```