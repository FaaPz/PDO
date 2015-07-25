### Changelog

##### v1.6.1
+ Updated documentation, see [docs](https://github.com/FaaPz/Slim-PDO/blob/master/docs) directory
+ Updated query builder with:
  - Added `havingCount()` method
  - Added `havingMax()` method
  - Added `havingMin()` method
  - Added `havingAvg()` method
  - Added `havingSum()` method

##### v1.6.0
+ Added documentation, see [docs](https://github.com/FaaPz/Slim-PDO/blob/master/docs) directory
+ Removed `AggregateClause` class (stupid mistake, aggregates are not clauses)
+ Updated query builder with:
  - Added `whereLike()` method
  - Added `orWhereLike()` method
  - Added `whereNotLike()` method
  - Added `orWhereNotLike()` method
+ Updated `SelectStatement` class with:
  - Added aggregate methods `count()`, `distinctCount()`, `max()`, `min()`, `avg()` and `sum()`

##### v1.5.0
+ Updated query builder with:
  - Added `having()` method
  - Added `orHaving()` method
  - Added `distinct()` method
  - Added `count()` method
  - Added `distinctCount()` method
  - Added `max()` method
  - Added `min()` method
  - Added `avg()` method
  - Added `sum()` method

##### v1.4.0
+ Updated query builder with:
  - Added `whereBetween()` method
  - Added `orWhereBetween()` method
  - Added `whereNotBetween()` method
  - Added `orWhereNotBetween()` method
  - Added `whereIn()` method
  - Added `orWhereIn()` method
  - Added `whereNotIn()` method
  - Added `orWhereNotIn()` method
  - Added `whereNull()` method
  - Added `orWhereNull()` method
  - Added `whereNotNull()` method
  - Added `orWhereNotNull()` method

##### v1.3.0
+ Updated query builder with:
  - Added `where()` method
  - Added `orWhere()` method
  - Added `join()` method
  - Added `leftJoin()` method
  - Added `rightJoin()` method
  - Added `fullJoin()` method

##### v1.2.0
+ Updated query builder with:
  - Added `groupBy()` method
  - Added `orderBy()` method
  - Added `limit()` method
  - Added `offset()` method

##### v1.1.0
+ Added query builder

##### v1.0.0
+ First release version