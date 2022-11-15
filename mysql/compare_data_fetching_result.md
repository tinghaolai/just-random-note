## Compare data fetching result

Only for execute result, see note "Data fetching approaches" note.

Php code: "TestingCommand" note.

## Testing Table

Amount: 2917002

Schema
```php
Schema::connection('mysql')->create('members', function (Blueprint $table) {
    $table->increments('id');
    $table->string('member_id')->index('member_id');
    $table->integer('type')->index('type');
    $table->integer('status')->index('status');
    $table->string('name', 50);
    $table->string('gender', 50);
    $table->timestamps();
});
```

## Normal fetch

### Offset, limit 1000 (Extremely slow)

```php
$this->logExecuteTime($this->getMemberChunk(1000), 'fetch table 1000');
```
```
fetch 100000 row, count time: 2.2998418807983 seconds
fetch 100000 row, count time: 6.5963969230652 seconds
fetch 100000 row, count time: 11.04714512825 seconds
fetch 100000 row, count time: 15.235433101654 seconds
fetch 100000 row, count time: 19.307607889175 seconds
fetch 100000 row, count time: 23.27908205986 seconds
fetch 100000 row, count time: 27.751863002777 seconds
fetch 100000 row, count time: 31.606611013412 seconds
fetch 100000 row, count time: 36.006661891937 seconds
fetch 100000 row, count time: 39.824301958084 seconds
fetch 100000 row, count time: 44.387120008469 seconds
fetch 100000 row, count time: 48.999024152756 seconds
fetch 100000 row, count time: 53.434830904007 seconds
fetch 100000 row, count time: 56.882748842239 seconds
fetch 100000 row, count time: 61.521723031998 seconds
fetch 100000 row, count time: 65.602551937103 seconds
fetch 100000 row, count time: 69.90039896965 seconds
```

> take too long to finish, stop manually.

### Chunk by id, 1000 range (fast - almost the same)

```
fetch 100000 row, count time: 0.24750304222107 seconds
fetch 100000 row, count time: 0.21378803253174 seconds
fetch 100000 row, count time: 0.22857689857483 seconds
fetch 100000 row, count time: 0.21133518218994 seconds
fetch 100000 row, count time: 0.20405602455139 seconds
fetch 100000 row, count time: 0.20631790161133 seconds
fetch 100000 row, count time: 0.2042920589447 seconds
fetch 100000 row, count time: 0.19200396537781 seconds
fetch 100000 row, count time: 0.19640803337097 seconds
fetch 100000 row, count time: 0.19438195228577 seconds
fetch 100000 row, count time: 0.19260191917419 seconds
fetch 100000 row, count time: 0.19495797157288 seconds
fetch 100000 row, count time: 0.19311690330505 seconds
fetch 100000 row, count time: 0.20729994773865 seconds
fetch 100000 row, count time: 0.20123982429504 seconds
fetch 100000 row, count time: 0.2020218372345 seconds
fetch 100000 row, count time: 0.20326685905457 seconds
fetch 100000 row, count time: 0.20158195495605 seconds
fetch 100000 row, count time: 0.20736289024353 seconds
fetch 100000 row, count time: 0.21589589118958 seconds
fetch 100000 row, count time: 0.21570897102356 seconds
fetch 100000 row, count time: 0.22491097450256 seconds
fetch 100000 row, count time: 0.21244597434998 seconds
fetch 100000 row, count time: 0.22782492637634 seconds
fetch 100000 row, count time: 0.2052948474884 seconds
fetch 100000 row, count time: 0.20832014083862 seconds
fetch 100000 row, count time: 0.20711493492126 seconds
fetch 100000 row, count time: 0.21426510810852 seconds
fetch 100000 row, count time: 0.20813202857971 seconds
fetch table by id 1000 - execute time: 6.0780649185181 seconds
```

### Chunk by id, 5000 range (fast - almost the same)

