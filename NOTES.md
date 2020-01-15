# [issue-0-update-gulp]

## Features
- Updated the version of gulp to 4.0.2 as version 3 was broken when using node version 12.
- Refactored gulpfile to define methods for tasks and replaced deprecated list parameter with .series.
## Deployment steps
- merge issue-0-update-gulp into master
- npm install.
- compile assets: `./bin/node_modules/gulp`.

# [issue-1-sort-episode-order]

## Features
- Updated sort method to arrange episodes in season ascending, episode ascending order.
## How To Test
- On loading the page "Behind The Laughter - s11e22" is now the last episode. 
## Deployment steps
- merge issue-1-sort-episode-order into master

# [issue-2-handle-api-server-errors-when-retrieving-episode-data]

## Features
- Wrapped the guzzle clienyt request in a try/catch to handle exception event and display user friendly message
## How To Test
- Attempt refreshing the page several times.
## Future Improvement
- Install test suite such as PhpUnit
- Move the episode loading code into it's own class
- Throw the exception in a test to verify feature
## Deployment steps
- merge issue-2-handle-api-server-errors-when-retrieving-episode-data

# [issue-4-tooltip]

## Features
- Popover on episode image is now opened on click and closes when another is opened.
## Deployment steps
- merge issue-4-tooltip
- compile assets: `./bin/node_modules/gulp`.

# [change-1-caching-api-response]

## Features
- Added a file caching feature, currently caches for 10 minutes but can be changed by changing the CACHE_TTL value
## Deployment steps
- merge change-1-caching-api-response
- there may be issues with write permissions on the file
- application attempts to create file in CACHE_FILE_PATH constant (currently "../public/resources/episode-data.json")