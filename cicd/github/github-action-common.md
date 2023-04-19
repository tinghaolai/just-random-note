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



---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

### 輸入設備不是TTY

範例： 
```bash
docker-compose exec app /app/migrate migrate
```

解決方法：在指令中加入 `-T` 
```bash
docker-compose exec -T app /app/migrate migrate
```