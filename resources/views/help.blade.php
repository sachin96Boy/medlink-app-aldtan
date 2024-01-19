<!DOCTYPE html>
<html lang="en">
<head>
    <title>Helps</title>
    @include('header')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="bg-gray-100">
@extends('layouts.app')
    @section('content')
<div class="container">
    <div class="row">
       
        <div class="col-md-11">
            <div class="row">
                <div class="col-md-2">
                    <a href="{{ route('patient_list.view') }}" <button
                            style="border-radius: 30px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);"
                            type="button" class="btn  btn-info btn-sm"><b> Back </b></button></a>
                </div>
                <div class="col-md-10">
                    <h1 class="text-center">Shortcut key helps</h1>
                </div>
                
                
            </div>
        <div class="row">
                <div class="table-container" style="max-height: 50vh; overflow-y: auto;">

            <table class="table table-striped patient-table">
                <thead style="position: sticky; top: 0; z-index: 1;background-color: #3498db; color: white;">
                    <th style="width:25%;">Key</th>
                    <th style="width:75%;">Function</th>
                </thead>
                <tbody>
                    <tr>
                        <td>F1</td>
                        <td>PRESENTING COMPLAIN Selection</td>
                    </tr>
                    <tr>
                        <td>F2</td>
                        <td>PRESENTING COMPLAIN Textfield</td>
                    </tr>
                    <tr>
                        <td>F3</td>
                        <td>Treatment Textfield</td>
                    </tr>
                    <tr>
                        <td>F4</td>
                        <td>Medical Test Selection</td>
                    </tr>
                    <tr>
                        <td>F5</td>
                        <td>OPD drug Selection</td>
                    </tr>
                    <tr>
                        <td>F6</td>
                        <td>OUT side Drug selection</td>
                    </tr>
                    <tr>
                        <td>F7</td>
                        <td>Next Visit Date</td>
                    </tr>
                    <tr>
                        <td>F8</td>
                        <td>Remark Textfield</td>
                    </tr>
                    <tr>
                        <td>F9</td>
                        <td>Amount</td>
                    </tr>
                    <tr>
                        <td>F10</td>
                        <td>Edit Person</td>
                    </tr>
                    <tr>
                        <td>F12</td>
                        <td>Form submit</td>
                    </tr>
                    <tr>
                        <td>Ctrl+k</td>
                        <td>Print Report</td>
                    </tr>
                    <tr>
                        <td>Ctrl+u</td>
                        <td>Investigation History</td>
                    </tr>
                    <tr>
                        <td>Ctrl+g</td>
                        <td>Medical History</td>
                    </tr>
                    <tr>
                        <td>Ctrl+h</td>
                        <td>Drug History</td>
                    </tr>
                    <tr>
                        <td>Ctrl+j</td>
                        <td>Pateint Profile</td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
        </div>
    </div>
</div>
    @endsection
    @include('footer')
</body>
</html>