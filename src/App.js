import React, { useState, useEffect } from 'react';
import { BrowserRouter, Route, Routes } from 'react-router-dom';
import './App.css';
import Swal from 'sweetalert2'
import parseUrl from 'parse-url';
import axios from 'axios';


const Second = () => <h1>ZD Mgels!</h1>;

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
        <form action='http://localhost/preactify/server/api/registerUser.php' method='POST'>
          <div className="form-group">
            <input name='username' type="text" className="form-control" id="nameInput" placeholder="Enter Username" required />
          </div>

          <div className="form-group">
            <input name='password' type="password" className="form-control" id="passwordInput" placeholder="Enter Password" required />
          </div>

          <a href="http://localhost:3000/dashboard">
            <button type='submit' className="btn btn-success">Proceed</button>
          </a>
        </form>
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
    <BrowserRouter>
      <Routes>
        <Route path='/' element={<TwoStepLogin isLoggedinWithSpotify={hasQueryString} />} />
        <Route path='/dashboard' element={<Second />} />
      </Routes>
    </BrowserRouter>
  );
}

export default App;
