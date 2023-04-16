<!--HugoNoteFlag-->

---

## Conclusion

Limit about 200 million rows for recommendation,

the actual number of rows depends on the size of the data.

## Reason

Due to the B+ tree,

the more rows, 

the more layers b+ tree has,

and it means more I/O reading.



---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## 結論

對於建議，限制約為 2 億行，實際行數取決於數據大小。

## 原因

由於 B+ 樹的存在，

行數越多，B+ 樹的層數也會越多，

這會導致更多的 I/O 讀取。