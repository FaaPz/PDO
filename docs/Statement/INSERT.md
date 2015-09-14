### INSERT statement

##### Methods

+ `into()`
+ `columns()`
+ `values()`

##### Examples

```php
// INSERT INTO users ( id , usr , pwd ) VALUES ( ? , ? , ? )
$insertStatement = $slimPdo->insert(array('id', 'usr', 'pwd'))
                           ->into('users')
                           ->values(array(1234, 'your_username', 'your_password'));

// INSERT INTO users ( id , usr , pwd ) VALUES ( ? , ? , ? )
$insertStatement = $slimPdo->insert(array('id'))
                           ->into('users')
                           ->columns(array('usr', 'pwd'))
                           ->values(array(1234, 'your_username', 'your_password'));

$insertId = $insertStatement->execute();
```