#!/bin/bash

echo "🚀 Initialisation du projet Git Symfony Wonder"

# Étape 1 : Créer le .gitignore
cat <<EOL > .gitignore
# Composer
/vendor/
/composer.lock

# Symfony
/var/
/.env.local
.env.*.local
.env.local.php

# IDE & système
*.swp
*.swo
.idea/
/.vscode/
/.DS_Store
Thumbs.db

# Node/Webpack
/node_modules/
/public/build/
/public/bundles/

# Log et cache
*.log
/log/
/cache/

# Tests
/phpunit.result.cache

# Autres fichiers sensibles
/private/
/config/secrets/prod/prod.decrypt.private.php
EOL

echo "✅ .gitignore créé."

# Étape 2 : Initialiser Git
git init
git add .
git commit -m "🔧 Initialisation du projet Wonder (version 1)"
echo "✅ Dépôt Git initialisé et commité."

# Étape 3 : Demander le remote
read -p "🔗 Entre l'URL du dépôt distant (GitHub SSH de préférence) : " remote_url
git remote add origin "$remote_url"
echo "✅ Remote ajouté : $remote_url"

# Étape 4 : Créer les branches versionnées
git branch -M version-1
git push -u origin version-1

for version in 2 3 4; do
  git checkout -b version-$version
  git push -u origin version-$version
done

git checkout version-1
echo "✅ Branches version-1 à version-4 créées et poussées."

echo "🎉 Tout est prêt ! Tu peux bosser tranquillement sur chaque version depuis sa branche dédiée 😎"
