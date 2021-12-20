# Preactify
Full-Stack app made with React/Next, PHP and Spotify Web API


## Create essential MySQL database and tables for testing

Create database:
  1. `CREATE DATABASE user_info;`

  2. Create users table: 

  ```CREATE TABLE users(id VARCHAR(100), username VARCHAR(100), password VARCHAR(100), createDate VARCHAR(50), access_token VARCHAR(256), spotify_disp_name VARCHAR(256), spotify_url VARCHAR(256), followers VARCHAR(100), spotify_id VARCHAR(256), profile_image_url VARCHAR(256));```

  3. Create playlists table:
  
  ```CREATE TABLE playlists(userid varchar(256), playlist_name varchar(256), playlist_external_url varchar(256), playlist_image_url varchar(256), owner_display_name varchar(256), owner_account_external_url varchar(256), owner_account_url_api varchar(256), tracks_api_url varchar(256), playlist_api_url varchar(256));```

  4. Make some columns UNIQUE to prevent data duplication:

  `alter table DemoTable ADD UNIQUE INDEX(userid, playlist_external_url, playlist_image_url, owner_account_url_api);`

## Getting started with Next.js 

First, run `npm run launch` which installs all the neccessary npm and composer packages and starts the app automatically;

Open [http://localhost:3000](http://localhost:3000) with your browser to see the result.

