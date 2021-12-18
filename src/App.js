import React, { useState, useEffect } from 'react';
import './App.css';
import Swal from 'sweetalert2'
import parseUrl from 'parse-url';



function successMessage() {
  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 1800,
    timerProgressBar: false,
  })

  Toast.fire({
    icon: 'success',
    title: 'Signed in successfully'
  })
}


const TwoStepLogin = ({ isLoggedinWithSpotify }) => {
  if(!isLoggedinWithSpotify) {
    return(
      <div className="loginPopup login-step-one">
        <a href='http://localhost/preactify/server/index.php'>
          <button className="btn btn-success">Login with Spotify</button>
        </a>
      </div>
    );
  } else {
    return(
      <div className="loginPopup login-step-two">
        <label>Finish setting up your account </label>
        <form>
          <div className="form-group">
            <input type="email" className="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Username" />
          </div>

          <div className="form-group">
            <input type="password" className="form-control" id="exampleInputPassword1" placeholder="Enter Password" />
          </div>
        </form>
        <a href="">
          <button className="btn btn-success" onClick={() => successMessage()}>Proceed</button>
        </a>
      </div>
    );
  }
}

function App() {
  const [hasQueryString, setHasQueryString] = useState(false);

  const currentPageUrl = document.baseURI, parsedCurrentPageUrl = parseUrl(currentPageUrl);

  useEffect(() => {
    if(parsedCurrentPageUrl.search !== "") setHasQueryString(true);
  }, []);

  return (
    <TwoStepLogin isLoggedinWithSpotify={hasQueryString} />
  );
}

export default App;
