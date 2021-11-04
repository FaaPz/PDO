# [FaaPz\PDO\Statement\Select](../../src/Statement/Select.php) extends [AdvancedStatement](../AdvancedStatement.md) implements [StatementInterface](../StatementInterface.md)

## Constructor

#### `__construct(Database $dbh, array $columns = ['*'])`

Parameter    | Description
------------ | -----------------------------------------
`$dbh`       | PDO object for database connection
`$columns`   | Optional columns to select

#### Example

```php
use FaaPz\PDO\Database;
use FaaPz\PDO\Statement\Select;

$database = new Database('mysql:host=localhost;dbname=test_db;charset=UTF8');

// SELECT id, username, password ...
$select = new Select($database, array(
              'id',
              'username',
              'password'
          ));
```

## Methods

### `distinct()`

#### Example

```php
use FaaPz\PDO\Database;
use FaaPz\PDO\Statement\Select;

$database = new Database('mysql:host=localhost;dbname=test_db;charset=UTF8');

// SELECT DISTINCT id ...
$select = new Select($database, array(
              'id'
          ));
$select->distinct();
```

### `columns(array $columns = ['*']): self`

Parameter    | Description
------------ | -----------------------------------------
`$columns`   | Optional array of columns to select


### `from($table)`

Parameter    | Description
------------ | -----------------------------------------
`$table`     | Table name


union(SelectInterface $query): self

unionAll(SelectInterface $query): self

groupBy(string ...$columns): self

having(ConditionalInterface $clause): self



### Examples

```php
// SELECT COUNT(id) AS cnt
// FROM users
// WHERE id > ?
// GROUP BY username, email
// HAVING cnt > ?
// ORDER BY username DESC, email ASC
// LIMIT 5 OFFSET 25
$select = $database->select(array(
                  "cnt" => "COUNT(id)"
              ))
              ->from("users")
              ->where(new Conditional("id", ">", 1000))
              ->groupBy("username", "email")
              ->having(new Conditional("cnt", ">", 1))
              ->orderBy("username", "desc")
              ->orderBy("email", "asc")
              ->limit(new Limit(5, 25));

$data = $select->execute()->fetch();
```
