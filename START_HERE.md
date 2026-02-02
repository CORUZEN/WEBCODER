# 🚀 Guia Rápido de Início

## Iniciar o Servidor

### Windows
```bash
start.bat
```

### Linux/Mac
```bash
chmod +x start.sh
./start.sh
```

## O script irá:
1. ✅ Verificar e encerrar portas em uso (8000 e 5173)
2. ✅ Limpar todo o cache do Laravel
3. ✅ Criar arquivo .env se não existir
4. ✅ Otimizar o autoloader
5. ✅ Iniciar Vite (frontend com hot reload)
6. ✅ Iniciar servidor Laravel

## Acessos

- **Aplicação:** http://localhost:8000
- **Admin:** admin@iagus.org.br / iagus2026
- **User:** joao@example.com / password

## Primeira Execução

Se for a primeira vez, configure o banco de dados no `.env` e execute:

```bash
php artisan migrate --seed
```

## Comandos Úteis

```bash
# Parar o servidor
Ctrl + C

# Limpar cache manualmente
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Resetar banco de dados
php artisan migrate:fresh --seed

# Compilar assets para produção
npm run build
```

## Troubleshooting

**Erro de porta em uso:**
- Execute `start.bat` ou `start.sh` novamente (ele mata automaticamente)

**Erro de banco de dados:**
- Configure as credenciais no arquivo `.env`
- Execute `php artisan migrate --seed`

**Assets não carregam:**
- Verifique se o Vite está rodando (porta 5173)
- Execute `npm run dev` manualmente se necessário

---

**Pronto para desenvolver! 🎉**
