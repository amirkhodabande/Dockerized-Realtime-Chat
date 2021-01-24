# Dockerized Realtime Chat

-   Laravel

-   VueJs

-   Laravel Web Sockets

- Docker


## If you dont know docker you can use the normal version of this project.


1. Clone the project


2. Run 
   : `docker-compose build && docker-compose up -d`


3. install composer dependencies via this command
   : `docker-compose run --rm composer install`


*Change sql connection in your .env file*
**DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret**


4. Connect to the data base and run database migration
   : `docker-compose run --rm artisan migrate`


5. Run data base Seeder to make some fake users and messages
   : `docker-compose run --rm artisan db:seed`


6. Serve the websockets server via this command
   : `docker-compose run --rm artisan websockets:serve`


7. Go to '/laravel-websockets' and click connect button.


## Done, go to the 'localhost/chat' and test the main chatroom.


**Be Happy:)**


![alt](https://github.com/amirkhodabande/Realtime-Chat/blob/master/public/git-images/TypingEvent.png)
![alt](https://github.com/amirkhodabande/Realtime-Chat/blob/master/public/git-images/JoiningAndLeavingEvents.png)
