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