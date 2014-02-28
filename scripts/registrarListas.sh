#!/bin/bash

# Este script está hecho para registrar listas de usuarios
# e insertarlos en sus respectivos grupos.
# 
# Se deben respetar la siguiente estructura:
# El archivo csv tiene que tener 4 columnas, con el siguiente orden:
# -- apellido1 -- apellido2 -- nombre -- email
#
# El script se ejecuta de la siguiente forma:
# 	./registrarListas nombreCSV nickGrupo
#
# Siendo nombreCSV el nombre del fichero con la lista de usuarios.
# Siendo nickGrupo el nick exacto del grupo en Bolotweet.

sp=" "
IFS=","
while read apellido1 apellido2 nombre email
do
 
nick=( $(echo $email | cut -d '@' -f1 | tr -d '.') )
number=( $(echo $RANDOM) )
pass=$nick$number

nameTemp=$nombre$sp$apellido1$sp$apellido2
fullname=( $(echo $nameTemp | tr '[:lower:]' '[:upper:]') )

# Ahora vamos a registrar al usuario.

php registeruser.php -n$nick -w$pass -f$fullname -e$email

# Ahora vamos a meterle en el grupo que nos han pasado.

php joingroup.php -n$nick -g$2


done < $1