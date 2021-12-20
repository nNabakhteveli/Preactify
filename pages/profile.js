import { useState, useEffect } from 'react';
import axios from 'axios';
import parseUrl from 'parse-url';
import { nanoid } from 'nanoid';


const UserProfile = ({ userData }) => {
    return(
        <div className='profileInfo'>   
            <img src={userData.profile_image_url} className='profile-image' width="300" />
            <a href={userData.spotify_url} target='_blank'>
                <p className='username'>{userData.spotify_disp_name}</p>
            </a>
            <p className='followers'>Total followers: {userData.followers}</p>
        </div>
    );
} 


const Playlists = ({ arr, isLoaded }) => {
    if(isLoaded.length !== 0) {
        return(
            <div className="playlistsDiv">
                <label>List of your playlists:</label>
                <div>
                    <ul>
                        { arr.map((item) => 
                            <a target="_blank" key={nanoid()} href={item.playlist_external_url}>
                                <li> <img src={item.playlist_image_url} width={40} /> {item.playlist_name}</li>
                            </a>
                        )}
                    </ul>
                </div>
            </div>
        );
    } else {
        return <h1>Waiting...</h1>;
    }
}
  

export default function Profile() {
    const [token, setToken] = useState("");
    const [data, setData] = useState([]);
    const [currentUser, setCurrentUser] = useState({});
    
    useEffect(async () => {
        // Parsing the url and getting currently loggined user's id
        const currentUserId = parseUrl(document.location.href).query.current_user;

        // Get user's Access token
        try {
            const getUserData = await axios.get('http://localhost/preactify/server/api/get.php');
            for(const i of getUserData.data.userData) {
                if(i.id === currentUserId) {
                    setCurrentUser(i);
                    setToken(i.access_token);
                }
            }
        } catch(error) { 
            console.log(error) 
        }

        function handleFetch() {
            axios.get("http://localhost/preactify/server/api/get.php").then(res => {
                const arr = [];
                for(const i of res.data.playlistsData) {
                    if(i.userid === currentUserId) {
                        arr.push(i);
                    };    
                }
                setData(arr);
            }).catch(error => console.log(error));
        }
        handleFetch();
    }, []);
    
    
    return(
        <div>
            <Playlists arr={data} isLoaded={data} />
            <UserProfile userData={currentUser} />
        </div>
    );
}
