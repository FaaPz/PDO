### HAVING clause

##### Methods

+ `having()`
+ `orHaving()`
+ `havingCount()`
+ `havingMax()`
+ `havingMin()`
+ `havingAvg()`
+ `havingSum()`

> Used only in [SELECT](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Statement/SELECT.md) statements.

##### Examples

```php
// ... HAVING MIN( price ) > ? OR MAX( price ) < ?
$selectStatement->having('MIN( price )', '>', 125)->orHaving('MAX( price )', '<', 250);

// ... HAVING COUNT( * ) > ?
$selectStatement->havingCount('*', '>', 1234);

// ... HAVING MIN|MAX( salary ) > ?
$selectStatement->havingMin('salary', '>', 25000);
$selectStatement->havingMax('salary', '<', 50000);

// ... HAVING AVG( price ) < ?
$selectStatement->havingAvg('price', '<', 12.5);

// ... HAVING SUM( votes ) > ?
$selectStatement->havingSum('votes', '>', 25);
```