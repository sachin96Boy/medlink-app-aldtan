<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iK4aaPqLdW3l+lnE5ds/u6Z/hRTt8+pj9WO5taFfR9CC" crossorigin="anonymous">

        
    <title>Daily Income Report</title>
    <style>
        
        body {
            padding: 20px;
        }

        .table{
    
    border-collapse: collapse;
    
  }

  .table {
    width:100%;
  }

  th, td {
  padding: 8px;
  text-align: left;
  border-bottom: 1px solid #DDD;
}

tr:hover {background-color: #D6EEEE;}
    </style>
</head>

 <body>
  <form>

    <div class="container-fluid">
      <div style=" background-color: white;  border-radius: 12px; ">
        <h1 class="my-4"  style=" padding-top: 10px; color: black;"><b>Daily Income Report - Medlink</b></h1></div>

        <img src="https://pin.it/6izplEO.png" alt="Medical Logo" height="30" class="d-inline-block align-top">

        

        

        <div class="row"  style=" padding-top: 10px;">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Summary</h2>
                    </div>
                    <div class="card-body">
                        
                        <p style=" font-size:20px;">Total Income: $XXX</p>
                        <p style=" font-size:20px;">Total Patients: XX</p>
                
                    </div>
                </div>
            </div>

            <div class="col-md-6" style=" padding-top: 10px;">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Income Details</h3>
                    </div>
                    <div class="table-responsive" style=" padding-top: 5px;">
                    


       <table class="table">
      <thead >
        <tr style="height: 60px;">
        <th scope="col">Date</th>
          <th scope="col">Income</th>
          <th scope="col">Patients</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>2023-11-15</td>
          <td>$XXX</td>
          <td>XX</td>
        </tr>
      </tbody>
      </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-eMNBDhUofq42D35t38uEer3t5l6C3Hqsh8+5xhG6L4N5F0bPOKwFCOSJd8G6L5Fa"
        crossorigin="anonymous"></script>

</form>
</body>

</html>
