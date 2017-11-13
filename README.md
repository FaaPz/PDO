# Slim-PDO

[![Latest Stable Version](https://poser.pugx.org/slim/pdo/v/stable)](https://packagist.org/packages/slim/pdo)
[![Total Downloads](https://poser.pugx.org/slim/pdo/downloads)](https://packagist.org/packages/slim/pdo)
[![Latest Unstable Version](https://poser.pugx.org/slim/pdo/v/unstable)](https://packagist.org/packages/slim/pdo)
[![License](https://poser.pugx.org/slim/pdo/license)](https://packagist.org/packages/slim/pdo)

PDO database library for Slim Framework

### Installation

Use [Composer](https://getcomposer.org/)

```json
"require": {
    "slim/pdo": "~1.10"
}
```

### Usage

Examples selecting, inserting, updating and deleting data from or into `users` table.

```php
require_once 'vendor/autoload.php';

$dsn = 'mysql:host=your_db_host;dbname=your_db_name;charset=utf8';
$usr = 'your_db_username';
$pwd = 'your_db_password';

$pdo = new \Slim\PDO\Database($dsn, $usr, $pwd);

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

$insertId = $insertStatement->execute(false);

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

> The `sqlsrv` extension will fail to connect when using error mode `PDO::ERRMODE_EXCEPTION` (default). To connect, you will need to explicitly pass `array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)` (or `PDO::ERRMODE_SILENT`) into the constructor, or override the `getDefaultOptions()` method when using `sqlsrv`.

### Documentation

See [DOCUMENTATION](https://github.com/FaaPz/Slim-PDO/blob/master/docs/README.md)

### Changelog

See [CHANGELOG](https://github.com/FaaPz/Slim-PDO/blob/master/CHANGELOG.md)

### License

See [LICENSE](https://github.com/FaaPz/Slim-PDO/blob/master/LICENSE)
