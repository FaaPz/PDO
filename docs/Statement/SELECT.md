# SELECT statement

### Methods

##### `distinct()`

##### `from($table)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$table` | *string* | required | Table name

##### `join($table, $first, $operator = null, $second = null, $joinType = 'INNER')`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$table` | *string* | required | Table name
`$first` | *string* | required | Column name
`$operator` | *string* | `null` | Logical operator
`$second` | *string* | `null` | Column name
`$joinType` | *string* | `'INNER'` | Join type: `INNER`, `LEFT OUTER`, `RIGHT OUTER` or `FULL OUTER`

##### `offset($number)`

Parameter | Type | Default | Description
--- | --- | --- | ---
`$number` | *int* | required | Number of rows

##### `execute()`

### Clauses

+ [JOIN](Clause/JOIN.md)
+ [CONDITIONAL](Clause/CONDITIONAL.md)
+ [GROUPING](Clause/GROUPING.md)
+ [HAVING](Clause/HAVING.md)
+ [LIMIT](Clause/LIMIT.md)
+ [METHOD](Clause/METHOD.md)

### Examples

```php
// SELECT * FROM users WHERE id = ?
$selectStatement = $slimPdo->select(array("*"))
                           ->from('users')
                           ->where(new Conditional("id", "=", 1234));

$stmt = $selectStatement->execute();
$data = $stmt->fetch();
```
