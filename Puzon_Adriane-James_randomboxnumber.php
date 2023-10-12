<?php
  // selected colors
  $selectedBG = '#008000';
  $selectedText = '#FFFFFF';

  // unselected colors
  $BG = '#FFFFFF';
  $Text = '#000000';

  // selected numbers
  $selected_nums = [];

  // generate numbers from 1 to 100
  $nums = range(1, 100);

  // shuffle the numbers
  shuffle($nums);

  // form was submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // lets check if the selected numbers is already 100
    if (sizeof(json_decode($_POST["selected_nums"], true)) == 100) {
      // reset the selected numbers
      $selected_nums = [];
    } else {
      // get the currently selected numbers then decode it
      $selected_nums = json_decode($_POST["selected_nums"], true);

      // generate an array that doesn't contain the currently selected numbers
      $numbersExceptSelected = array_diff($nums, $selected_nums);

      // get a random number from that array
      $randomNumber = array_rand($numbersExceptSelected, 1);

      // add the number to the selected numbers array
      array_push($selected_nums, $nums[$randomNumber]);
    }
  } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@materializecss/materialize@2.0.3-alpha/dist/css/materialize.min.css">
  <title>Bingo100</title>
  <style>
    body {
      width: 100vw;
      height: 100vh;
      text-align: center;
      display: flex;
      justify-content: center;
      align-content: center;
      flex-direction: column;
    }

    form {
      width: 500px;
      height: 500px;
      display: flex;
      justify-content: center;
      align-content: center;
      flex-direction: column;
    }

    table {
      width: inherit;
      height: inherit;
    }

    td {
      padding: 10px;
      text-align: center;
      font-size: 20px;
      border: 3px solid;  
    }

    #buttons {
      margin-top: 5px;
    }
  </style>
</head>
<body>
  <center>
    <form method="POST">
      <h6 style="text-align: center;"><?php echo implode(' ', $selected_nums) ?></h6>
      <table>
        <?php $ci = 0; ?>
        <?php for($i = 0; $i < 10; $i++) : ?>
          <tr>
            <?php for($j = 0; $j < 10; $j++) : ?>
              <?php if(array_search($nums[$ci], $selected_nums) || (count($selected_nums) > 0 && $nums[$ci] == $selected_nums[0] ?? false)): ?>
                <!-- current number is found as selected -->
                <td style="background-color: <?php echo $selectedBG; ?>; color: <?php echo $selectedText; ?>; border: 3px solid #006400;">
                  <?php echo $nums[$ci]; $ci++; ?>
                </td>
              <?php else: ?>
                <!-- current number is not found as selected -->
                <td style="background-color: <?php echo $BG; ?>; color: <?php echo $Text; ?>;">
                  <?php echo $nums[$ci]; $ci++; ?>
                </td>
              <?php endif; ?>
            <?php endfor; ?>
          </tr>
        <?php endfor; ?>
      </table>
      <input style="display: none;" name="selected_nums" value="<?php echo htmlspecialchars(json_encode($selected_nums)); ?>" />
      <div id="buttons">
        <?php if (sizeof($selected_nums) != 100): ?>
          <button class="btn" type="submit">PLAY</button>
        <?php else: ?>
          <button class="btn" type="submit">RESET</button>
        <?php endif; ?>
      </div>
    </form>
  </center>
</body>
</html>