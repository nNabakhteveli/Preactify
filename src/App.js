import React, { useState, useEffect } from 'react';
import { BrowserRouter, Route, Routes } from 'react-router-dom';
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
            <input type="email" className="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Username" required />
          </div>

          <div className="form-group">
            <input type="password" className="form-control" id="exampleInputPassword1" placeholder="Enter Password" required />
          </div>

          <a href="">
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
      </Routes>
    </BrowserRouter>
  );
}

export default App;
