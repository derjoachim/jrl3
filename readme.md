# Joachim's Running Log 

## Third Movement

This project is intended solely for me to have a web based logging tool for my runs. 
Earlier attempts were made, but never finished. Hence the 'third' designation. 
Initially started as an exercise for a new job that required Laravel, this app evolved
along with my use cases.

## Getting started

As per version 0.9.0, the easiest way to get this app to run, is to install Docker.
Having done that, copy the `compose.yaml.example` file to `compose.yaml`. Do the same
thing with the `.env.example` file, adjust any settings in both files (database passwords,
artisan keys, Strava API key if any).

Having  done that, simply run `docker compose up -d` and you should be able to open
the app in your browser using the address http://localhost:8000/ , assuming you use
the default port.

### Strava

If you have a [Strava](http://strava.com) account, you can synchronize your workouts
and routes. At the time of this writing, I have no other plans for the Strava API.
As per July 2026, API access was paywalled. That and some other policies by Strava
(coughcoughAIcoughcough) made me pull the plug on this part of the application. The 
code is still there, but it is unsupported.

### GPX import

Another way to import data, is through [the .gpx format](http://www.topografix.com/gpx.asp). 
You can upload a .gpx file, which is being parsed and translated into coordinates, 
distance and elapsed time. Neat!

### Openweathermap

One thing I always find important in tracking my results, is weather data. I run 
better in cold weather than in hot & stuffy weather. I built in the option of 
retrieving weather for a certain set of coordinates on a certain date and time. 
The [openweathermap.org](https://openweathermay.org) API allows the user to look into the past 
as well, so you can work on your logs days or even weeks after your workout.

## License

Although this project is entirely intended for my personal use, please feel free 
to clone my project and adjust it to your wishes. Please read the [License](license.md) 
file for details.