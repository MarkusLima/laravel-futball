#!/bin/bash

# Exibe uma mensagem informando que a otimização começou
echo "Otimizando a aplicação Laravel..."

# Navega até o diretório do projeto (se necessário)
# cd /caminho/do/seu/projeto

# Limpa o cache de configuração, roteamento e visualizações
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear

# Remove a pasta bootstrap/cache se necessário
rm -rf bootstrap/cache/*

# Recria o cache de configuração e otimiza a aplicação
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Exibe uma mensagem informando que o processo foi concluído
echo "Otimização concluída com sucesso!"


# chmod +x optimize.sh
# ./optimize.sh