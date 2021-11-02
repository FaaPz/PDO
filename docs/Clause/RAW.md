# LIMIT clause

> Used by [CONDITIONAL](../Clause/CONDITIONAL.md) clauses.

##### `__construct($sql)`

Parameter  | Type              | Default  | Description
---------- | ----------------- | -------- | -----------
`$sql`     | *string*          | required | Raw SQL to use.

### Methods

##### `__toString()`
Returns the raw SQL string for this statement.

##### `getValues()`
Returns an empty array.

### Examples
```php
// ... WHERE col = MAX(1, 2)
$select->where(new Conditional('col', '=', new Raw("MAX(1, 2)")));
```
