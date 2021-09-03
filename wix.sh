#!/bin/bash
mkdir -p $1/{css/{user,admin},img/{avatars,buttons,products,pets},js/{validations,effects},tpl,php}
cd $1
echo $2 | cat > index.php
cd css
echo | cat > user/estilo.css
echo | cat > admin/estilo.css
cd ../js/validations
echo | cat > login.js
echo | cat > register.js
echo | cat > ../effects/panels.js
cd ../../tpl
echo | cat > main.tpl
echo | cat > login.tpl
echo | cat > register.tpl
echo | cat > panel.tpl
echo | cat > profile.tpl
echo | cat > crud.tpl
cd ../php
echo | cat > create.php  
echo | cat > update.php
echo | cat > delete.php 
echo | cat > dbconect.php
cd ../../
echo "La web se ha creado correctamente"