/* 懸停時文字抖動（Hacker Vibe） */

a:hover, button:hover {
    animation: glitch 0.2s infinite;
  }
  @keyframes glitch {
    0% { transform: translate(0, 0); }
    20% { transform: translate(-1px, 1px); }
    40% { transform: translate(1px, -1px); }
    60% { transform: translate(-1px, -1px); }
    80% { transform: translate(1px, 1px); }
    100% { transform: translate(0, 0); }
  }


/* 字體切換成駭客風格（無背景） */

* {
    font-family: 'JetBrains Mono', 'Fira Code', monospace !important;
    letter-spacing: 0.5px !important;
  }
  h1, h2, h3 {
    font-weight: 600 !important;
    color: #00ffff !important;
  }
/* 滑鼠互動特效（hover 發光） */

a:hover, button:hover {
    color: #ff00ff !important;
    text-shadow: 0 0 8px #ff00ff, 0 0 15px #00ffff !important;
    transition: all 0.1s ease-out;
  }

/* 柔光螢光邊線 + 與內容的距離 */
* {
  outline: 0.3px solid rgba(255, 0, 255, 0.08) !important;
  outline-offset: 2px !important; /* 🔹 這就是「outline 的 padding」 */
  transition:
    outline-color 0.25s ease-in-out,
    outline-width 0.25s ease-in-out,
    outline-offset 0.25s ease-in-out;
}

*:hover {
  outline: 0.6px solid rgba(0, 255, 255, 0.25) !important;
  outline-offset: 3px !important; /* hover 時稍微外擴，感覺更立體 */
}


/*左下一個閃爍游標*/

body::after {
    content: "▋";
    color: #00ffff;
    font-weight: bold;
    font-size: 18px;
    position: fixed;
    bottom: 8px;
    left: 8px;
    animation: blink 1s step-end infinite;
    pointer-events: none;
    z-index: 9999;
  }

  @keyframes blink {
    50% { opacity: 0; }
  }
  

/* 打字時震動閃爍 */

input, textarea {
    background-color: #000 !important;
    color: #00ffff !important;
    border: 1px solid #00ffff !important;
    font-family: 'JetBrains Mono', monospace !important;
    font-size: 16px !important;
    caret-color: #ff00ff !important;
    text-shadow: 0 0 4px #00ffff, 0 0 8px #ff00ff !important;
    animation: idle-glow 3s ease-in-out infinite alternate;
  }

  input:focus, textarea:focus {
    animation: typing-glow 0.15s infinite alternate;
    box-shadow: 0 0 8px #00ffff, 0 0 15px #ff00ff !important;
  }

  @keyframes idle-glow {
    50% { text-shadow: 0 0 2px #00ffff, 0 0 4px #ff00ff; }
  }

  @keyframes typing-glow {
    0%, 100% { text-shadow: 0 0 2px #00ffff, 0 0 8px #ff00ff; transform: translateX(0); }
    50% { text-shadow: 0 0 6px #00ffff, 0 0 12px #ff00ff; transform: translateX(0.5px); }
  }
  

/* 螢光邊框效果（Neon Borders） */

button, input, textarea, select, [role="button"] {
    border: 1px solid #00ffff !important;
    box-shadow: 0 0 5px #00ffff, 0 0 10px #ff00ff !important;
    color: #ffffff !important;
    font-family: 'JetBrains Mono', monospace !important;
    transition: all 0.2s ease-out !important;
  }
  button:hover, input:focus {
    box-shadow: 0 0 10px #ff00ff, 0 0 20px #00ffff !important;
  }


/* p段落閃爍符號  */

p {
  display: inline-block;
  border-right: 2px solid #00ffff;
  font-family: 'JetBrains Mono', monospace !important;
  color: #00ffff !important;
  text-shadow: 0 0 4px #00ffff, 0 0 8px #ff00ff !important;
  animation: blink 0.8s step-end infinite alternate;
}

@keyframes blink {
  50% { border-color: transparent; }
}