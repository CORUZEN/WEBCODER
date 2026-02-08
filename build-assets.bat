@echo off
echo Verificando Node.js e npm...
node --version
npm --version

echo.
echo Instalando dependencias npm...
call npm install

echo.
echo Compilando assets...
call npm run build

echo.
echo Assets compilados com sucesso!
pause
