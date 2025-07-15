```bash
function testA {
            Write-Host "this is testA 2" -ForegroundColor Cyan
}

function aaa {
            Get-Content $PROFILE
}

function vimrc { vim $PROFILE }
function sourcerc { . $PROFILE }
function cdgit { Set-Location "C:\git" }
```