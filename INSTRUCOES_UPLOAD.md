# ARQUIVOS PARA FAZER UPLOAD URGENTE

## 1. app/Providers/CompatibilityServiceProvider.php
Versão COMPLETA com cache, view, encrypter, files e maintenance mode.
**SOBRESCREVER** o arquivo existente.

## 2. bootstrap/app.php  
Versão que registra o CompatibilityServiceProvider corretamente.
**SOBRESCREVER** o arquivo existente.

## 3. Após upload, acessar:
http://iagus.com.br/limpar-cache.php

## 4. Depois testar:
http://iagus.com.br

---

Se ainda der erro, deletar TODOS os arquivos de:
- /home1/abdonc73/iagus.com.br/bootstrap/cache/
- /home1/abdonc73/iagus.com.br/storage/framework/cache/
- /home1/abdonc73/iagus.com.br/storage/framework/views/
