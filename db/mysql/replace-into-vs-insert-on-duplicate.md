## Replace into vs insert on duplicate

There's several ways the to bulk insert or update data.

* Delete duplicate and bulk insert
    * Can't know what to delete first if insertion is calculated and size is big, not able to put in RAM.
* Replace into
* Bulk Insert into and bulk on duplicate

There's one problem with `replace into` is that it actually delete duplicate data first and insert new data, and it will trigger delete casade, which may not the sql originally want to do.

> Base on this, I didn't compare performance, besides, should be about the same.