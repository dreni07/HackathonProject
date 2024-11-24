async function getData(){
    const url = 'https://chatgpt-api8.p.rapidapi.com/';
    const options = {
        method: 'POST',
        headers: {
            'x-rapidapi-key': 'e91fed1247msh40f39dca1776a54p144a99jsn64bd354cb6de',
            'x-rapidapi-host': 'chatgpt-api8.p.rapidapi.com',
            'Content-Type': 'application/json'
        },
        body:JSON.stringify([
            {
                content: 'Hello! Im an AI assistant bot based on ChatGPT 3. How may I help you?',
                role: 'system'
            },
            {
                content: 'Give Me A Product That Belongs To The Electronics Category GIVE ME JUST THE NAME AND SOME DESCRIPTION',
                role: 'user'
            }
        ]) 
    };

    try {
        const response = await fetch(url, options);
        const result = await response.json();
        console.log(result);
    } catch (error) {
        console.error(error);
    }

   
}
    


getData();
