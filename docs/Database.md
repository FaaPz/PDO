# [FaaPz\PDO\Database](../src/Statement/Call.php) extends [PDO](https://www.php.net/manual/en/class.pdo.php)

The Database class is an extension of PHP's PDO object that provides additional factory style methods for the query
building statements supported by this library.  Because the Database object extends PDO, all PDO methods like
[::beginTransaction()](https://www.php.net/manual/en/pdo.begintransaction.php),
[::rollBack()](https://www.php.net/manual/en/pdo.rollback.php) and
[::commit()](https://www.php.net/manual/en/pdo.commit.php) are fully supported.

## Constructor

### `__construct(string $dsn, ?string $username = null, ?string $password = null, array $options = [])`

All the same constructor parameters you would use to create a PDO object.  The Database class will apply the following
default options unless explicitly overridden:

    [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
    ]

Parameter    | Description
------------ | -----------------------------------------
`$dsn`       | Data source name
`$username`  | Database username
`$password`  | Database password
`$options`   | Array of key => value connection options

### Example

```php
use FaaPz\PDO\Database;

$database = new Database('mysql:host=localhost;dbname=test_db;charset=UTF8');
```

## Methods

### `call(?MethodInterface $procedure = null): CallInterface`

Creates a new [Call](Statement/Call.md) statement that will use the optional [METHOD](Clause/Method.md) parameter.  

Parameter    | Description
------------ | -----------------------------------------
`$procedure` | Optional procedure to call

#### Example

```php
use FaaPz\PDO\Clause\Method;
use FaaPz\PDO\Database;

$database = new Database('mysql:host=localhost;dbname=test_db;charset=UTF8');

// CALL MyProcedure(?, ?)
$statement = $database->call(new Method("MyProcedure", 1, 2));

$statement->execute();
```

### `insert(array $columns = []): InsertInterface`

Creates a new [INSERT](Statement/Insert.md) statement that will use the optional array of columns.

Parameter    | Description
------------ | -----------------------------------------
`$columns`   | Optional columns to use

#### Example

```php
use FaaPz\PDO\Clause\Method;
use FaaPz\PDO\Database;

$database = new Database('mysql:host=localhost;dbname=test_db;charset=UTF8');

// INSERT INTO table (col1, col2) VALUES (?, ?), (?, ?)
$statement = $database->insert(['col1', 'col2'])
                 ->into('table')
                 ->values(1, 2)
                 ->values(3, 4);

$statement->execute();
```

### `select(array $columns = ['*']): SelectInterface`

Creates a new [Select](Statement/Select.md) statement that will use the optional array of columns.

Parameter    | Description
------------ | -----------------------------------------
`$columns`   | Optional columns to select

#### Example

```php
use FaaPz\PDO\Clause\Method;
use FaaPz\PDO\Database;

$database = new Database('mysql:host=localhost;dbname=test_db;charset=UTF8');

// SELECT COUNT(id) AS cnt FROM table
$statement = $database->select(['cnt' => 'COUNT(id)'])
                      ->from('table');

$statement->execute();
```

### `update(array $pairs = []): UpdateInterface`

Creates a new [UPDATE](Statement/Update.md) statement that will use the optional array of column / value pairs.

Parameter    | Description
------------ | -----------------------------------------
`$pairs`     | Optional column / value pairs to update

#### Example

```php
use FaaPz\PDO\Clause\Method;
use FaaPz\PDO\Database;

$database = new Database('mysql:host=localhost;dbname=test_db;charset=UTF8');

// UPDATE table SET col1 = ?, col2 = ?
$statement = $database->update(['col1' => 1, 'col2' => 2])
                      ->table('table');

$statement->execute();
```

### `delete($table = null): DeleteInterface`

Creates a new [DELETE](Statement/Delete.md) statement that will use the optional table to delete from.

Parameter    | Description
------------ | -----------------------------------------
`$table`     | Optional table to delete from

#### Example

```php
use FaaPz\PDO\Clause\Method;
use FaaPz\PDO\Database;

$database = new Database('mysql:host=localhost;dbname=test_db;charset=UTF8');

// DELETE FROM table
$statement = $database->delete('table');

$statement->execute();
```
