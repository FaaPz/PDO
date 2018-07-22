### Changelog

##### v1.10.1
+ Updated `Database` class with:
  - Allow user provided PDO options to overwrite default values
+ Updated `StatementContainer` class with:
  - Added check to stop executing when field value is not expected
+ Updated `LimitClause` class with:
  - Fixed `LIMIT/OFFSET` format
  - Changed default offset value
  - Added check whether offset is null (before checking if is integer)

##### v1.10.0
+ Updated `StatementContainer` class with:
  - Added transactional `commit()` method
  - Added transactional `rollBack()` method
  - Added transactional `beginTransaction()` method
+ Updated `LimitClause` class with:
  - Added validation to check if parameters are casted to expected integers
+ Updated `OffsetClause` class with:
  - Added validation to check if parameter is casted to expected integer

##### v1.9.9
+ Added ability to insert associative arrays (#35)
+ Updated `Database` class with:
  - Renamed `$columns` argument in `insert()` method
+ Updated `StatementContainer` class with:
  - Added `isAssociative()` method
  - Fixed `getPlaceholders()` method

> Proposed by [Raistlfiren](https://github.com/Raistlfiren). Thanks!

##### v1.9.8
+ Updated `SelectStatement` class with:
  - Fixed `getColumns()` method
+ Updated `WhereClause` class with:
  - Reverted `__toString()` method
+ Updated `HavingClause` class with:
  - Reverted `__toString()` method

##### v1.9.7
+ Updated `WhereClause` class with:
  - Fixed some weird bug in `__toString()` method
+ Updated `HavingClause` class with:
  - Fixed the same weird bug in`__toString()` method

> Mentioned by [EliaRigo](https://github.com/EliaRigo). Thanks!

##### v1.9.6
+ Updated `LimitClause` class with:
  - Fixed `limit()` method

##### v1.9.5
+ Updated documentation
+ Added protected override allowed
+ Better parameter naming

##### v1.9.4
+ Revised documentation (WIP)
+ Updated `InsertStatement` class with:
  - Fixed `execute()` method

##### v1.9.3
+ Updated `InsertStatement` class with:
  - Added `$insertId` argument in `execute()` method

##### v1.9.2
+ Updated `Database` class with:
  - Fixed `$options` argument in `__construct()` method

##### v1.9.1
+ Updated `SelectStatement` class with:
  - Fixed all aggregates

##### v1.9.0
+ Added `whereMany()` method
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
  - Fixed `orWhereLike()` method

##### v1.7.2
+ Updated `SelectStatement` class with:
  - Minor fix `select()` method (working fix)

##### v1.7.1
+ Updated `SelectStatement` class with:
  - Minor fix `select()` method
+ Removed old changelog notes

##### v1.7.0
+ Revised release version
