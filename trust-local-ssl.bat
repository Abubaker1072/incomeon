@echo off
echo Installing local SSL certificate as trusted (fixes "Not secure" in Chrome)...
echo.
certutil -addstore -user Root "C:\laragon\etc\ssl\laragon-local.crt"
if %ERRORLEVEL% EQU 0 (
    echo.
    echo SUCCESS! Close Chrome completely and reopen, then use:
    echo   https://incomeon_ecomm.test
    echo   https://localhost/Incomeon_ecomm
) else (
    echo.
    echo If this failed, right-click this file and choose "Run as administrator".
)
echo.
pause
