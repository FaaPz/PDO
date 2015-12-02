### Changelog

##### v1.9.1
+ Updated `SelectStatement` class with:
  - Fixed all aggregates

##### v1.9.0
+ Added `whereMany` method
+ Updated `limit()` method

> Contributed by [bmutinda](https://github.com/bmutinda) and [scheras](https://github.com/scheras). Thanks!

##### v1.8.2
+ Updated `Database` class with:
  - Minor change `__construct()` method 
  - Minor change `insert()` method 
  - Minor change `update()` method
+ Updated `LimitClause` class with:
  - Minor change `__toString()` method
+ Updated `OffsetClause` class with:
  - Minor change `__toString()` method

##### v1.8.1
+ Updated `StatementContainer` class with:
  - Minor fix `setPlaceholders()` method

##### v1.8.0
+ [PSR-2 coding style guide](http://www.php-fig.org/psr/psr-2/) adopted 
+ Updated `InsertStatement` class with:
  - Added `columns()` method
+ Updated `UpdateStatement` class with:
  - Added `set()` method
+ Updated `StatementContainer` class with:
  - Added `$table` argument in `delete()` method
+ Updated `WhereClause` class with:
  - Fixed `orWhereLike()`

##### v1.7.2
+ Updated `SelectStatement` class with:
  - Minor fix `select()` method (working fix)

##### v1.7.1
+ Updated `SelectStatement` class with:
  - Minor fix `select()` method
+ Removed old changelog notes

##### v1.7.0
+ Revised release version