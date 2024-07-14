# Структура проекта

***

## Корень проекта:

- docker/ - образы и настройки для docker
- readme/ - файлы документации к readme, также лежат готовые коллекции Postman
- src/ - рабочая папка проекта
- tools/
    - make-dump-database.sh - dump бд (создание копии бд)
    - make-import-database.sh - import бд (импорт бд)
- .env - конфиги проекта (docker)
- gitlab-ci.yml - настройка ci/cd gitlab
- docker-compose.yml - настройка для запуска docker контейнера
- init.sh - настройка выполнения команд (копирования файлов, смен прав доступа...)