```
fetch 100000 row, count time: 0.27593493461609 seconds
fetch 100000 row, count time: 0.17164421081543 seconds
fetch 100000 row, count time: 0.1705379486084 seconds
fetch 100000 row, count time: 0.16400218009949 seconds
fetch 100000 row, count time: 0.16095614433289 seconds
fetch 100000 row, count time: 0.15906715393066 seconds
fetch 100000 row, count time: 0.16972517967224 seconds
fetch 100000 row, count time: 0.15818190574646 seconds
fetch 100000 row, count time: 0.15861415863037 seconds
fetch 100000 row, count time: 0.15846109390259 seconds
fetch 100000 row, count time: 0.16001892089844 seconds
fetch 100000 row, count time: 0.16062903404236 seconds
fetch 100000 row, count time: 0.16577291488647 seconds
fetch 100000 row, count time: 0.16692209243774 seconds
fetch 100000 row, count time: 0.16570591926575 seconds
fetch 100000 row, count time: 0.16400289535522 seconds
fetch 100000 row, count time: 0.16548299789429 seconds
fetch 100000 row, count time: 0.16606903076172 seconds
fetch 100000 row, count time: 0.17445707321167 seconds
fetch 100000 row, count time: 0.18989396095276 seconds
fetch 100000 row, count time: 0.20608401298523 seconds
fetch 100000 row, count time: 0.17291593551636 seconds
fetch 100000 row, count time: 0.17146992683411 seconds
fetch 100000 row, count time: 0.17884492874146 seconds
fetch 100000 row, count time: 0.18523597717285 seconds
fetch 100000 row, count time: 0.27252697944641 seconds
fetch 100000 row, count time: 0.29647994041443 seconds
fetch 100000 row, count time: 0.29528093338013 seconds
fetch 100000 row, count time: 0.22976112365723 seconds
fetch table by id 5000 - execute time: 5.4961647987366 seconds
```

### Chunk by id, 10000 range (fast - almost the same)

```
fetch 100000 row, count time: 0.2275869846344 seconds
fetch 100000 row, count time: 0.25944495201111 seconds
fetch 100000 row, count time: 0.25605297088623 seconds
fetch 100000 row, count time: 0.24321007728577 seconds
fetch 100000 row, count time: 0.19769406318665 seconds
fetch 100000 row, count time: 0.18686294555664 seconds
fetch 100000 row, count time: 0.23525810241699 seconds
fetch 100000 row, count time: 0.18954396247864 seconds
fetch 100000 row, count time: 0.18641901016235 seconds
fetch 100000 row, count time: 0.19013905525208 seconds
fetch 100000 row, count time: 0.18650603294373 seconds
fetch 100000 row, count time: 0.18904590606689 seconds
fetch 100000 row, count time: 0.1938579082489 seconds
fetch 100000 row, count time: 0.18800401687622 seconds
fetch 100000 row, count time: 0.19141411781311 seconds
fetch 100000 row, count time: 0.18918299674988 seconds
fetch 100000 row, count time: 0.2194390296936 seconds
fetch 100000 row, count time: 0.2086980342865 seconds
fetch 100000 row, count time: 0.24641394615173 seconds
fetch 100000 row, count time: 0.30808305740356 seconds
fetch 100000 row, count time: 0.29457211494446 seconds
fetch 100000 row, count time: 0.26546096801758 seconds
fetch 100000 row, count time: 0.29202914237976 seconds
fetch 100000 row, count time: 0.27137899398804 seconds
fetch 100000 row, count time: 0.30417084693909 seconds
fetch 100000 row, count time: 0.21565699577332 seconds
fetch 100000 row, count time: 0.21656084060669 seconds
fetch 100000 row, count time: 0.21127986907959 seconds
fetch 100000 row, count time: 0.20304012298584 seconds
fetch table by id 10000 - execute time: 6.6090080738068 seconds
```

## Condition Fetch

```php
$this->logExecuteTime($this->getMemberChunk(1000, 'chunk', $builder), 'Chunk 1000');
```

### Offset, limit 1000 (Extremely slow)

```
fetch 100000 row, count time: 10.394927024841 seconds
fetch 100000 row, count time: 26.420655012131 seconds
fetch 100000 row, count time: 43.611160039902 seconds
fetch 100000 row, count time: 61.397556066513 seconds
fetch 100000 row, count time: 80.02476477623 seconds
fetch 100000 row, count time: 100.24944901466 seconds
```

> execution abort due to execution too long.

### Chunk by id, 1000 range (fast, but slow compare to bigger size chunk)

