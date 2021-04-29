# Laravel Test for VAITEL

## Steps before run this project:

* First, clone this repository: \
`git clone https://github.com/gustavors97/laravel-test`

* Install python on lasted version (necessary to compact VueJS components): \
https://www.python.org/downloads/

<br>
## On the project root: 

* Install composer dependencies: \
`composer install`

* Install NPM dependencies: \
`npm install`

* Create an database called `blast` with blank password. 

* After, run this command to create tables and records: \
`php artisan migrate --seed`

* Compile VueJS components, with: \
`npm run prod`

* And, finally, execute the server: \
`php artisan serve` 

* Now, open this URL: http://localhost:8000 ;) 