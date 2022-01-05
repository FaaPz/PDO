# PDO

[![Latest Stable Version](https://poser.pugx.org/faapz/pdo/v/stable)](https://packagist.org/packages/faapz/pdo)
[![Total Downloads](https://poser.pugx.org/faapz/pdo/downloads)](https://packagist.org/packages/faapz/pdo)
[![Latest Unstable Version](https://poser.pugx.org/faapz/pdo/v/unstable)](https://packagist.org/packages/faapz/pdo)
[![License](https://poser.pugx.org/faapz/pdo/license)](https://packagist.org/packages/faapz/pdo)

Just another PDO database library

### Installation

Use [Composer](https://getcomposer.org/)

```bash
$ composer require faapz/pdo 
```

### Usage

Examples selecting, inserting, updating and deleting data from or into `users` table.

```php
require_once 'vendor/autoload.php';

$dsn = 'mysql:host=your_db_host;dbname=your_db_name;charset=utf8';
$usr = 'your_db_username';
$pwd = 'your_db_password';

$database = new FaaPz\PDO\Database($dsn, $usr, $pwd);

// SELECT * FROM users WHERE id = ?
$select = $database->select()
                   ->from('users')
                   ->where(new FaaPz\PDO\Clause\Conditional('id', '=', 1234));

if ($insert->execute()) {
    $data = $stmt->fetch();
}

// INSERT INTO users (id , username , password) VALUES (? , ? , ?)
$insert = $database->insert(
                       'id',
                       'username',
                       'password'
                   )
                   ->into('users')
                   ->values(
                       1234,
                       'user',
                       'passwd'
                   );

if ($insert->execute()) {
    $insertId = $database->lastInsertId();
}

// UPDATE users SET pwd = ? WHERE id = ?
$update = $database->update(["pwd" => "your_new_password"])
                   ->table("users")
                   ->where(new FaaPz\PDO\Clause\Conditional("id", "=", 1234));

if (($result = $insert->execute()) !== false) {
    $affectedRows = $result->rowCount();
}

// DELETE FROM users WHERE id = ?
$delete = $database->delete()
                   ->from("users")
                   ->where(new FaaPz\PDO\Clause\Conditional("id", "=", 1234));

if (($result = $delete->execute()) !== false) {
    $affectedRows = $result->rowCount();
}
```

> The `sqlsrv` extension will fail to connect when using error mode `PDO::ERRMODE_EXCEPTION` (default). To connect, you will need to explicitly pass `array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)` (or `PDO::ERRMODE_SILENT`) into the constructor, or override the `getDefaultOptions()` method when using `sqlsrv`.

### Documentation

See [DOCUMENTATION](docs/README.md)

### Changelog

See [CHANGELOG](CHANGELOG.md)

### License

See [LICENSE](LICENSE.md)
