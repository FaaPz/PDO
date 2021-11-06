# [FaaPz\PDO\Statement\Select](../../src/Statement/Select.php) extends [AdvancedStatement](../AdvancedStatement.md)

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
$select = new Select($database, [
              'id',
              'username',
              'password'
          ]);

$results = $select->execute();
```

## Methods

### `distinct()`

#### Example

```php
use FaaPz\PDO\Database;
use FaaPz\PDO\Statement\Select;

$database = new Database('mysql:host=localhost;dbname=test_db;charset=UTF8');

// SELECT DISTINCT id ...
$database->select(['id'])
         ->distinct();
```

### `columns(array $columns = ['*']): self`

Parameter    | Description
------------ | -----------------------------------------
`$columns`   | Optional array of columns to select

#### Example

```php
use FaaPz\PDO\Database;
use FaaPz\PDO\Statement\Select;

$database = new Database('mysql:host=localhost;dbname=test_db;charset=UTF8');

// SELECT COUNT(id) as cnt ...
$database->select()
         ->columns([
            'cnt' => 'COUNT(id)'
         ]);
```

### `from($table)`

Parameter    | Description
------------ | -----------------------------------------
`$table`     | Table name

```php
use FaaPz\PDO\Database;
use FaaPz\PDO\Statement\Select;

$database = new Database('mysql:host=localhost;dbname=test_db;charset=UTF8');

// SELECT * FROM table ...
$database->select()
         ->from('table');
```

### `union(SelectInterface $query): self`

Parameter    | Description
------------ | -----------------------------------------
`$query`     | Union query to append

```php
use FaaPz\PDO\Database;
use FaaPz\PDO\Statement\Select;

$database = new Database('mysql:host=localhost;dbname=test_db;charset=UTF8');

// (SELECT id FROM table1) UNION (SELECT id FROM table2) UNION (SELECT id FROM table3) 
$database->select(['id'])
        ->from('table1')
       ->union($database->select(['id'])->from('table2'));
       ->union($database->select(['id'])->from('table3'));
```

### `unionAll(SelectInterface $query): self`

Parameter    | Description
------------ | -----------------------------------------
`$query`     | Union query to append

```php
use FaaPz\PDO\Database;
use FaaPz\PDO\Statement\Select;

$database = new Database('mysql:host=localhost;dbname=test_db;charset=UTF8');

// (SELECT id FROM table1) UNION ALL (SELECT id FROM table2) UNION ALL (SELECT id FROM table3) 
$database->select(['id'])
         ->from('table1')
         ->unionAll($database->select(['id'])->from('table2'));
         ->unionAll($database->select(['id'])->from('table3'));
```

### `groupBy(string ...$columns): self`

Parameter    | Description
------------ | -----------------------------------------
`$columns`   | One or more columns to group by

```php
use FaaPz\PDO\Database;
use FaaPz\PDO\Statement\Select;

$database = new Database('mysql:host=localhost;dbname=test_db;charset=UTF8');

// SELECT * FROM table1 GROUP BY col1, col2 
$database->select()
         ->from('table')
         ->groupBy('col1', 'col2');
```

### `having(ConditionalInterface $clause): self`

Parameter    | Description
------------ | -----------------------------------------
`$clause`    | Having conditional clause

```php
use FaaPz\PDO\Database;
use FaaPz\PDO\Clause\Conditional;
use FaaPz\PDO\Statement\Select;

$database = new Database('mysql:host=localhost;dbname=test_db;charset=UTF8');

// SELECT * FROM table HAVING col1 > ? 
$database->select()
         ->from('table')
         ->having(new Conditional('col1', '>', 0));
```
