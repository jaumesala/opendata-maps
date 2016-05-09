# Opendata-maps

This is the practical result of my Masters degree in Smart Cities through the collaboration between the University of Girona and the city of Schiedam.
The reason for this project is to explore new ways to share information with citizens, using open data, maps and visual techniques.

## The Applciation

The application allows you to connect different sources of information, usually open data and public domain data, and generate layers that are subsequently added over a map.

## Requirements

### Server
* PHP 5.6 or later
* MySQL or any DB supported by Laravel should work.
* A capable web server.
* Node an LTS will do.
* A Mapbox account to access their Maps API

### Client
* Any decent web browser will do. (so, no IE please)


## Installation

1. Clone the repo `git clone https://github.com/jaumesala/opendata-maps`
2. Install dependencies `composer install && npm install`
3. Configure the environment file `vi .env # Fill in database info`
4. Initialize the application `php artisan app:init`


## License

This application is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)