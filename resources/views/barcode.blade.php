<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ID</title>

        <style type="text/css">
            body {
                width: 80mm;
                margin: 0;
                padding: 0;
            }

    </style>
</head>
<body>
    <div id="content">

<p style="text-align: center;"><b>SUWA SEWANA MEDICAL CENTER</b>
No:78, Badulla Road,Lellopitiya,Rathnapura.<br>
Hotline:- 045 22 75 111/ 070 62 22 300<br>
Email:-suwasewanatreat@gmail.com<br>
---------------------------------------------------<br>
</p>
@foreach ($patients as $p)

                        <table style="text-align: left; border-collapse: collapse;">
                                    <thead>
            <tr>
                <th</th>
                <th></th>
            </tr>
        </thead>
                            <tbody>
                                <tr>
                                    <td >Name of Patient</td>
                                    <td>: {{$p->name}}</td>
                                </tr>
                                <tr>
                                    <td >Address</td>
                                    <td>: {{$p->address}}</td>
                                </tr>
                                <tr>
                                    <td >NIC Number</td>
                                    <td>: {{$p->nic}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="barcode" style="display: flex; justify-content: center; text-align: center; margin-top: 20px; ">

    {!! DNS1D::getBarcodeHTML("00000$p->id", 'CODABAR',2,50) !!}
</div>

                        
                        @endforeach

</div>
<script>
    window.onload = function() {
        window.print();

        window.onafterprint = function() {
window.history.back();

        };
    };
</script>


</body>
</html>