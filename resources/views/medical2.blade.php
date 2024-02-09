<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Report</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>

 <div class="container ">
    <div class="row" style="border: 2px solid #000; margin-top: 20px;">
        <div class="col">
            <div class="container text-center"> 
                <div class="row">
                    <div class="col-12">
                        <h5>SUWA SEWANA MEDICAL CENTER,</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p>
                        NO:78, Badulla Road, Lellopitiya, Rathnapura, </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p>
                        T.P.:- 045 22 75 111 Hotline:- 070 62 22 300,
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p>Mail:- suwasewanatreat@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @foreach ($patients as $p)
    <!-- Medical Certificate ... -->
    <div class="row ">
        <div class="container " style="border: 2px solid #000;">
            <div class="row  text-center">
                <div class="col">
                    <b><u>Medical Certificate</u></b>
                </div>
            </div>
            
            <!-- Name To whoom-->
            <div class="row justify-content-start mx-1">
            {{ $address1 }} ,
            </div>
             <!-- Address Line 1 To whoom-->
            <div class="row justify-content-start mx-1">
                {{$address2}},
            </div>
             <!-- Address Line 2 To whoom-->
            <div class="row justify-content-start mx-1">
                {{$address3}}.
            </div>
            <div class="row text-center">
                <br>

                This is certify that Rev/Mr/Mrs/Miss/     
            </div>
           
            <!-- Patient Name -->
            <div class="row text-center">
            {{$p->name}}
            </div>
            <div class="row text-center">
            Of
            </div>
            <!-- Patient Address-->
            <div class="row text-center">
            {{$p->address}}
            </div>
            <div class="row text-center">
            was under Medical treatment for
            </div>
            <!-- Patient Treatment-->
            <div class="row text-center">
            {{$treatmentrep}}
            </div>
            <div class="row text-center">
            from
            </div>
            <!--Patient Date-->
            <div class="row text-center">
            {{$date1}} to {{$date2}}
            </div>
            <div class="row text-center">
            and grant
            </div>
            <!-- Days-->
            <div class="row text-center">
            {{$numberOfDays}} days
            </div>
            <div class="row text-center">
            medical leave for his her absence for duty.
            </div>
            <div class="row text-center">
            This is produce as his/her request and not valid for the legal purposes.
            </div>
         
            <div class="container">
                <div class="row">
                    <br>
                    <br>
                    <br>
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 50%; text-align: left;">
                            <?php
                                $currentDate = date('Y-m-d'); // Format: YYYY-MM-DD
                                echo "<p>$currentDate</p>";
                            ?>
                        </td>
                        <td style="width: 50%; text-align: right; padding-right: 30px;">
                            .................
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Date
                        </td>
                        <td style="width: 50%; text-align: right; padding-right: 20px;">
                            Doctor in Charge
                        </td>
                    </tr>
                </table>
                </div>
            </div>
            
        </div>
        
    </div>
    
    @endforeach
 </div>
<!-- Latest compiled and minified JavaScript -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>