# INSERT statement

### Constructor

##### `__construct($dbh, $columns = ["*"])`

Parameter  | Type     | Default  | Description
---------- | -------- | -------- | -----------
`$dbh`     | *PDO*    | required | PDO object for database connection
`$pairs`   | *array*  | []       | Array of key => value pairs to update

### Methods

##### `into($table)`

Parameter | Type     | Default  | Description
--------- | -------- | -------- | -----------
`$table`  | *string* | required | Table name

##### `columns(array $columns)`

Parameter  | Type    | Default  | Description
---------- | ------- | -------- | -----------
`$columns` | *array* | required | Array containing column names

##### `values(array $values)`

Parameter | Type    | Default  | Description
--------- | ------- | -------- | -----------
`$values` | *array* | required | Array containing column values

##### `getValues()`
Returns the values to be escaped for this statement.

##### `execute()`
Returns the primary key for the inserted record


### Examples

```php
// INSERT INTO users ( id , usr , pwd ) VALUES ( ? , ? , ? )
$insertStatement = $pdo->insert(array(
                               "id" => 1234,
                               "usr" => "your_username",
                               "pwd" => "your_password"
                           ))
                           ->into("users");

// INSERT INTO users ( id , usr , pwd ) VALUES ( ? , ? , ? )
$insertStatement = $pdo->insert()
                           ->into("users")
                           ->columns(array("id", "usr", "pwd"))
                           ->values(array(1234, "your_username", "your_password"));

$insertId = $insertStatement->execute(false)->lastInsertId();
```
