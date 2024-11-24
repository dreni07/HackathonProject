// async function chartsData(){
//     try{
//         const context = {
//             method:'GET',
//             headers:{
//                 'X-Requested-With':'XMLHttpRequest'
//             }
//         }

//         const response = await fetch('getSales.php',context);

//         if(!response.ok){
//             throw new Error('Something Went Wrong!');
//         }

//         const answer = await response.json();

//         let the_data = answer.data;

//         const the_days = Object.keys(the_data);
//         const the_orders = Object.values(the_data);

//         const canvas_element = document.getElementById('my_canvas').getContext('2d');

//         const the_chart = new Chart(canvas_element,{
//             type:'line',
//             data:{
//                 labels:the_days,
//                 datasets:[{
//                     label:'Orders:',
//                     data:the_orders,
//                     borderColor:'#a4b4f7',
//                     tension:0.1,
//                     lineTension:0.2,
//                     pointRadius:3,
//                     pointBackgroundColor:'#F7E7A4',
//                     pointHoverRadius:7,

//                 }]
//             },
//             options:{
//                 scales:{
//                     y:{
//                         beginAtZero:true,
//                         grid:{
//                             borderColor:'#333',
//                             borderWidth:1,
//                             color:'rgb(225, 225, 225)'
//                         }
//                     },
//                     x:{
//                         beginAtZero:true,
//                         grid:{
//                             borderColor:'#333',
//                             borderWidth:5,
//                             color:'rgb(225, 225, 225)'
//                         }
//                     }
//                 }
//             }
//         })
//     } catch(err){
//         console.error(err);
//     }
// }

// chartsData();


// async function makeRequestForProduct(){
//     try{
//         const response = await fetch('productSuggested.php');

//         if(!response.ok){
//             throw new Error('Something Went Wrong!');
//         }

//         const answer = await response.json();

//         var the_category_name = answer.category_name;

//         var AIresponse = askingAI(the_category_name);
//         var secondAIresponse = chatAI(the_category_name);


//     } catch(err){
//         console.error(err);
//     }
// }

// makeRequestForProduct();


// function askingAI(category_name){
//     const apiUrl =   'uRrdZGbE8t8-mG-ts1zc-AT3WXM_N948_eH1puHhfMI';

//     fetch(`https://api.unsplash.com/photos/random?query=${category_name}&client_id=${apiUrl}`).then(response=>{
//         return response.json();
//     }).then(answer=>{
//         console.log(answer);
//     })
    
// }

// async function chatAI(the_category){
//     const url = 'https://chatgpt-api8.p.rapidapi.com/';
//     const options = {
//         method: 'POST',
//         headers: {
//             'x-rapidapi-key': 'e91fed1247msh40f39dca1776a54p144a99jsn64bd354cb6de',
//             'x-rapidapi-host': 'chatgpt-api8.p.rapidapi.com',
//             'Content-Type': 'application/json'
//         },
//         body:JSON.stringify([
//             {
//                 content: 'Hello! Im an AI assistant bot based on ChatGPT 3. How may I help you?',
//                 role: 'system'
//             },
//             {
//                 content: `Give Me A Product That Belongs To This Category ${the_category} and also little description!`,
//                 role: 'user'
//             }
//         ]) 
//     };

//     try {
//         const response = await fetch(url, options);
//         const result = await response.json();
//         console.log(result);
//     } catch (error) {
//         console.error(error);
//     }


// }