```
fetch 100000 row, count time: 0.3095600605011 seconds
fetch 100000 row, count time: 0.28217816352844 seconds
fetch 100000 row, count time: 0.26526403427124 seconds
fetch 100000 row, count time: 0.26775002479553 seconds
fetch 100000 row, count time: 0.2894229888916 seconds
fetch 100000 row, count time: 0.27098298072815 seconds
fetch 100000 row, count time: 0.31184005737305 seconds
fetch 100000 row, count time: 0.35389614105225 seconds
fetch 100000 row, count time: 0.35073208808899 seconds
fetch 100000 row, count time: 0.34882020950317 seconds
fetch 100000 row, count time: 0.34853005409241 seconds
fetch 100000 row, count time: 0.3736720085144 seconds
fetch 100000 row, count time: 0.3514130115509 seconds
fetch 100000 row, count time: 0.34284090995789 seconds
fetch 100000 row, count time: 0.33493089675903 seconds
fetch 100000 row, count time: 0.30188202857971 seconds
fetch 100000 row, count time: 0.28313708305359 seconds
fetch 100000 row, count time: 0.3196268081665 seconds
fetch 100000 row, count time: 0.34471297264099 seconds
fetch 100000 row, count time: 0.34091806411743 seconds
fetch 100000 row, count time: 0.34262919425964 seconds
fetch 100000 row, count time: 0.3236289024353 seconds
fetch 100000 row, count time: 0.33198404312134 seconds
fetch 100000 row, count time: 0.34406805038452 seconds
fetch 100000 row, count time: 0.34131598472595 seconds
fetch 100000 row, count time: 0.33037996292114 seconds
fetch 100000 row, count time: 0.3716561794281 seconds
fetch 100000 row, count time: 4.7944350242615 seconds
fetch 100000 row, count time: 2.2877190113068 seconds
ChunkById 1000 - execute time: 16.417853832245 seconds
```

### Chunk by id, 5000 range (fast)

```
fetch 100000 row, count time: 0.24204802513123 seconds
fetch 100000 row, count time: 0.23468995094299 seconds
fetch 100000 row, count time: 0.2108211517334 seconds
fetch 100000 row, count time: 0.22093200683594 seconds
fetch 100000 row, count time: 0.25376105308533 seconds
fetch 100000 row, count time: 0.22294116020203 seconds
fetch 100000 row, count time: 0.27257704734802 seconds
fetch 100000 row, count time: 0.293869972229 seconds
fetch 100000 row, count time: 0.30048799514771 seconds
fetch 100000 row, count time: 0.36397194862366 seconds
fetch 100000 row, count time: 0.28891277313232 seconds
fetch 100000 row, count time: 0.27458310127258 seconds
fetch 100000 row, count time: 0.2968430519104 seconds
fetch 100000 row, count time: 0.27091598510742 seconds
fetch 100000 row, count time: 0.29139113426208 seconds
fetch 100000 row, count time: 0.30380082130432 seconds
fetch 100000 row, count time: 0.32168292999268 seconds
fetch 100000 row, count time: 0.23668599128723 seconds
fetch 100000 row, count time: 0.29856014251709 seconds
fetch 100000 row, count time: 0.29529905319214 seconds
fetch 100000 row, count time: 0.2852029800415 seconds
fetch 100000 row, count time: 0.29266405105591 seconds
fetch 100000 row, count time: 0.2845630645752 seconds
fetch 100000 row, count time: 0.28920006752014 seconds
fetch 100000 row, count time: 0.30160808563232 seconds
fetch 100000 row, count time: 0.28274202346802 seconds
fetch 100000 row, count time: 0.27577900886536 seconds
fetch 100000 row, count time: 0.9651780128479 seconds
fetch 100000 row, count time: 1.5894229412079 seconds
ChunkById 5000 - execute time: 10.234742879868 seconds
```

### Chunk by id, 5000 range (fastest)

