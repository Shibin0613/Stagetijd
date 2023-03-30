<!DOCTYPE html>
<html lang="nl">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>login.html</title>
  <link rel="stylesheet" href="../Styles/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
  <form method="post" action="">
    <section class="h-100 gradient-form" style="background-color: #eee;">
      <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col-xl-10">
            <div class="card rounded-3 text-black">
              <div class="row g-0">
                <div class="col-lg-6">
                  <div class="card-body p-md-5 mx-md-4">

                    <div class="text-center">
                      <h4 class="mt-1 mb-5 pb-1">wij zijn StageTijd team</h4>
                    </div>

                    <form>
                      <p>log hier in</p>

                      <div class="form-outline mb-4">
                        <input type="email" name="email" class="form-control form-control-lg" placeholder="Enter a valid email address" />
                        <label class="form-label" for="form3Example3">Email address</label>
                      </div>

                      <div class="form-outline mb-4">
                        <input type="password" name="wachtwoord" class="form-control form-control-lg" placeholder="Enter password" />
                        <label class="form-label" for="form3Example4">Password</label>
                      </div>

                      <div class="text-center pt-1 mb-5 pb-1">
                        <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" input type="submit" id="submit"> Log
                          in</button>
                      </div>


                    </form>

                  </div>
                </div>
                <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                  <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                    <h4 class="mb-4">Wij zijn meer dan gewoon studenten</h4>
                    <p class="small mb-0">ons team werkte tijdens hun schoolperiode aan een nieuwe app.
                      ons team was gemotiveerd om een innovatief project te ontwikkelen en besloot zich te richten op het automatiseren van de stageprocessen binnen onze school.
                      Door gebruik te maken van de nieuwste technologieën en hun programmeervaardigheden,
                      ontwikkelden ze een systeem dat het hele proces van stagetijd automatisch afhandelde</p>
                  </div>
  </form>
  </div>
  </div>
  </div>
  </div>
  </div>
  </div>
  </section>
</body>

</html>


<?php
include '../Database/dbconn.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $query = "SELECT * FROM users WHERE email = :email AND wachtwoord = :wachtwoord LIMIT 1";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(':email', $_POST['email'], \PDO::PARAM_STR);
  $stmt->bindParam(':wachtwoord', $_POST['wachtwoord'], \PDO::PARAM_STR);
  $stmt->execute();

 // $role = $stmt->(); //als er verkeerde gegevens worden ingevuld.

  $data = $stmt->fetchObject();

  if ($role == 0) {
    echo '<script>alert("Verkeerde mail/wachtwoord")</script>';
  } else {
    $role = $row['role'];
    if (empty($data->role) && $role >= 1) {
      header("location:homedocent.php");
    }
    if (empty($data->role) && $role >= 2) {
      header("location:StudentenHomepagina.php");
    } else {
      header("jemoeder.php");
    }
  }
}


?>