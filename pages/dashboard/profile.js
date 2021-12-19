import { useState, useEffect } from 'react';
import axios from 'axios';
import parseUrl from 'parse-url';
import { nanoid } from 'nanoid';

const Playlists = ({ arr, isLoaded }) => {
    if(Object.keys(isLoaded).length !== 0) {
        for(const i of arr) {
            console.log(i)
        }
        return(
            <div className="playlistsDiv">
                <ul>
                    { arr.map((item) => <a target="_blank" key={nanoid()} href={item.external_urls.spotify}>
                        <li> <img src={item.images[0].url} width={40} /> {item.name}</li>
                    </a>)}
                </ul>
            </div>
        );
    } else {
        return <h1>Waiting..</h1>;
    }
}
  

export default function Profile() {
    const [token, setToken] = useState("");
    const [data, setData] = useState({});
    const [currentUser, setCurrentUser] = useState({});

    const playlistsEndpoint = 'https://api.spotify.com/v1/me/playlists';
    
    useEffect(async () => {
        // Parsing the url and getting currently loggined user's id
        const currentUserId = parseUrl(document.location.href).query.current_user;
        // Get user's Access token
        try {
            const getUserData = await axios.get('http://localhost/preactify/server/api/get.php');
            for(const i of getUserData.data) {
                if(i.id === currentUserId) {
                    setCurrentUser(i);
                    setToken(i.access_token);
                    localStorage.setItem("current_user_id", i.id);
                    localStorage.setItem("access_token", i.access_token);
                }
            }
        } catch(error) { 
            console.log(error) 
        }
    }, []);
    
    return(
        <div>
            <Playlists isLoaded={data} arr={data.items} />
        </div>
    );
}
