async function chartsData(){
    try{
        const context = {
            method:'GET',
            headers:{
                'X-Requested-With':'XMLHttpRequest'
            }
        }

        const response = await fetch('getSales.php',context);

        if(!response.ok){
            throw new Error('Something Went Wrong!');
        }

        const answer = await response.json();

        let the_data = answer.data;

        const the_days = Object.keys(the_data);
        const the_orders = Object.values(the_data);

        const canvas_element = document.getElementById('my_canvas').getContext('2d');

        const the_chart = new Chart(canvas_element,{
            type:'line',
            data:{
                labels:the_days,
                datasets:[{
                    label:'Orders:',
                    data:the_orders,
                    borderColor:'#a4b4f7',
                    tension:0.1,
                    lineTension:0.2,
                    pointRadius:3,
                    pointBackgroundColor:'#F7E7A4',
                    pointHoverRadius:7,

                }]
            },
            options:{
                scales:{
                    y:{
                        beginAtZero:true,
                        grid:{
                            borderColor:'#333',
                            borderWidth:1,
                            color:'rgb(225, 225, 225)'
                        }
                    },
                    x:{
                        beginAtZero:true,
                        grid:{
                            borderColor:'#333',
                            borderWidth:5,
                            color:'rgb(225, 225, 225)'
                        }
                    }
                }
            }
        })
    } catch(err){
        console.error(err);
    }
}

chartsData();