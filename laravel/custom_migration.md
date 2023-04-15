<!--HugoNoteFlag-->

---


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


---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## 自定義遷移（概念）

當數據庫和表是靜態的時候，Laravel 遷移就足以實現遷移需求。

但是如果數據庫和表是動態的，就會有一些問題。

* 每當動態表模式更改時需要遷移記錄
* 創建動態表時需要遷移記錄
* 數據庫遷移進度不同，需要如何回滾？

### 動態數據庫方案

1. 主數據庫：`main`

該數據庫的表是靜態的。

表格：`companies`, `workers`

工人架構

| id  | name  | worker_type | db_n | company_id | created_at          | updated_at |
|-----|-------|-------------|------|------------|---------------------|------------|
| 1   | Tony  | backend     | 1    | 1          | 2022-12-12 00:00:00 |    2022-12-12 00:00:00        |
| 2   | Brain | frontend    | 3    | 2          | 2022-12-12 00:00:00                    |    2022-12-12 00:00:00        |

> 選擇的工人類型可以是：backend、frontend、architect、DevOps...

2. 國家數據庫：`company_{N}`

在 `main.companies` 表中的行有動態數據庫，`{N}` 將是 `main.companies.id`，當新公司在系統中註冊時，需要創建 `company_{N}` 數據庫和相關表格。

表格：`settings`、`info`

3. 城市數據庫：`worker_{worker_type}_{N}`

`main.workers` 中的每一行都會有一個動態數據庫，假設我們有一個工人，他的 `worker_type` 是 `frontend`，`db_n` 是 3，則數據庫名稱將是 `worker_frontend_3`，數據庫中的表格取決於 `worker_type`。

### 解決方案 1 - Laravel 遷移

直接使用 Laravel 遷移。
* 修改 `main` 數據庫，只需修改靜態模式
* 修改 `company_{N}`，循環每個公司並修改每個模式
* 修改 `worker_{worker_type}_{N}`，循環每個工人並修改每個模式

然而，此解決方案無法記錄每個數據庫遷移記錄，因為數據庫是動態創建的。

### 解決方案 2 - 自定義遷移

遷移文件夾。

* main：`/migrations/main`
* companies：`/migrations/company`
* workers：
  * frontend：`/migrations/worker/fonrtend`
  * backend：`/migrations/worker/backend`
  * architect：`/migrations/worker/architect`

1. 自定義遷移模式

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

遷移


| id  | migrate_type | migrate_id | type          | batch | created_at | updated_at |
|-----|--------------|------------|---------------|-------|------------|------------|
| 1   | main         | 1          | modify_schema | 1     |   2022:12:30 00:00:00         |     2022:12:30 00:00:00       |
| 2   | worker       | 1          | new           | 2     |  2022:12:30 00:00:00          |       2022:12:30 00:00:00     |

2. 創建一個自定義遷移命令

遍歷每個遷移文件，檢查是否由不同的遷移表執行，運行遷移後，將遷移記錄插入相關表格，所有記錄都需要存儲在 `migrations` 表格中，這是總遷移表格。

3. 創建公司或工人時插入相關遷移記錄。

4. 回滾邏輯

在運行某些模式修改遷移後，我們創建了一個新的公司，但隨後我們意識到上次修改的模式是錯誤的，需要回滾。

但是，如果我們僅運行上一批次的回滾文件，我們將失去我們創建的新公司數據庫。

這就是為什麼 `migrations` 表格中有一個 `type`，我們只提取上一個 `batch`，其中 `type` 為 `modify_schema`，掃描在該批次中執行的所有文件，並為“每個”公司和工人運行回滾，然後刪除遷移文件，這樣我們可以保持所有數據庫模式保持不變而不失數據。