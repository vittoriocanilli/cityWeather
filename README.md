# City Weather information

This repository holds a simple web application which shows information about weather in a given city.

## The application

We want to create a simple frontend + backend microservice,
that display data from two external services:

* https://restcountries.eu/
* https://openweathermap.org/api

### User stories

1. As a user, I access to the root path and see:
* The Berlin country name
* The Berlin weather description
* The Berlin temperature
* The Berlin currency

2. As a user, if I add a `rootPAth/:city-name` sub-path:
* The city country name
* The city weather description
* The city temperature
* The city currency

### UX design

You can find the assets under the folder assets and a version of the desktop and mobile versions of the frontend.

### Notes:

* We estimate this challenge to be done around 5 hours.
* You don't have any restriction about languages and methodologies.

## The acceptance criteria

* Follow the UX design and the user story.
* Provide instructions under the **Instructions** section.
* Provide some notes about the challenge into **Impressions** section.
* Use git to deliver your challenge `git archive branch --format=tar`.

### Extra point (none mandatory)

We use docker (a lot!!) in our company,
but we know that takes time create Dockerfiles and docker-compose.yml files,
so if you have time please add some basic docker way to run your challenge.

## Instructions

As I did not manage to configure a local environment with Docker, I used XAMPP where I have simply run Apache with the following virtual host:

```apache
<VirtualHost *:80>
    DocumentRoot "/local/path/to/app-directory"
    ServerName city-weather.app
    ServerAlias city-weather.app
    <Directory "/local/path/to/app-directory">
        Options FollowSymLinks
        AllowOverride all
        Order deny,allow
    Allow from all
    Require all granted
    </Directory>
</VirtualHost>
```

Then I have simply added `city-weather.app` to my hosts file in order to assign it to the local host, so I could open the web application running locally on my browser.

As you can see I have chosen to implement the challenge in PHP and the Apache virtual host points to `index.php` which contains my solution.

I needed to implement a rewrite rule which you can find in the `.htaccess` file at the same level of `index.php`; here the appended city name is passed as GET parameter to `index.php`:
* `city-weather.app/:london` is rewritten to `city-weather.app/?city=london` without changing the url shown in the browser

The style definition is stored in the `stylesheet.css` which I have stored in the assets folder.

My solution executes the calls to the 2 APIs, stores the data and shows it on the browser. For the SVG icon I needed to create a mapping between the returned icon code and the available icons.

As requested the default city is Berlin if no city is passed to the application.

## Impressions

I have found the challenge pretty interesting as I was not used so far to detect the mobile browser and to offer a different layout for it.

Unfortunately I could not find an endpoint for the first API (https://restcountries.eu/) which could provide data of a city which is not a capital of a country.

Additionally I could not fulfil the requirement to show the Berlin's skyline in the background, as I could not find the corresponding asset in the provided bundle.

Moreover I was not sure if I was supposed to show always the Berlin's skyline or show a skyline matching the city passed to the microservice. 
