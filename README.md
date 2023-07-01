# trophy

# Part 1

The map is not rendering. There is a weird javascript error.
> Took 10mins, there was ; sign in the geoJson function

We wanted to draw a nice polygon around our office. But for some reason the polygon is being drawn in the wrong
location. Even though the coordinates are correct.
> Took 1 hour.
Took a look at generated HTML and there was HTML symbols like \n. I decided to simplify JS variable generation in PHP
script.<br>
So "JSON to json_encode, json_encode to JSON.parse" simplified to "PHP array + json_encode".
Double-checked polygon coordinates on Google Maps, they 100% as I see on my test project map, I don't see any other
errors/bugs here. Coordinates do not cover office location (55.676895, 12.570655).
Made many tweaks to have "" double quotes in HTML attributes, fixed widht typo in #map style, separated styles into a
separate file, moved all "style=..." attributes to the style file.

Once the above is fixed, let's get the map sized to the viewport so that there are no gaps and scrolling.
> took 10mins to add body full-width class styles, #map-container full block, hidden overflow styles.

# Part 2

### Installation

- Run trophy.sql dump with tables and seed data
- Set database settings in Database.php private properties
- Run web application from the root part2 directory

### Task requirements and timeframe reports

- A tomato is standing at Nørreport. It wants to go to Næstved
(55.232816,11.767130) to meet its family.

> Took 1 hour to make basic project with the map and UP, DOWN, RIGHT, LEFT moves.

> Took 2 hours to implement diagonal movements.

- Luckily the arrow keys can move this tomato in the desired arrow direction
at a speed of 500kph. And even better, holding the spacebar will double
the speed to 1,000kph. 

> Took 30 minutes to implement spacebar turbo speed

- The speeds (500/1000) should be queried from a
mysql database, so that we can easily change the speed.

> Took 1.5 hour to implement PHP database connection class, settings and sessions tables, return sessions record times and settings data

- Once the tomato reaches its destination (or within a radius of 1km), the
game is completed. The user's sessionID and the time it took should be
stored in a mysql database, so we can look at the stats later.

> Took 1 hour to handle destination point, make timer and save session + record time in database. **WARNING: There are 71 kilometers from Nørreport to Næstved so I implemented test mode to be able to test winning point much closer. Test mode can be set (true/false) in the db settings table.**

### Optional - if time allows (in the following order):

- Moving over water should be restricted. Here is a tip:
https://api.mapbox.com/styles/v1/shjorthdk/...(hidden_api_key)
> No time left for this feature. The game calculates movements every 10 milliseconds and I found an issue to use external API which will be used every single period. It takes more proc time to execute calculating and every API request costs money, so it needs to be fully refactored to handle this situation which would take ~5-7 hours.
- The all evil pineapple and the tomatoes worst enemy tends to be in the
way. Hitting that could reset the game.
> Took 30 minutes to implement pineapple obstacles
- Since this is a new hit-game, it should look a little cool…
- Freestyle all you want. We can't wait to see it.