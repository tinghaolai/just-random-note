## Paginate data

### Limit and offset

pros

* easy to directly jump to target page

cons

* more offset, means database need to skip(scan) to data, could cause a performance issue when row count is huge.
* if we're in first page, one row of first page is deleted after we saw the data, then we goto second page, and there would be one row we're missing from the pagination result.

### Cursor

pros

* more efficient.