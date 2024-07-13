FROM mysql:5.7

ENV TZ UTC
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone && chown -R mysql:root /var/lib/mysql/

COPY my.cnf /etc/mysql/conf.d/my.cnf

RUN chmod 0444 /etc/mysql/conf.d/my.cnf

# for build docker image
#ADD docker-entrypoint-initdb.d/tunguska_tests.sql /docker-entrypoint-initdb.d/tunguska_tests.sql

CMD ["mysqld"]

EXPOSE 3306
