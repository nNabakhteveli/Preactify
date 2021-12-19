import { useState, useEffect } from 'react';
import axios from 'axios';
  

export default function Profile() {
    const [token, setToken] = useState("");
    const [data, setData] = useState({});

    const playlistsEndpoint = 'https://api.spotify.com/v1/me/playlists';
    
    useEffect(async () => {
        // Get user's Access token
        try {
            const response = await axios.get('http://localhost/preactify/server/api/get.php');
            setToken(response.data[3].access_token);

            const getPlaylists = await axios.get(playlistsEndpoint, {
                headers: {
                    Authorization: "Bearer " + token 
                }
            })
            setData(getPlaylists[data]);

        } catch(error) { 
            console.log(error) 
        }
    }, []);
    
    console.log(token);

    return(
      <h1>Hi</h1>  
    );
}
