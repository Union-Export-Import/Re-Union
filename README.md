## About Union EI with docker

First time running docker 

First - Go to application folder and type

```docker-compose up -d```

this will run everything nginx, postgresdb, and php.

Second - To migrate and run composer command

In application folder and type

```docker-compose exec -it app bash```

This will take you to www folder and inside that you can run ```php artisan``` command.

####  Sample ENV file can be see in .env_clone
