# [FaaPz\PDO\AdvancedStatement](../src/AdvancedStatement.php) extends [AbstractStatement](../src/AbstractStatement.php)

## Methods

### `join(JoinInterface $clause): self`

Parameter    | Description
------------ | -----------------------------------------
`$clause`    | Join clauses to apply

#### Example

```php
use FaaPz\PDO\Clause\Conditional;
use FaaPz\PDO\Clause\Join;

// ... LEFT JOIN table2 ON table2.fk = table1.id
$statement->join(new Join("table2", new Conditional('table2.fk', '=', new Raw('table1.id'))), 'LEFT');
```

### `where(ConditionalInterface $clause): self`

Parameter    | Description
------------ | -----------------------------------------
`$clause`    | Conditional or Grouping clauses to filter by

#### Example

```php
use FaaPz\PDO\Clause\Conditional;

// ... WHERE col = 1
$statement->where(new Conditional('col', '=', 1));
```

### `orderBy(string $column, string $direction = ''): self`

Parameter    | Description
------------ | -----------------------------------------
`$column`    | The column to order this query by
`$direction` | The order the column should be sorted in

#### Example

```php
// ... ORDER BY col1, col2 ASC, col3 DESC
$statement->orderBy('col1')
          ->orderBy('col2', 'ASC')
          ->orderBy('col3', 'DESC');
```

### `limit(LimitInterface $limit): self`

Adds a [Limit](Clause/Limit.md) clause to this statement.

Parameter    | Description
------------ | -----------------------------------------
`$clause`    |  Limit clause

#### Example

```php
use FaaPz\PDO\Clause\Limit;

// ... LIMIT ? OFFSET ?
$statement->limit(new Limit(10 , 30));
```
