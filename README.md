# Polytech 2023 Web Admin Project : Census Website 
## Introduction
This website is a school project with the objective of creating a census website for the city of Saint Denis en Val, located near Orléans. The project scenario is as follows:

"I am employed by the municipality to conduct a census of the residents of Saint Denis en Val near Orléans. I have access to a tablet that is very practical and on which I can develop applications to assist me in my work. I aim to simplify the success of my mission by developing a census utility.

This tool will be very simple:

It should allow me to add a resident with their name, first name, date of birth, and gender (note that we are in 2023, so be mindful of the gender selection).
It should allow me to correct errors by authorizing the modification of a resident.
I should be able to delete a resident.
I should be able to view all the residents I have registered in alphabetical order.
Ideally, that's all I need. However, if I do well, I should be able to add residents based on an address. This way, I can group residents who are under the same roof."

This website implements a simple SCRUD (Search, Create, Read, Update, Delete) functionality.
# How to use it
## Install dependencies 

Install the symfony dependencies
```sh
$ composer install
```
Create the database
```sh
$ php bin/console doctrine:database:create
```
Build the database
```sh
$ php bin/console make:migration

$ php bin/console doctrine:migration:migrate
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


