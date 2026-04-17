      <!DOCTYPE html>
      <html lang="en">

      <head>
         <meta Chareset="UTF-8">
         <meta http-equiv="X-UA-Compatible" content="TE-edge">
         <meta name="viewport" content="width = device-width-initial-scale=1.0">
         <link ref="stylesheet" href=".css">
         <title>EXTENDED Family Tree</title>

         <li>
            <a background="" class=" " href=""> </a>
            <a class=" " href=" "> </a>
         </li>

      </head>

      <body>
         <h1 align="center"><b><u>EXTENDED FAMILY INFORMATION.</u></b></h1>
         <form align="center" action="<?php htmlspecialchars($_SEVER["PHP_SELF"]); ?>" method_POST>
            <input type="text" name="headoffamily" placeholder="Head of Family"><br>
            <input type="text" name="numberofmember" placeholder="Number of Members"><br>
            <input type="text" name="location" placeholder="Location"><br>
            <input type="text" name="wealth" placeholder="Wealth">
            <br>
            <br>
            <br>
            <button>SUBMMIT</button>
         </form>


      </body>


      </html>

      "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"




      <?php
      // GARBING OF DATA
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
         $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
         $father = filter_input(INPUT_POST, "father", FILTER_SANITIZE_SPECIAL_CHARS);
         $mother = filter_input(INPUT_POST, "mother", FILTER_SANITIZE_SPECIAL_CHARS);
         $children = filter_input(INPUT_POST, "children", FILTER_SANITIZE_SPECIAL_CHARS, 515);
         $location = filter_input(INPUT_POST, "location", FILTER_SANITIZE_SPECIAL_CHARS);
         $wealth = filter_input(INPUT_POST, "wealth", FILTER_SANITIZE_SPECIAL_CHARS);
      }

      // ERROR HANDLERS
      $errors = false;

      if (empty($name) || empty($father) || empty($mother) || empty($children) || empty($location) || empty($wealth)) {
         echo "<p class='calc-error'>Fill empty space!</p>";
         $errors = true;
      }


      if (!is_numeric($children)) {
         echo "<p class='clac-error'>only numbers!</p>";
      }


      ?>