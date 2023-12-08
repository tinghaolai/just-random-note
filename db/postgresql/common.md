### Auto Increment

```sql
CREATE SEQUENCE core_demo.accounts_id_seq;
ALTER TABLE core_demo.accounts ALTER COLUMN id SET DEFAULT nextval('core_demo.accounts_id_seq');
DO $$ DECLARE  max_id bigint; BEGIN SELECT COALESCE(MAX(id), 0) INTO max_id FROM core_demo.accounts; PERFORM setval('core_demo.accounts_id_seq', max_id + 1);END $$;
```
