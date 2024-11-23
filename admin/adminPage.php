<?php 
    function all_categories(){
        try{
            require '../authentication/db.inc.php';

            $the_sql_query = 'SELECT * FROM categories;';
            $the_preparment = $pdo->prepare($the_sql_query);
            $the_preparment->execute();

            $fetched_data = $the_preparment->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e){
            die('Failed Because Of ' . $e->getMessage());
        }


        if($fetched_data){
            return $fetched_data;
        }
    }

    $the_categories = all_categories() ? all_categories() : [];

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <input type="file" id='image_file'>
        <input type="text" id='productName'>
        <select name="" id="category">
            <?php foreach($the_categories as $category): ?>
                <option value="<?php echo $category['category_id'] ?>"><?php echo $category['category_name'] ?></option>
            <?php endforeach; ?>
        </select>

        <input type="number" id='product_price'>
        <input type="number" id='product_in_stock'>


        <button id='addProduct'>Add Product</button>



    </div>
</body>

<script>
    function addingProduct(){
        var getting_image = null;

        var image = document.getElementById('image_file');
        var product_price = document.getElementById('product_price');
        var productName = document.getElementById('productName');
        var productCategory = document.getElementById('category');
        var product_in_stock = document.getElementById('product_in_stock');

        image.onchange = function(event){
            getting_image = event.target.files[0];
            console.log('hello')
            console.log(getting_image);
        }


        var the_product_data = {
            product_name:'',
            product_image:'',
            product_price:'',
            product_category:''
        }

        var the_product = document.getElementById('addProduct');

        the_product.addEventListener('click',function(){
            const the_form_data = new FormData();
            if(getting_image){

                the_form_data.append('image',getting_image);
                the_form_data.append('product_name',productName.value);
                the_form_data.append('product_category',productCategory.value);
                the_form_data.append('product_price',product_price.value);
                the_form_data.append('product_in_stock',product_in_stock.value);
                console.log('hello')

                var the_context = {
                    method:'POST',
                    headers:{
                        'X-REQUESTED-WITH':'XMLHttpRequest'
                    },
                    body:the_form_data
                };

                fetch('addProduct.php',the_context).then(response=>{
                    return response.text();
                }).then(answer=>{
                    console.log(answer);
                })
            }
        })
    }
    addingProduct();

    
</script>
</html>