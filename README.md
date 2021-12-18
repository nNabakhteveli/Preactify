# Preactify
Dockerized Full-Stack app made with React, PHP and Spotify Web API

# Documentation
You can login into nginx container with: `docker exec -ti <nginx_container_id> bash` or `docker-compose exec nginx sh`

Configuration of nginx is stored at `/etc/nginx/nginx.conf`


# Getting Started with Create React App

This project was bootstrapped with [Create React App](https://github.com/facebook/create-react-app).

## Available Scripts

In the project directory, you can run:

### `npm start`

Runs the app in the development mode.\
Open [http://localhost:3000](http://localhost:3000) to view it in your browser.

The page will reload when you make changes.\
You may also see any lint errors in the console.

## Every redirect_uri should be registered on the Spotify dashboard app, otherwise it won't work
