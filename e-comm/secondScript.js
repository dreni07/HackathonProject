// // function gettingWeeklyProducts(){
// //     var all_div = document.querySelector('.all-div');

// //     try{
// //         fetch('weeklyProducts.php').then(response=>{
// //             return response.text();
// //         }).then(answer=>{
// //             console.log(answer);
// //             if(answer){
// //                 if(answer.data.length >= 5){
// //                     all_div.style.display = 'block';
// //                 }
// //             }
            
// //         })
// //     } catch(err){
// //         console.error(err);
// //     }
// // }

// // var the_value = gettingWeeklyProducts();


// function sendingNotification(){
//     Notification.requestPermission().then(permission=>{
//         if(permission == 'granted'){
//             const new_notification = new Notification('From ShopCart',{
//                 body:'A Product Based On Your Liked Products Was Added Check It!',
//                 icon:'',
//                 tag:''
//             })
//         }
//     })
// }

// async function fetchNewProducts(url){
//     try{
//         const response = await fetch(url);

//         if(!response.ok){
//             throw new Error('Something Went Wrong');
//         }

//         const answer = response.text();
//         return answer;
//     }catch(err){
//         console.error(err);
//         return;
//     }
    
    
// }

// fetchNewProducts('notifyingTheUser.php').then(answer=>{
//     console.log(answer);
//     if(answer){
//         if(answer.success){
//             sendingNotification();
//         }
//     }else{
//         console.log('something really bad happened');
//     }
// })

// alert('hello')



