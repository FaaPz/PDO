### SELECT statement

##### Methods

+ `distinct()`
+ `from()`
+ `join()`
+ `leftJoin()`
+ `rightJoin()`
+ `fullJoin()`
+ `groupBy()`
+ `having()`
+ `orHaving()`
+ `havingCount()`
+ `havingMax()`
+ `havingMin()`
+ `havingAvg()`
+ `havingSum()`
+ `offset()`

##### Aggregate methods

+ `count`
+ `distinctCount()`
+ `max()`
+ `min()`
+ `avg()`
+ `sum()`

> Documentation? Click [here](https://github.com/FaaPz/Slim-PDO/blob/master/docs/AGGREGATES.md)!

##### Clauses

+ [JOIN](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Clause/JOIN.md)
+ [WHERE](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Clause/WHERE.md)
+ [GROUP BY](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Clause/GROUP_BY.md)
+ [HAVING](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Clause/HAVING.md)
+ [ORDER BY](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Clause/ORDER_BY.md)
+ [LIMIT](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Clause/LIMIT.md)
+ [OFFSET](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Clause/OFFSET.md)

##### Examples

```php
// SELECT * FROM users WHERE id = ?
$selectStatement = $slimPdo->select()
                           ->from('users')
                           ->where('id', '=', 1234);

$stmt = $selectStatement->execute();
$data = $stmt->fetch();
```