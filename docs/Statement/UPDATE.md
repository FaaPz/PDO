# [FaaPz\PDO\Statement\Update](../../src/Statement/Update.php) extends [AdvancedStatement](../AdvancedStatement.md) implements [StatementInterface](../StatementInterface.md)

## Constructor

##### `__construct($dbh, $pairs = [])`

Parameter | Type     | Default  | Description
--------- | -------- | -------- | -----------
`$dbh`    | PDO      | required | PDO object for database connection
`$pairs`  | array    | []       | Array of key => value pairs to update

### Methods

##### `table($table)`

Parameter | Type     | Default  | Description
--------- | -------- | -------- | -----------
`$table`  | *string* | required | Table name


##### `set(array $pairs)`

Parameter | Type    | Default  | Description
--------- | ------- | -------- | -----------
`$pairs`  | *array* | required | Array containing pairs of columns with values


#### Example

```php
// UPDATE users SET usr = ? , pwd = ? WHERE id = ?
$update = $database->update(array(
                       "username" => "your_new_username",
                       "password" => "your_new_password"
                   ))
                   ->table("users")
                   ->where(new Clause\Conditional("id", "=", 1234));

// UPDATE users SET usr = ? , pwd = ? WHERE id = ?
$update = $database->update()
                   ->set(array(
                       "username" => "your_new_username",
                       "password" => "your_new_password"
                   ))
                   ->table("users")
                   ->where(new Clause\Conditional("id", "=", 1234));

$affectedRows = $updateStatement->execute()->rowCount();
```
