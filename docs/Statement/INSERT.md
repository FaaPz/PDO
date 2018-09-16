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
// INSERT INTO users ( usr , pwd ) VALUES ( ? , ? )
$insertStatement = $db->insert(['usr', 'pwd'])
                      ->into('users')
                      ->values(['usr_1', 'pwd_1']);

// INSERT INTO users ( id , usr , pwd ) VALUES ( ? , ? , ? )
$insertStatement = $db->insert(['id'])
                      ->into('users')
                      ->columns(['usr', 'pwd'])
                      ->values([1234, 'usr_1234', 'pwd_1234']);

$insertId = $insertStatement->execute(false);
```
