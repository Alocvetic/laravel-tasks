set -a # export all variables created next
source $1
set +a # stop exporting

cd ../

docker-compose exec mysql /usr/bin/mysqldump -u root --password=root  $MYSQL_DATABASE > docker/mysql/docker-entrypoint-initdb.d/$MYSQL_DATABASE.sql