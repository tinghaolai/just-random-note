------------------------------------------------------------
-- CYBERPUNK HUD (FULL SAFE EDITION)
------------------------------------------------------------

hs.timer.doAfter(0, function()

    --------------------------------------------------------
    -- Screen Init (SAFE)
    --------------------------------------------------------
    local screenFrame = hs.screen.mainScreen():frame()
    local X, Y = screenFrame.x, screenFrame.y
    local W, H = screenFrame.w, screenFrame.h

    --------------------------------------------------------
    -- 🟡 Border (Main Frame)
    --------------------------------------------------------
    local BORDER_MAIN  = 4
    local BORDER_INNER = 2

    local YELLOW = { red=1.0, green=0.84, blue=0.0, alpha=1 }
    local BLACK  = { red=0.05, green=0.05, blue=0.05, alpha=0.95 }

    local border = hs.canvas.new({ x = X, y = Y, w = W, h = H })
    border:level(hs.canvas.windowLevels.overlay)
    border:behavior({
        hs.canvas.windowBehaviors.canJoinAllSpaces,
        hs.canvas.windowBehaviors.stationary,
        hs.canvas.windowBehaviors.ignoreClick,
    })

    local idx = 1
    local function rect(x,y,w,h,color)
        border[idx] = {
            type="rectangle", action="fill",
            frame={x=x, y=y, w=w, h=h},
            fillColor=color
        }
        idx = idx + 1
    end

    -- Outer yellow
    rect(0,0, W, BORDER_MAIN, YELLOW)
    rect(0, H-BORDER_MAIN, W, BORDER_MAIN, YELLOW)
    rect(0,0, BORDER_MAIN, H, YELLOW)
    rect(W-BORDER_MAIN,0, BORDER_MAIN, H, YELLOW)

    -- Inner black tech lines
    rect(0, BORDER_MAIN+1, W, BORDER_INNER, BLACK)
    rect(0, H-BORDER_MAIN-BORDER_INNER-1, W, BORDER_INNER, BLACK)
    rect(BORDER_MAIN+1, 0, BORDER_INNER, H, BLACK)
    rect(W-BORDER_MAIN-BORDER_INNER-1, 0, BORDER_INNER, H, BLACK)

    border:show()

    --------------------------------------------------------
    -- 🟡 Pulse Glow
    --------------------------------------------------------
    local pulseAlpha = 1
    local pulseDir = 1

    local function pulseBorder()
        pulseAlpha = pulseAlpha + 0.015 * pulseDir
        if pulseAlpha > 1.0 then pulseAlpha = 1.0 pulseDir = -1 end
        if pulseAlpha < 0.75 then pulseAlpha = 0.75 pulseDir = 1 end

        border[1].fillColor.alpha = pulseAlpha
        border[2].fillColor.alpha = pulseAlpha
        border[3].fillColor.alpha = pulseAlpha
        border[4].fillColor.alpha = pulseAlpha
    end

    _G.pulseTimer = hs.timer.doEvery(1/60, pulseBorder)

    --------------------------------------------------------
    -- 🟡 Scanline (Moving line)
    --------------------------------------------------------
    local scan = hs.canvas.new({ x = X, y = Y, w = W, h = H })
    scan:level(hs.canvas.windowLevels.overlay)
    scan:behavior({
        hs.canvas.windowBehaviors.canJoinAllSpaces,
        hs.canvas.windowBehaviors.stationary,
        hs.canvas.windowBehaviors.ignoreClick,
    })

    scan[1] = {
        type="rectangle",
        action="fill",
        fillColor={red=0, green=1, blue=1, alpha=0.12},
        frame={x=0, y=0, w=W, h=2}
    }

    scan:show()

    local scanY = 0
    local function updateScan()
        scanY = scanY + 4
        if scanY > H then scanY = -50 end
        scan[1].frame.y = scanY
    end

    _G.scanTimer = hs.timer.doEvery(1/60, updateScan)

    --------------------------------------------------------
    -- 🟡 Corner Moving Neon Wires
    --------------------------------------------------------
    local cornerFX = hs.canvas.new({ x = X, y = Y, w = W, h = H })
    cornerFX:level(hs.canvas.windowLevels.overlay)
    cornerFX:behavior({
        hs.canvas.windowBehaviors.canJoinAllSpaces,
        hs.canvas.windowBehaviors.stationary,
        hs.canvas.windowBehaviors.ignoreClick,
    })

    cornerFX[1] = { type="rectangle", fillColor={red=1,green=1,blue=0,alpha=0.6}, frame={x=0,   y=0,   w=60, h=2} }
    cornerFX[2] = { type="rectangle", fillColor={red=1,green=1,blue=0,alpha=0.6}, frame={x=W-60,y=0,   w=60, h=2} }
    cornerFX[3] = { type="rectangle", fillColor={red=1,green=1,blue=0,alpha=0.6}, frame={x=0,   y=H-2, w=60, h=2} }
    cornerFX[4] = { type="rectangle", fillColor={red=1,green=1,blue=0,alpha=0.6}, frame={x=W-60,y=H-2, w=60, h=2} }

    cornerFX:show()

    local cornerOffset = 0
    local function updateCornerFX()
        cornerOffset = (cornerOffset + 4) % 60
        cornerFX[1].frame.x = -cornerOffset
        cornerFX[2].frame.x = W-60 + cornerOffset
        cornerFX[3].frame.x = -cornerOffset
        cornerFX[4].frame.x = W-60 + cornerOffset
    end

    _G.cornerTimer = hs.timer.doEvery(1/60, updateCornerFX)

    --------------------------------------------------------
    -- 🟡 Horizontal Glitch (every 5 seconds)
    --------------------------------------------------------
    local glitch = hs.canvas.new({ x = X, y = Y, w = W, h = H })
    glitch:level(hs.canvas.windowLevels.overlay)
    glitch:behavior({
        hs.canvas.windowBehaviors.canJoinAllSpaces,
        hs.canvas.windowBehaviors.stationary,
        hs.canvas.windowBehaviors.ignoreClick,
    })

    local glitchCount = 20
    for i = 1, glitchCount do
        glitch[i] = {
            type="rectangle",
            action="fill",
            fillColor={red=1,green=1,blue=0,alpha=0},
            frame={x=0,y=0,w=0,h=0}
        }
    end

    glitch:show()

    local function triggerGlitch()
        for i = 1, glitchCount do
            local gy = math.random(0, H)
            local width = math.random(40,300)
            local gx = math.random(0, W-width)
            local gh = math.random(2,6)

            glitch[i].frame = { x=gx, y=gy, w=width, h=gh }
            glitch[i].fillColor = {
                red=0, green=1, blue=1,
                alpha=math.random(5,30)/100
            }
        end

        hs.timer.doAfter(0.04, function()
            for i = 1, glitchCount do glitch[i].fillColor.alpha = 0 end
        end)
    end

    local function glitchLoop()
        triggerGlitch()
        _G.glitchTimer = hs.timer.doAfter(5, glitchLoop)
    end

    glitchLoop()

    --------------------------------------------------------
    -- 🟡 Screen Shake FX
    --------------------------------------------------------
    local shakeLayers = { border, scan, cornerFX, glitch }

    local function screenShake()
        local shakes = math.random(7, 10)
        local count = 0

        local function doShake()
            count = count + 1
            if count > shakes then
                for _, layer in ipairs(shakeLayers) do layer:translate(0,0) end
                return
            end

            local dx = math.random(-4,4)
            local dy = math.random(-4,4)

            for _, layer in ipairs(shakeLayers) do layer:translate(dx,dy) end

            hs.timer.doAfter(0.015, doShake)
        end

        doShake()
    end

    _G.shakeTimer = hs.timer.doEvery(8, screenShake)  -- every 8 seconds


    --------------------------------------------------------
    -- 🟦🟪 CYBERPUNK SYSTEM HUD 2077 (CPU / RAM / SWAP)
    --------------------------------------------------------

    sysHUD = hs.canvas.new({
        x = X + W - 300,
        y = Y + 40,
        w = 240,
        h = 135
    })

    sysHUD:level(hs.canvas.windowLevels.overlay)
    sysHUD:behavior({
        hs.canvas.windowBehaviors.canJoinAllSpaces,
        hs.canvas.windowBehaviors.stationary,
        hs.canvas.windowBehaviors.ignoreClick,
    })

    --------------------------------------------------------
    -- 背景（深灰微透明霧面）
    --------------------------------------------------------
    sysHUD[1] = {
        type = "rectangle",
        action = "fill",
        fillColor = { red=0.05, green=0.05, blue=0.08, alpha=0.22 },
        frame = { x=0, y=0, w="100%", h="100%" },
        roundedRectRadii = { xRadius = 8, yRadius = 8 }
    }

    --------------------------------------------------------
    -- 外框：2077 螢光青藍
    --------------------------------------------------------
    sysHUD[2] = {
        type = "rectangle",
        action = "stroke",
        strokeColor = { red=0, green=1, blue=1, alpha=0.30 },
        strokeWidth = 2,
        frame = { x=0, y=0, w="100%", h="100%" },
        roundedRectRadii = { xRadius = 8, yRadius = 8 }
    }

    --------------------------------------------------------
    -- 科技水平線（淡青藍）
    --------------------------------------------------------
    local techLine = { red=0, green=1, blue=1, alpha=0.18 }

    sysHUD[3] = { type="rectangle", action="fill", fillColor=techLine, frame={x=0,y=45,w="100%",h=1} }
    sysHUD[4] = { type="rectangle", action="fill", fillColor=techLine, frame={x=0,y=75,w="100%",h=1} }
    sysHUD[5] = { type="rectangle", action="fill", fillColor=techLine, frame={x=0,y=105,w="100%",h=1} }

    --------------------------------------------------------
    -- Label：粉紫（Cyberpunk 次要文字）
    --------------------------------------------------------
    local labelColor = { red=1, green=0.3, blue=0.9, alpha=0.3 }

    sysHUD[6] = { type="text", text="cpu", textSize=11, textColor=labelColor, textFont = "Glitch Goblin",frame={x=10, y=15,  w=40, h=20} }
    sysHUD[7] = { type="text", text="ram", textSize=11, textColor=labelColor, textFont = "Glitch Goblin",frame={x=10, y=45, w=40, h=20} }
    sysHUD[8] = { type="text", text="swp", textSize=11, textColor=labelColor, textFont = "Glitch Goblin",frame={x=10, y=75, w=40, h=20} }

    --------------------------------------------------------
    -- 能量條（CPU Cyan / RAM Purple / SWAP Green）
    --------------------------------------------------------
    local barCPU  = { red=0,   green=1,   blue=1,   alpha=0.25 }
    local barRAM  = { red=1,   green=0.3, blue=0.9, alpha=0.25 }
    local barSWAP = { red=0.3, green=1,   blue=0.4, alpha=0.25 }

    sysHUD[9]  = { type="rectangle", action="fill", fillColor=barCPU,  frame={x=40, y=15, w=0, h=10} }
    sysHUD[10] = { type="rectangle", action="fill", fillColor=barRAM,  frame={x=40, y=45, w=0, h=10} }
    sysHUD[11] = { type="rectangle", action="fill", fillColor=barSWAP, frame={x=40, y=75, w=0, h=10} }

    --------------------------------------------------------
    -- 數字（亮青藍）
    --------------------------------------------------------
    local numberColor = { red=0, green=1, blue=1, alpha=0.45 }

    sysHUD[12] = { type="text", text="--%", textSize=12, textColor=numberColor, textFont = "Glitch Goblin",frame={x=185, y=13,  w=60, h=25} }
    sysHUD[13] = { type="text", text="--%", textSize=12, textColor=numberColor, textFont = "Glitch Goblin",frame={x=185, y=43, w=60, h=25} }
    sysHUD[14] = { type="text", text="--%", textSize=12, textColor=numberColor, textFont = "Glitch Goblin",frame={x=185, y=73, w=60, h=25} }

    sysHUD:show()

    --------------------------------------------------------
    -- 🟡 Non-blocking System Info (hs.task)
    --------------------------------------------------------
    local lastCPU, lastRAM, lastSWAP = 0, 0, 0

    local function updateCPU(callback)
        hs.task.new("/bin/sh", function(_, stdout)
            local v = tonumber(stdout)
            if v then lastCPU = math.floor(v) end
            callback(lastCPU)
        end, { "-c", "echo \"$(ps -A -o %cpu | awk '{sum+=$1} END {print sum}') / $(sysctl -n hw.ncpu)\" | bc -l" }):start()
    end

    local function updateRAM(callback)
        hs.task.new("/bin/sh", function(_, stdout)
            local free  = tonumber(stdout:match("Pages free:%s+(%d+)")) or 0
            local active = tonumber(stdout:match("Pages active:%s+(%d+)")) or 0
            local inactive = tonumber(stdout:match("Pages inactive:%s+(%d+)")) or 0
            local speculative = tonumber(stdout:match("Pages speculative:%s+(%d+)")) or 0
            local wired = tonumber(stdout:match("Pages wired down:%s+(%d+)")) or 0

            local used = active + inactive + speculative + wired
            local total = used + free
            lastRAM = math.floor((used / total) * 100)
            callback(lastRAM)
        end, { "-c", "vm_stat" }):start()
    end

    local function updateSWAP(callback)
        hs.task.new("/bin/sh", function(_, stdout)
            local used = stdout:match("used = ([%d%.]+)M")
            local total = stdout:match("total = ([%d%.]+)M")
            if used and total then
                local u = tonumber(used)
                local t = tonumber(total)
                lastSWAP = math.floor((u / t) * 100)
            end
            callback(lastSWAP)
        end, { "-c", "sysctl vm.swapusage" }):start()
    end

    --------------------------------------------------------
    -- HUD 更新 (你既有的 updateCPU / RAM / SWAP 用這裡)
    --------------------------------------------------------

    local function refreshHUD()
        updateCPU(function(v)
            sysHUD[12].text = string.format("%d%%", v)
            sysHUD[9].frame.w = math.floor(v * 1.2)
        end)

        updateRAM(function(v)
            sysHUD[13].text = string.format("%d%%", v)
            sysHUD[10].frame.w = math.floor(v * 1.2)
        end)

        updateSWAP(function(v)
            sysHUD[14].text = string.format("%d%%", v)
            sysHUD[11].frame.w = math.floor(v * 1.2)
        end)
    end


    _G.sysHUDTimer = hs.timer.doEvery(1, refreshHUD)

    refreshHUD()



end)
