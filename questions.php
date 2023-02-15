<?php
   include "./scripts/php_includes/data-collector.php";
?>
<!doctype html>
<html lang="en" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.104.2">
    <title>Trivia Quiz +</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/sticky-footer-navbar/">
    
    

    

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <!-- Favicons -->
<link rel="apple-touch-icon" href="/docs/5.2/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
<link rel="icon" href="/docs/5.2/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
<link rel="icon" href="/docs/5.2/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
<link rel="manifest" href="/docs/5.2/assets/img/favicons/manifest.json">
<link rel="mask-icon" href="/docs/5.2/assets/img/favicons/safari-pinned-tab.svg" color="#712cf9">
<link rel="icon" href="/docs/5.2/assets/img/favicons/favicon.ico">
<link rel="stylesheet" href="css/style.css">
<meta name="theme-color" content="#712cf9">


    
    <!-- Custom styles for this template -->
    <link href="css/sticky-footer-navbar.css" rel="stylesheet">
  </head>
  <body class="d-flex flex-column h-100 bg-info">
  

<header>
<?php 


if (isset($quiz["questionIdSequence"])) {
  $questionCount = $quiz["questionNum"];
  $id = $quiz["questionIdSequence"][$currentQuestionIndex];
}


// Frage auslesen

$question = fetchQuestionById($id, $dbConn);
    
    ?>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
          <h5 class="mt-0 text-light">Restart Trivia Quiz</h5>
        </a>
        <div class="collapse navbar-collapse" id="navbarCollapse">
        </div>
      </div>

    </nav>
  </header>
  <br>
  <br>

  <!-- Begin page content -->
  <div class="container mt-sm-5 my-1">
    <main class="question flex-shrink-0">
      <div class="py-2 h5"><b> Question
          <?php echo ($currentQuestionIndex + 1)
            ?> of
          <?php echo $quiz["questionNum"]; ?> :
          <?php echo $question["question_text"]; ?>
        </b></div>
      <?php echo '<img id="optionalstuff" src="/images/' . $question["image"] . '" width="auto">'; ?>
      <div class="ml-md-3 ml-sm-3 pl-md-5 pt-sm-0 pt-3" id="options">Your answer:</h7>
        <form style="width:auto;" class="form-select containerq" name="answer"
          action="<?php echo $link; ?>" method="post">
          <?php


          $correct = $answer["is_correct"] = 1;
          // prepare and execute the select statements
          $selectAnswers = $dbConn->prepare("select * from answers where question_id = ?");
          $selectAnswers->bindValue(1, $question["id"]);
          $selectAnswers->execute();

          if ($question["type"] == "MULTIPLE") {
            // display checkboxes buttons for answers to questions with MULTIPLE answers
            while ($answer = $selectAnswers->fetch(PDO::FETCH_ASSOC)) {
              // print html checkbox for each answer              
              echo '<div class="row justify-content-center">';
              echo '<div class="form-check" id="ckb">';                         
               echo "<input class='form-check-input' type='checkbox'  name='multiple-choice[]' id='$answer[id]' value='$answer[is_correct]' onclick='checkBoxLimit()';>"; 
               echo '<label class="form-check-label">' . $answer["answers"] . '</label><br>';         

           echo '</div>';
            }
          } else {
            // display radio buttons for answers to questions with one SINGLE answer
            while ($answer = $selectAnswers->fetch(PDO::FETCH_ASSOC)) {
              // print html radio button for each answer   
              echo '<div class="form-check">';
              echo "<input class='form-check-input' type='radio'  name='single-choice' id='$answer[id]' value='$answer[is_correct]'>";
              echo '<label class="form-check-label">' . $answer["answers"] . '</label><br>';
              echo '</div>';
            }
          }
          ?>

          <!-- Limit checkbox selection -->

                   <script type="text/javascript">
function checkBoxLimit() {
  var checkBoxGroup = document.getElementsByName("multiple-choice[]");
  var limit = 2;
for(var i=0; i < checkBoxGroup.length; i++){
  checkBoxGroup[i].onclick = function() {
			var checkedcount = 0;
        for (var i = 0; i < checkBoxGroup.length; i++) {
          checkedcount += (checkBoxGroup[i].checked) ? 1 : 0;
        }
        if (checkedcount > limit) {
          console.log("You can select maximum of " + limit + " checkboxes.");
				alert("You can select maximum of " + limit + " checkboxes.");						
				this.checked = false;
			}
		}
	}
}
</script>

          <div class="d-flex align-items-center pt-3">
            <div id="prev">
              <div class="hidden">
                <input type="hidden" class="form-control" id="questionNum" name="questionNum"
                  value="<?php echo $quiz["questionNum"]; ?>">
                <input type="hidden" id="questLastInd" name="questLastInd" value="<?php echo $currentQuestionIndex; ?>">
                <input type="hidden" id="indexStep" name="indexStep" value="1">
                <input class="btn btn-info justify-content-center" type="submit" value="Submit">
              </div>
            </div>
          </div>
      </div>


  </div>



<!-- <?php prettyPrint($_SESSION , "Test") ?> -->

  </div>

  </form>
</main>

<footer class="footer mt-auto py-3 bg-light">
  <div class="container">

  
    <span class="text-muted">Trivia Quiz <?php echo $quiz["topic"] ?> Questions</span>
  </div>
</footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

      
  </body>
</html>