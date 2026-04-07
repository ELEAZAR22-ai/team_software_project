<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta http-equiv ="X-UA-Compatible" content="TE-edge">
    <meta name = "viewport" content="width=device-width,initial-scale=1.0">
    <link ref="stylesheet" href=".css">
    <link ref="">
    <title>ASSIGNMENTFORM</title>
</head>
<body>
     <form action="<?php echo 'htmlspecialchars'($_SERVER["PHP_SELF"]); ?>" method="POST">
                <input type="number" name="num1" placeholder="number one"><br>
                <label for="choose operator">choose operator</label>
                <select id="operator" name="operator">
                    <option value="add">+</option>
                    <option value="subtract">-</option>
                    <option value="multiply">*</option>
                    <option value="divide">/</option>
                </select><br>
                <input type="number" name="num2" placeholder="number two"><br>
                    <button id = "calculate">Calculator</button>

                
        <?php
        //GRAB DATA FROM INPUT
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
           $num1 = filter_input(INPUT_POST, "num1", FILTER_SANITIZE_NUMBER_FLOAT);
           $num2 = filter_input(INPUT_POST, "num2", FILTER_SANITIZE_NUMBER_FLOAT);
           if (isset ($_POST['operator'])){
           $operator = htmlspecialchars($_POST["operator"]);
           }
        // Error handlers 
           $errors=false;

           if (empty($num1)|| empty($num2) || empty($operator)){
              echo "<p class='calc-error'>Fill empty space!</p>";  
              $errors=true;
              
              
           }
        if (!is_numeric($num1)|| !is_numeric($num2)){

            echo "<p class='calc-error'>only numbers!</p>";
            $errors=true;
        }

        // calculating for values
        if (!$errors){
            $value=0;
           switch ($operator)
              {
                 case "add" :
              $value = $num1 + $num2;
                break;
                case "subtract" :
                    $value = $num1 - $num2;
                break;
                case "multiply" :
              $value = $num1 * $num2;
                break;
                case "divide" :
              $value = $num1 / $num2;
                break;
                default :
                echo "<p class ='clac-error'>SOMETIHNG IS WRONG!</p>";
                }
               echo "<p class='clac-result'> Result = " . $value . "</p>";
        }
    }
        ?>

     </form>


</body>





</html>