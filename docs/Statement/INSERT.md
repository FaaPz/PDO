### INSERT statement

##### Methods

+ `into()`
+ `values()`

##### Examples

```php
// INSERT INTO users ( id , usr , pwd ) VALUES ( ? , ? , ? )
$insertStatement = $slimPdo->insert(array('id', 'usr', 'pwd'))
                           ->into('users')
                           ->values(array(1234, 'your_username', 'your_password'));

$insertId = $insertStatement->execute();
```