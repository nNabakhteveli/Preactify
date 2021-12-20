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


 ### P.S username/password login has only one function for now - to not show other registered people's data.


## Getting Started

First, run the development server:

```bash
npm run dev
# or
yarn dev
```

Open [http://localhost:3000](http://localhost:3000) with your browser to see the result.

You can start editing the page by modifying `pages/index.js`. The page auto-updates as you edit the file.

[API routes](https://nextjs.org/docs/api-routes/introduction) can be accessed on [http://localhost:3000/api/hello](http://localhost:3000/api/hello). This endpoint can be edited in `pages/api/hello.js`.

The `pages/api` directory is mapped to `/api/*`. Files in this directory are treated as [API routes](https://nextjs.org/docs/api-routes/introduction) instead of React pages.

## Learn More

To learn more about Next.js, take a look at the following resources:

- [Next.js Documentation](https://nextjs.org/docs) - learn about Next.js features and API.
- [Learn Next.js](https://nextjs.org/learn) - an interactive Next.js tutorial.

You can check out [the Next.js GitHub repository](https://github.com/vercel/next.js/) - your feedback and contributions are welcome!

## Deploy on Vercel

The easiest way to deploy your Next.js app is to use the [Vercel Platform](https://vercel.com/new?utm_medium=default-template&filter=next.js&utm_source=create-next-app&utm_campaign=create-next-app-readme) from the creators of Next.js.

Check out our [Next.js deployment documentation](https://nextjs.org/docs/deployment) for more details.
