# INSERT statement

### Methods

##### `into($table)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$table` | *string* | required | Table name

##### `columns(array $columns)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$columns` | *array* | required | Array containing column names

##### `values(array $values)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$values` | *array* | required | Array containing column values

##### `execute($insertId = true)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$insertId` | *bool* | `true` | Boolean to return **lastInsertId**

### Examples

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

$insertId = $insertStatement->execute(false);
```
