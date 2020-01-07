<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB"
    crossorigin="anonymous">

  <title>電子化流程設計與管理-出差</title>
</head>

<body>

<?php
require_once(__DIR__ . "/config.php");
ini_set ("soap.wsdl_cache_enabled", "0");
$client = new SoapClient("http://$easyFlow:8086/NaNaWeb/services/WorkflowService?wsdl");


if($_POST){
    if(
        !empty($_POST['oid'])
        && !empty($_POST['Textbox8'])
        && !empty($_POST['Textbox12'])
    ) {
        $oid = $_POST['oid'];
        $Textbox8 = $_POST['Textbox8'];
        $Textbox12 = $_POST['Textbox12'];
        $Textbox10 = $_POST['Textbox10'];
        $Textbox14 = $_POST['Textbox14'];
        $Textbox9 = $_POST['Textbox9'];
        $Textbox13 = $_POST['Textbox13'];
        $Textbox11 = $_POST['Textbox11'];
        $Textbox15 = $_POST['Textbox15'];

	try{
        $procesesStr = $client->findFormOIDsOfProcess($oid);
        $proceses = explode(",", $procesesStr);
        $process = $proceses[0];
        $template = $client->getFormFieldTemplate($process);
        $form = simplexml_load_string($template);
        $form->Textbox8 = $Textbox8;
        $form->Textbox12 = $Textbox12;
        $form->Textbox10 = $Textbox10;
        $form->Textbox14 = $Textbox14;
        $form->Textbox9 = $Textbox9;
        $form->Textbox13 = $Textbox13;
        $form->Textbox11 = $Textbox11;
        $form->Textbox15 = $Textbox15;
        $result = $form->asXML();
        $DocNo=$client->invokeProcess($oid, $Textbox8, $Textbox12, $process, $result, "108D");

		$conn= new mysqli($host,$account,$password,$database);
		$result= $conn->query('INSERT INTO easyflow (DocNo,Status) Values ("'. $DocNo .'",1)');
	}catch(Exception $e){
		echo $e->getMessage();
	}
    } else{
        echo "系統錯誤";
    }
    
}
?>

  <div class="container">
    <div class="py-5 text-center">
      <h2>電子化流程設計與管理</h2>
    </div>

    <div class="row">

      <div class="col-md-12 order-md-1">
        <h4 class="mb-3"></h4>
        <form class="needs-validation" method="POST" action="./index.php">
          <div class="row">
            <div class="col-md-12 mb-3">
              <label for="Textbox8">員工編號</label>
              <input name="Textbox8" type="text" class="form-control" id="Textbox8" placeholder="" value="" required>
              <div class="invalid-feedback">
                員工編號 必填
              </div>
            </div>
          </div>

          <div class="row">
              <div class="col-md-12 mb-3">
                  <label for="Textbox12">員工單位編號</label>
                  <input name="Textbox12" type="text" class="form-control" id="Textbox12" placeholder="" value="" required>
                  <div class="invalid-feedback">
                    員工單位編號 必填
                  </div>
                </div>
          </div>

          <div class="row">
              <div class="col-md-12 mb-3">
                  <label for="oid">流程編號</label>
                  <input name="oid" type="text" class="form-control" id="oid" placeholder="" value="" required>
                  <div class="invalid-feedback">
                    流程編號 必填
                  </div>
                </div>
          </div>

          <div class="row">
              <div class="col-md-12 mb-3">
                  <label for="Textbox14">天數</label>
                  <input name="Textbox14" type="text" class="form-control" id="14" placeholder="" value="" >
                </div>
          </div>

          <div class="row">
              <div class="col-md-12 mb-3">
                  <label for="Textbox10">出差地點</label>
                  <input name="Textbox10" type="text" class="form-control" id="Textbox10" placeholder="" value="" required>
                  <div class="invalid-feedback">
                    範例輸入 必填
                  </div>
                </div>
          </div>
          <div class="row">
              <div class="col-md-12 mb-3">
                  <label for="Textbox9">開始日期</label>
                  <input name="Textbox9" type="text" class="form-control" id="Textbox9" placeholder="" value="" required>
                  <div class="invalid-feedback">
                    範例輸入 必填
                  </div>
                </div>
          </div>
          <div class="row">
              <div class="col-md-12 mb-3">
                  <label for="Textbox13">結束日期</label>
                  <input name="Textbox13" type="text" class="form-control" id="Textbox13" placeholder="" value="" required>
                  <div class="invalid-feedback">
                    範例輸入 必填
                  </div>
                </div>
          </div>
          <div class="row">
              <div class="col-md-12 mb-3">
                  <label for="Textbox11">車馬費</label>
                  <input name="Textbox11" type="text" class="form-control" id="Textbox11" placeholder="" value="" required>
                  <div class="invalid-feedback">
                    範例輸入 必填
                  </div>
                </div>
          </div>
          <div class="row">
              <div class="col-md-12 mb-3">
                  <label for="Textbox15">住宿費</label>
                  <input name="Textbox15" type="text" class="form-control" id="Textbox15" placeholder="" value="" required>
                  <div class="invalid-feedback">
                    範例輸入 必填
                  </div>
                </div>
          </div>

          
          

          <hr class="mb-4">
          <button class="btn btn-primary btn-lg btn-block" type="submit">送出</button>
        </form>
      </div>
    </div>

    <footer class="my-5 pt-5 text-muted text-center text-small">
      <p class="mb-1">&copy; 2017-2018 NKUST MIS</p>
    </footer>
  </div>

  <!-- Bootstrap core JavaScript
        ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>
  <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
      'use strict';
      window.addEventListener('load', function () {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
          form.addEventListener('submit', function (event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
  </script>
</body>

</html>
