<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Report</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style>
     .uppercase {
        text-transform: uppercase;
    }
</style>
</head>
<body>
@foreach ($patients as $p)

 <div class="container my-4"  style="border: 2px solid #000;">
 <br>
 <br>
    <div class="row">
        <table style="width: 100%;" class="px-3">
            <tr>
                <td style="width: 40%; text-align: left; padding-left: 20px;">
                <div class="row justify-content-start">
                {{ $address1 }} ,

                </div>
                 <!-- Address Line 1 To whoom-->
                <div class="row justify-content-start">
                {{$address2}},
                </div>
                 <!-- Address Line 2 To whoom-->
                <div class="row justify-content-start">
                {{$address3}}.
                </div>
                </td>
                <td style="width: 60%; text-align: center;">
                SUWA SEWANA MEDICAL CENTER,
            NO:78,Badulla Road,Lellopitiya,Rathnapura,
            T.P.045 22 75 111 Hotline:- 070 62 22 300,
            Mail:- suwasewanatreat@gmail.com
                </td>
            </tr>
        </table>
    </div>
    <br>
    <br>
    <div class="row px-3" style="padding-left: 5px;">
        This is certify that Mr/Mrs/Miss <b>{{$p->name}} </b>Of <b>{{$p->address}}</b> was under my medical treatment for <b>{{$treatmentrep}}</b> on {{$date1}} and charged <b> {{$amountrep}}/=</b> rupees for the treatment , investigation and consultation.
    </div>
    <br>
    <br>
    <table style="width: 100%;" class="px-3">
<tr>
<td style="width: 100%; text-align: right;"> Thank You, </td>
</tr>
<tr>
<td style="width: 100%; text-align: right;">

<br>
<br>
..........................</td>
</tr>
<tr>
<td style="width: 100%; text-align: right;"> Doctor in Charge</td>
</tr>
    </table>
    <div class="row d-flex mr-3 justify-content-end"style="text-align: left; padding-right: 20px;">
       
    </div>
    <div class="row d-flex mr-3 justify-content-end">
        <br>
        <br>
       
    </div>
    <div class="row d-flex mr-3 justify-content-end">
       
    </div>
 </div>
 @endforeach

<!-- Latest compiled and minified JavaScript -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>