```
fetch 100000 row, count time: 0.24541401863098 seconds
fetch 100000 row, count time: 0.22007894515991 seconds
fetch 100000 row, count time: 0.21023392677307 seconds
fetch 100000 row, count time: 0.20553207397461 seconds
fetch 100000 row, count time: 0.21999096870422 seconds
fetch 100000 row, count time: 0.21814393997192 seconds
fetch 100000 row, count time: 0.27208280563354 seconds
fetch 100000 row, count time: 0.26737213134766 seconds
fetch 100000 row, count time: 0.25580215454102 seconds
fetch 100000 row, count time: 0.26050615310669 seconds
fetch 100000 row, count time: 0.30824708938599 seconds
fetch 100000 row, count time: 0.25807404518127 seconds
fetch 100000 row, count time: 0.25963687896729 seconds
fetch 100000 row, count time: 0.25373888015747 seconds
fetch 100000 row, count time: 0.26094698905945 seconds
fetch 100000 row, count time: 0.25655698776245 seconds
fetch 100000 row, count time: 0.2525680065155 seconds
fetch 100000 row, count time: 0.2347948551178 seconds
fetch 100000 row, count time: 0.2538001537323 seconds
fetch 100000 row, count time: 0.25703191757202 seconds
fetch 100000 row, count time: 0.25661492347717 seconds
fetch 100000 row, count time: 0.26165199279785 seconds
fetch 100000 row, count time: 0.25034213066101 seconds
fetch 100000 row, count time: 0.24878406524658 seconds
fetch 100000 row, count time: 0.24774098396301 seconds
fetch 100000 row, count time: 0.25133514404297 seconds
fetch 100000 row, count time: 0.24485993385315 seconds
fetch 100000 row, count time: 0.60160803794861 seconds
fetch 100000 row, count time: 0.76865196228027 seconds
ChunkById 10000 - execute time: 8.2165420055389 seconds
```

### From temp table (extremely slow, but still faster than offset-limit approach)

```
create form sub table - execute time: 61.187281131744 seconds
```

## Complex Condition Fetch


```php
$this->logExecuteTime($this->getMemberChunk(3000, 'chunkById', $builder), 'ChunkById 3000');
```

### Chunk by id, 5000 range (slow, but stable, ...but slow)

```
fetch 3000 row, count time: 28.994568109512 seconds
fetch 3000 row, count time: 19.683982133865 seconds
fetch 3000 row, count time: 20.317237854004 seconds
fetch 3000 row, count time: 20.67226600647 seconds
fetch 3000 row, count time: 20.014378070831 seconds
fetch 3000 row, count time: 19.959398984909 seconds
fetch 3000 row, count time: 20.623891115189 seconds
fetch 3000 row, count time: 19.488153934479 seconds
fetch 3000 row, count time: 20.154536008835 seconds
fetch 3000 row, count time: 20.53445982933 seconds
fetch 3000 row, count time: 19.55899810791 seconds
fetch 3000 row, count time: 19.758750915527 seconds
fetch 3000 row, count time: 20.192777872086 seconds
fetch 3000 row, count time: 19.733059167862 seconds
fetch 3000 row, count time: 19.78969502449 seconds
fetch 3000 row, count time: 20.029559850693 seconds
fetch 3000 row, count time: 20.363671064377 seconds
fetch 3000 row, count time: 20.605259895325 seconds
fetch 3000 row, count time: 20.015105962753 seconds
fetch 3000 row, count time: 19.179614067078 seconds
fetch 3000 row, count time: 19.415316104889 seconds
fetch 3000 row, count time: 19.810880899429 seconds
fetch 3000 row, count time: 19.365759849548 seconds
fetch 3000 row, count time: 19.587288856506 seconds
fetch 3000 row, count time: 19.962892055511 seconds
fetch 3000 row, count time: 19.859379053116 seconds
fetch 3000 row, count time: 19.281220912933 seconds
fetch 3000 row, count time: 19.766294956207 seconds
fetch 3000 row, count time: 20.943511962891 seconds
fetch 3000 row, count time: 19.568754911423 seconds
fetch 3000 row, count time: 19.477322101593 seconds
fetch 3000 row, count time: 18.966747999191 seconds
fetch 3000 row, count time: 19.268923044205 seconds
```

> for 2m data, need about 3.5 hours.

### Temp table (extremely fast compares to chunk approach)

```
create temp member table - execute time: 62.405543088913 seconds
fetch 3000 row, count time: 0.045839786529541 seconds
...
...
...
create form sub table - execute time: 69.337910890579 seconds (fethcing whole table by chunk)
```
