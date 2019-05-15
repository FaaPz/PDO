# UPDATE statement

### Constructor

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

##### `__toString()`
Returns the prepared SQL string for this statement.

##### `set(array $pairs)`

Parameter | Type    | Default  | Description
--------- | ------- | -------- | -----------
`$pairs`  | *array* | required | Array containing pairs of columns with values

##### `getValues()`
Returns the values to be escaped for this statement

##### `where($clause)`

Parameter | Type                                 | Default  | Description
--------- | ------------------------------------ | -------- | -----------
`$clause` | [Conditional](Clause/CONDITIONAL.md) | required | One or more Conditional clauses to attach to this query

##### `orderBy($column, $direction)`

Parameter | Type     | Default  | Description
--------- | -------- | -------- | -----------
`$column` | *string* | required | The column to order this query by.
`$column` | *string* | null     | The order the above column should be sorted in.

##### `limit($clause)`

Parameter | Type                     | Default  | Description
--------- | ------------------------ | -------- | -----------
`$clause` | [Limit](Clause/LIMIT.md) | required | A single limit conditional to be applied to this statement.

##### `execute()`
Returns Number of affected rows

### Clauses

+ [Conditional](Clause/CONDITIONAL.md)
+ [Grouping](Clause/GROUPING.md)
+ [Join](Clause/JOIN.md)
+ [Limit](Clause/LIMIT.md)
+ [Method](Clause/METHOD.md)

### Examples

```php
// UPDATE users SET pwd = ? WHERE id = ?
$updateStatement = $pdo->update(array(
                               "usr" => "your_new_username",
                               "pwd" => "your_new_password"
                           ))
                           ->table("users")
                           ->where(new Clause\Conditional("id", "=", 1234));

// UPDATE users SET usr = ? , pwd = ? WHERE id = ?
$updateStatement = $pdo->update()
                           ->set(array(
                                "usr" => "your_new_username",
                                "pwd" => "your_new_password"
                            ))
                           ->table("users")
                           ->where(new Clause\Conditional("id", "=", 1234));

$affectedRows = $updateStatement->execute();
```
