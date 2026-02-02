# 🚀 Como Iniciar o Servidor IAGUS

## ⚠️ O Herd foi instalado mas o terminal não o reconhece?

Isso é normal! Existem 2 soluções simples:

---

## ✅ SOLUÇÃO 1: Use o PowerShell (MAIS FÁCIL!)

1. **Abra o PowerShell:**
   - Pressione `Windows + X`
   - Clique em "Windows PowerShell" ou "Terminal"

2. **Navegue até a pasta:**
   ```powershell
   cd D:\CORUZEN\WEBCODER
   ```

3. **Execute o script:**
   ```powershell
   .\start-powershell.ps1
   ```

   Se der erro de política de execução:
   ```powershell
   Set-ExecutionPolicy -Scope Process -ExecutionPolicy Bypass
   .\start-powershell.ps1
   ```

**Pronto! ✅** O servidor vai iniciar!

---

## ✅ SOLUÇÃO 2: Abra o Herd primeiro

1. **Abra o aplicativo Herd** (ícone na bandeja do Windows)
2. **Verifique se está rodando**
3. **Reinicie o computador** (isso adiciona o Herd ao PATH)
4. **Abra um NOVO terminal**
5. **Execute:**
   ```bash
   ./start.sh
   ```

---

## ✅ SOLUÇÃO 3: Use o CMD (Prompt de Comando)

1. **Abra o CMD:**
   - Pressione `Windows + R`
   - Digite `cmd` e Enter

2. **Navegue até a pasta:**
   ```cmd
   cd /d D:\CORUZEN\WEBCODER
   ```

3. **Execute:**
   ```cmd
   start.bat
   ```

---

## 🎯 Após Iniciar

Acesse no navegador:
- **Site:** http://localhost:8000
- **Admin:** admin@iagus.org.br / iagus2026

---

## 🆘 Ainda com problemas?

**Opção mais simples:**

Abra o **PowerShell** e execute:
```powershell
cd D:\CORUZEN\WEBCODER
.\start-powershell.ps1
```

Isso vai funcionar independente do PATH! 🚀
