# SELECT statement

### Constructor

##### `__construct($dbh, $columns = ["*"])`

Parameter  | Type     | Default  | Description
---------- | -------- | -------- | -----------
`$dbh`     | *PDO*    | required | PDO object for database connection
`$columns` | *array*  | ["*"]    | Array of columns or Clause\Method

### Methods

##### `distinct()`

##### `from($table)`

Parameter | Type     | Default  | Description
--------- | -------- | -------- | -----------
`$table`  | *string* | required | Table name

##### `join($clause)`

Parameter | Type                     | Default  | Description
--------- | ------------------------ | -------- | -----------
`$clause` | *[Join](Clause/JOIN.md)* | required | One or more Join clauses to attach to this query

##### `groupBy($column)`

Parameter | Type     | Default  | Description
--------- | -------- | -------- | -----------
`$column` | *string* | required | One or more columns to group the result by

##### `having($clause)`

Parameter | Type                                   | Default  | Description
--------- | -------------------------------------- | -------- | -----------
`$clause` | *[Conditional](Clause/CONDITIONAL.md)* | required | One or more Conditial clauses to attach to this query

##### `__toString()`
Returns the prepared SQL string for this statement.

##### `getValues()`
Returns the values to be escaped for this statement.

##### `where($clause)`

Parameter | Type                                   | Default  | Description
--------- | -------------------------------------- | -------- | -----------
`$clause` | *[Conditional](Clause/CONDITIONAL.md)* | required | One or more Conditional clauses to attach to this query

##### `orderBy($column, $direction)`

Parameter | Type     | Default  | Description
--------- | -------- | -------- | -----------
`$column` | *string* | required | The column to order this query by.
`$column` | *string* | null     | The order the above column should be sorted in.

##### `limit($clause)`

Parameter | Type                       | Default  | Description
--------- | -------------------------- | -------- | -----------
`$clause` | *[Limit](Clause/LIMIT.md)* | required | A single limit conditional to be applied to this statement.

##### `execute()`
Returns PHP PDOStatement object.

### Clauses

+ [Conditional](../Clause/CONDITIONAL.md)
+ [Grouping](../Clause/GROUPING.md)
+ [Join](../Clause/JOIN.md)
+ [Limit](../Clause/LIMIT.md)

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
