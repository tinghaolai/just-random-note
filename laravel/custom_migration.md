## Custom migration (concept)

When databases and tables are static, laravel migration is enough to achieve the requirement of migration.

But if database and tables change dynamically, there would be some problems.
* Migrate record for each dynamic table schema change
* Migrate record when create dynamic table
* How to rollback when databases migrate progress aren't the same

### Dynamic database scenario

1. main database: `main`

Tables in this database is static.

tables: `companies`, `workers`

Workers schema

| id  | name  | worker_type | db_n | company_id | created_at          | updated_at |
|-----|-------|-------------|------|------------|---------------------|------------|
| 1   | Tony  | backend     | 1    | 1          | 2022-12-12 00:00:00 |    2022-12-12 00:00:00        |
| 2   | Brain | frontend    | 3    | 2          | 2022-12-12 00:00:00                    |    2022-12-12 00:00:00        |

> worker_type could be: backend, frontend, architect, DevOps, ...


2. country databases: `company_{N}`

Dynamic databases of rows in `main.companies` table, which `{N}` would be `main.companies.id`, when a new company register in the system, needs to create `company_{N}` database and related tables.

tables: `settings`, `info`

3. cities databases: `worker_{worker_type}_{N}`

Each row in `main.workers` would have one dynamic database, let's say we have a worker, he's `worker_type` is `frontend` and `db_n` is 3, then the database name would be `worker_frontend_3`, and the tables in the database depends on the `worker_type`



### Solution 1 - laravel migration

Just straightly use laravel migration.
* Modify `main` database, just modify the static schema
* Modify `company_{N}`, loop every company and modify each schema
* Modify `worker_{worker_type}_{N}`, loop every worker and modify each schema

However, this solution can't record each database migrate record because databases are dynamically created.

### Solution 2 - custom migration

Migration files folder.

* main: `/migrations/main`
* companies: `/migrations/company`
* workers:
  * frontend: `/migrations/worker/fonrtend`
  * backend: `/migrations/worker/backend`
  * architect: `/migrations/worker/architect`

1. Custom migration schema

migration_main


| id  | file                                   | executed_at         |
|-----|----------------------------------------|---------------------|
| 1   | 2022_12_30_120000_create_workers_table | 2022:12:30 00:00:00 |


migration_companies


| id  | company_id | file                                    | executed_at         |
|-----|------------|-----------------------------------------|---------------------|
| 1   | 1          | 2022_12_30_120000_create_settings_table | 2022:12:30 00:00:00 |
| 2   | 2          |                    2022_12_30_120000_create_settings_table                     |             2022:12:30 00:00:00        |


migration_workers


| id  | worker_id | file                                 | executed_at         |
|-----|-----------|--------------------------------------|---------------------|
| 1   | 1         | 2022_12_30_120000_create_nosql_table | 2022:12:30 00:00:00 |
| 2   | 2         | 2022_12_30_120000_create_css_table   |             2022:12:30 00:00:00        |

migrations


| id  | migrate_type | migrate_id | type          | batch | created_at | updated_at |
|-----|--------------|------------|---------------|-------|------------|------------|
| 1   | main         | 1          | modify_schema | 1     |   2022:12:30 00:00:00         |     2022:12:30 00:00:00       |
| 2   | worker       | 1          | new           | 2     |  2022:12:30 00:00:00          |       2022:12:30 00:00:00     |

2. Create a custom migration command other than default

Commands go through each migration file and check if executed by different migration table, after run the migrations, insert migrate record into related tables, and all records need to stored in `migrations` table, which is the total migration table.


3. Insert related migration record when creating company or worker.

4. Rollback logic

After run some schema-modify migrations, we create a new company, but then we realize that the schema we modified last time is wrong, needs to rollback.

But if we just run the rollback files in last batch, we will lose the new company database we created.

That's why there's a `type` in `migrations` table, we only fetch last `batch` which `type` is `modify_schema`, scan all files executed in that batch, and run rollbacks for "every" companies and workers, then delete the migration files, so we can keep all database schema stay the same without losedata.