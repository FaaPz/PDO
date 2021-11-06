# [FaaPz\PDO\Clause\Grouping](../../src/Clause/Grouping.php) implements [QueryInterface](../QueryInterface.md)

> Used in [Select](../Statement/Select.md), [Udpdate](../Statement/Update.md) and [Delete](../Statement/Delete.md) statements.

> Used by [Join](../Clause/Join.md) clauses.

## Constructor

### `__construct($rule, $clauses)`

Parameter     | Description
------------- | -----------------------------------------
`$rule`       | Rule to use when combining conditionals
`$clauses`    | Array of conditionals to combine

#### Example

```php
use FaaPz\PDO\Clause\Conditional;
use FaaPz\PDO\Clause\Grouping;

// ... WHERE col1 = ? AND (col2 = ? OR col3 = ?)
$statement->where(
    new Grouping('AND', [
        new Conditional('col1', '=', 'val1'),
        new Grouping('OR', [
            new Conditional('col2', '=', 'val2'),
            new Conditional('col3', '=', 'val3')
        ])
    ]);
```
