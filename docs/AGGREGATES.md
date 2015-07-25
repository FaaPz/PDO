### Aggregates

##### Methods

+ `count()`
+ `distinctCount()`
+ `max()`
+ `min()`
+ `avg()`
+ `sum()`

> Used only in [SELECT](https://github.com/FaaPz/Slim-PDO/blob/master/docs/Statement/SELECT.md) statements.

##### Examples

```php
// ... COUNT( * )
$selectStatement->count();

// ... COUNT( votes ) AS all_votes
$selectStatement->count('votes', 'all_votes');

// ... COUNT( DISTINCT customer_id )
$selectStatement->distinctCount('customer_id');

// ... MIN|MAX( salary ) , AVG( price ) , SUM( votes )
$selectStatement->min('salary');
$selectStatement->max('salary');
$selectStatement->avg('price');
$selectStatement->sum('votes');
```