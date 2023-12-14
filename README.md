## Install dependencies 

Install the symfony dependencies
```sh
$ composer install
```
Create the database
```sh
$ php bin/console doctrine:database:create
```
To compile the react code
```
$ npm install -D @babel/preset-react --force
```

## Launch the website
Start the symfony server
```sh
$ symfony server:start
```
Dynamically compile the react code
```sh
$ npm run watch
```