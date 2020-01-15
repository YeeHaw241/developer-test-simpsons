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