set -a # export all variables created next
source $1
set +a # stop exporting

cd ../

docker-compose exec mysql bash -c "mysqldump --user=root --password=$MYSQL_ROOT_PASSWORD --add-drop-table --no-data $MYSQL_DATABASE | grep ^DROP | mysql --user=root --password=$MYSQL_ROOT_PASSWORD $MYSQL_DATABASE"
docker-compose exec mysql bash -c "mysql --user=root --password=$MYSQL_ROOT_PASSWORD --default-character-set=utf8 $MYSQL_DATABASE < /docker-entrypoint-initdb.d/$MYSQL_DATABASE.sql"