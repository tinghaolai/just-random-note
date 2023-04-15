<!--HugoNoteFlag-->

---

## Ignore

If you are working on a big project, and you have lots of file or change don't want to commit, such as testing code or something makes development easier, then when you want to make a commit, You have to pick the files you want to commit instead of the changes for develop.

This could take lots of time to do that especially you don't have some powerful IDE such as JetBrain's commit UI, There's my own way to do that: Ignore manually.

### Ignore manually

1. Find the files you don't want to commit.
2. Save the reset command to someplace to copy it when needed
    * `git reset App\TestA.php App\TestB.php public\index.js`
3. When u need to commit all current change, run `git add .`
4. Run the reset command copied


---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## 忽略文件

如果你在進行一個大型專案的開發，你可能會有許多不想提交的文件或更改，例如測試代碼或其他使開發更輕鬆的東西。當你想進行提交時，你必須挑選你想要提交的文件，而不是開發所做的更改。

這可能需要很長時間，特別是如果你沒有像JetBrain的提交UI這樣強大的IDE。這裡有一種我自己的方法：手動忽略。

### 手動忽略

1. 找出你不想提交的文件。
2. 把重置命令保存在一個地方，以便在需要時複製它
    * `git reset App\TestA.php App\TestB.php public\index.js`
3. 當你需要提交所有當前更改時，運行`git add .`
4. 運行複製的重置命令。