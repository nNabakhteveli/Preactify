import React from 'react';
import Swal from 'sweetalert2'
  

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3500,
    timerProgressBar: false,
})

Toast.fire({
icon: 'success',
title: 'Signed in successfully'
})


export default function Dashboard() {
    return(
        <h1>Hey</h1>
    );
}