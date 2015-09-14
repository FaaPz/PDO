# Slim-PDO

PDO database library for Slim Framework

### Installation

Use [Composer](https://getcomposer.org/)

```json
"require": {
    "slim/pdo": "~1.8"
}
```

### Usage

Simple example selecting all data from `users` table.

```php
require_once('vendor/autoload.php');

$dsn = 'mysql:host=your_db_host;dbname=your_db_name;charset=utf8';
$usr = 'your_db_username';
$pwd = 'your_db_password';

$pdo = new \Slim\PDO\Database($dsn, $usr, $pwd);

$qry = $pdo->prepare("SELECT * FROM users");

$result = $qry->execute();

try
{
    var_dump($result->fetchAll());
}
catch(\PDOException $e)
{
    exit($e->getMessage());
}
```

Examples selecting, inserting, updating and deleting data from or into `users` table.

```php
// SELECT * FROM users WHERE id = ?
$selectStatement = $pdo->select()
                       ->from('users')
                       ->where('id', '=', 1234);

$stmt = $selectStatement->execute();
$data = $stmt->fetch();

// INSERT INTO users ( id , usr , pwd ) VALUES ( ? , ? , ? )
$insertStatement = $pdo->insert(array('id', 'usr', 'pwd'))
                       ->into('users')
                       ->values(array(1234, 'your_username', 'your_password'));

$insertId = $insertStatement->execute();

// UPDATE users SET pwd = ? WHERE id = ?
$updateStatement = $pdo->update(array('pwd' => 'your_new_password'))
                       ->table('users')
                       ->where('id', '=', 1234);

$affectedRows = $updateStatement->execute();

// DELETE FROM users WHERE id = ?
$deleteStatement = $pdo->delete()
                       ->from('users')
                       ->where('id', '=', 1234);

$affectedRows = $deleteStatement->execute();
```

### Documentation

See [DOCUMENTATION](https://github.com/FaaPz/Slim-PDO/blob/master/docs/README.md)

### Changelog

See [CHANGELOG](https://github.com/FaaPz/Slim-PDO/blob/master/CHANGELOG.md)

### License

See [LICENSE](https://github.com/FaaPz/Slim-PDO/blob/master/LICENSE)