

const apiUrl =   'uRrdZGbE8t8-mG-ts1zc-AT3WXM_N948_eH1puHhfMI';

fetch(`https://api.unsplash.com/photos/random?query=phone&client_id=${apiUrl}`)
  .then(response => response.json())
  .then(data => {
    console.log(data)  // Displays the image URL
  })
  .catch(error => console.error('Error:', error));