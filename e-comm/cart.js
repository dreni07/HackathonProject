var select_tag = document.querySelector('#myButton');
var dropdown_div = document.querySelector('.dropdown-div');
var another_tags = document.querySelectorAll('.paying');
var confirm = document.querySelector('.confirm');
var confirm_input = document.querySelector('.confirm-input');

alert('h')



function changingBehavior(){
    select_tag.onclick = function(){
        dropdown_div.style.visibility = 'visible';
        this.onclick = function(){
            dropdown_div.style.visibility = 'hidden';
            changingBehavior();// call the function again to repeat the same proccess
        }
    }

    another_tags.forEach((element,index)=>{
        element.onclick = function(){
            var child_elements = element.children;
            select_tag.textContent = child_elements[0].textContent;
            
            
        }
    })

    if(select_tag.textContent !== 'Options'){
        confirm.style.opacity = 1;
        confirm_input.setAttribute('placeholder',`Give Your ${select_tag.textContent} Acc Info`)
    }
}

changingBehavior();




let all_elements = document.querySelectorAll('.product');
let all_pagination = document.querySelectorAll('#slider-pagination');


if(Array.from(all_pagination).length > 0){
    all_pagination[0].classList.add('active-pagination');
}


function next_slider(){
    // do the slider with z-index thing 
    all_pagination.forEach((p,index)=>{
        p.onclick = function(){
            for(let j = 0;j<all_elements.length;j++){
                all_elements[j].style.zIndex = -1;
                all_pagination[j].classList.remove('active-pagination');
            }
            all_elements[index].style.zIndex = 1;
            all_pagination[index].classList.add('active-pagination');
        }
    })
}

next_slider();


var confirmOrderButton = document.getElementById('confirmOrderButton');
var nameInput = document.getElementById('nameInput');
var emailInput = document.getElementById('emailInput');
var zipCodeInput = document.getElementById('zipCodeInput');

confirmOrderButton.addEventListener('click',async function(){
    // now confirm the order 
    if(confirm_input.value != '' && nameInput != '' && emailInput != '' && zipCodeInput != ''){
        try{
            const response = await fetch('confirmOrder.php');
            if(!response.ok){
                throw new Error('Something Went Wrong');
            }
            const answer = await response.json();

            if(answer.success == true){
                alert('Order Completed!');
            }
        } catch(err){
            console.error(err);
        }
        
    }
})