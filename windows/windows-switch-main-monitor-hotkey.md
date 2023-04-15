<!--HugoNoteFlag-->

---


## Windows switch main monitor hotkey
### Situation

We don't have adjustable table in our office, my solution is plug extra devices for my laptop, when I'm standing to use laptop, using two monitors, keyboard and mouse, then, when I sit working, use another two monitors and other devices.

In this way, I can switch the way me stand or sit working, but here's one problem is that only one main monitor, when using non-main monitor, there's some windows feature can't see in non-main monitor.

### Solution 

Using `nircmd`.

* install `nircmd`
* write `.bat` to switch main monitor
    * example: `switch-monitor.bat`
      ```shell
      @echo off
      cd "C:\__app\nircmd-x64"
      nircmd.exe setprimarydisplay 1
      ```
    * second line is the folder where you store `micrmdc.exe`
    * setprimarydisplay {{ monitorNumber }}, which monitor number can be seen in display setting
* run `.bat` file in cmd or hotkey
* Finally using `AutoHotkey` to execute `.bat` file
  * AHK example
    ```shell
        ;when stand up, use monitor 1 as main monitor
        !u::
        Run C:\__app\nircmd-x64\su.bat
        return
        
        ;when sit down, use monitor 1 as main monitor
        !d::
        Run C:\__app\nircmd-x64\sd.bat
        return
    ```
   > Press alt+u / alt+d to switch main monitor


---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## Windows切換主要顯示器快捷鍵
### 情況

我們辦公室沒有可調節的桌子，我的解決方案是為我的筆記本電腦插入額外的設備，當我站著使用筆記本電腦時，使用兩個顯示器、鍵盤和滑鼠，然後當我坐下工作時，使用另外兩個顯示器和其他設備。

這樣，我可以切換我工作時站立或坐著的方式，但這裡有一個問題，那就是只有一個主要顯示器，當使用非主要顯示器時，一些Windows功能無法在非主要顯示器上看到。

### 解決方案

使用 `nircmd`。

* 安裝 `nircmd`
* 編寫 `.bat` 切換主要顯示器
    * 例如： `switch-monitor.bat`
      ```shell
      @echo off
      cd "C:\__app\nircmd-x64"
      nircmd.exe setprimarydisplay 1
      ```
    * 第二行是存儲 `micrmdc.exe` 的資料夾 
    * setprimarydisplay {{ monitorNumber }}, 監視器編號可以在顯示設定中查看
* 在 cmd 或快捷鍵中運行 `.bat` 檔案
* 最後使用 `AutoHotkey` 執行 `.bat` 檔案
  * AHK示例
    ```shell
        ;當站起時，使用第1個顯示器為主要顯示器
        !u::
        Run C:\__app\nircmd-x64\su.bat
        return
        
        ;當坐下時，使用第1個顯示器為主要顯示器
        !d::
        Run C:\__app\nircmd-x64\sd.bat
        return
    ```
   > 按下alt+u / alt+d 鍵可切換主要顯示器