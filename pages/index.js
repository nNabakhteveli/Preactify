import React, { useState, useEffect } from 'react';
import parseUrl from 'parse-url';


const SpotifyClient = () => {
  return(
    <div className="loginPopup login-step-one">
      <a href='http://localhost/preactify/server/index.php'>
        <button className="btn btn-success">Login with Spotify</button>
      </a>
    </div>
  );
}

const AccountSetup = () => {
  return(
    <div className="loginPopup login-step-two">
      <div className="second-step-form">
        <label>Finish setting up your account </label>
        <form action='http://localhost/preactify/server/lib/registerUser.php' method='POST'>
          <div className="form-group">
            <input name='username' type="text" className="form-control" id="nameInput" placeholder="Enter Username" required />
          </div>

          <div className="form-group">
            <input name='password' type="password" className="form-control" id="passwordInput" placeholder="Enter Password" required />
          </div>

          <button type='submit' className="btn btn-success">Proceed</button>
        </form>
      </div>
    </div>
  )
}

const TwoStepLogin = ({ isLoggedinWithSpotify }) => {
  if(!isLoggedinWithSpotify)
    return <SpotifyClient />
  else 
    return <AccountSetup />
}

function App() {
  const [hasQueryString, setHasQueryString] = useState(false);
  
  useEffect(() => {
    const currentPageUrl = document.baseURI, parsedCurrentPageUrl = parseUrl(currentPageUrl);
    if(parsedCurrentPageUrl.search !== "") setHasQueryString(true);

  }, []);

  
  return <TwoStepLogin isLoggedinWithSpotify={hasQueryString} />
}

export default App;
