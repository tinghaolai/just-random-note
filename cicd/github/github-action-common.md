<!--HugoNoteFlag-->

---

### the input device is not a TTY

example: 
```bash
docker-compose exec app /app/migrate migrate
```

Solution: add `-T` to the command
```bash
docker-compose exec -T app /app/migrate migrate
```

### Make register image public

I really thank Github's UI/UX team, 

they make me to write this note,

for just modify the visibility.

1. Go to the organization page
    * Not from the repository page
    * Note from the package page
2. Go to the settings page
    * If there's no `packages` tab, then you're in th wrong place
3. Then modify the visibility

Or just replace the url like this

https://github.com/organizations/streaming-data-architecture/settings/packages



---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

### 輸入設備不是 TTY

範例：
```bash
docker-compose exec app /app/migrate migrate
```

解決方案：在指令中加入 `-T`
```bash
docker-compose exec -T app /app/migrate migrate
```

### 將註冊圖片公開化

非常感謝 Github 的 UI/UX 團隊，

他們讓我撰寫此筆記，

只是為了修改可見度。

1. 前往組織頁面
    * 不是從存儲庫頁面
    * 注意來自套件頁面
2. 前往設置頁面
    * 如果沒有 `packages` 標籤，那麼你就在錯誤的地方
3. 然後修改可見度

或者只需像這樣替換 URL

https://github.com/organizations/streaming-data-architecture/settings/packages