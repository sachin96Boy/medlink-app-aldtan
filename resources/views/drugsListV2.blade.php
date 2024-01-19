<!--///////////////////NOT USING THIS CODE.This is a copy///////////////////////////////-->



<!DOCTYPE html>
<html lang="en">

<head>
    <title>Drugs Manage</title>
    @include('header')

</head>

<body class="g-sidenav-show  bg-gray-100">
    @extends('layouts.app')
    @section('content')
        <div class="container">
            <div class="row" >
                
                <a href="{{ route('drugsAdd.view') }}"><button
                        style="margin-left: 45px; border-radius: 30px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);"
                        type="button" class="btn  btn-info btn-sm"><b> Add Drugs</b></button></a>
                        
                        
                      

                <div class="col-12 overflow-y-scroll" style="height: 550px;">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                                type="button" role="tab" aria-controls="home" aria-selected="true">Active Drugs</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                                type="button" role="tab" aria-controls="profile" aria-selected="false">Deactive Drugs</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <form action="{{ route('drug.search') }}" method="post">
                                @csrf
                                <div class="d-flex flex-column flex-md-row py-2 align-items-center justify-content-start">
                                    <div class="col-3">
                                        <input style=" font-size: 12px;" type="text" class="form-control" id="drug_name"
                                            name="drug_name" placeholder="Drug Name" value="">
                                    </div>
                                    <div class="col-3 d-flex pt-3 gap-2">
                                        <button type="submit"
                                            style=" border-radius: 30px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);"
                                            class="btn  btn-info btn-sm"><b>Search</b></button>
                                        <a href="{{ route('drugs_view') }}"><button type="button"
                                                name="clear"
                                                style=" border-radius: 30px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);"
                                                class="btn  btn-info btn-sm"><b>Clear</b></button></a>
                                    </div>
                                </div>
                            </form>
                            <table id="example1" class="table table-bordered" style="background-color: #e6eef4;">
                                <thead>
                                    <tr style="font-size: 14px; background-color: #B4CAEB;">
                                        <th scope="col"  style="width: 95%;">Drug Name</th>
                                        <th scope="col"  style="width: 5%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($drugs_list as $drug)
                                        <tr style="font-size: 13px;">
                                            <td>{{ $drug->drug_name }}</td>
                                            <td class="project-actions d-flex flex-column flex-md-row gap-2 align-items-center justify-content-center">
                                               
                                                    <a href="{{ route('drugEdit', ['id' => $drug->id]) }}" title="Edit"
                                                        onclick="return confirm('Are you sure you want to Edit this drug?');">
                                                        <button class="btn btn-outline-dark"> <i class="fa fa-pencil-square"> Edit</i></button>
                                                    </a>
                                                    <a href="{{ route('drug.delete', ['id' => $drug->id]) }}" title="Delete" onclick="return confirm('Are you sure you want to delete this drug?')">
                                                        <button class="btn btn-outline-danger"> <i class="fa fa-trash"> Delete</i></button>
                                                    </a>
                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <table id="example1" class="table table-bordered" style="background-color: #e6eef4;">
                                <thead>
                                    <tr style="font-size: 14px; background-color: #B4CAEB;">
                                        <th scope="col"  style="width: 95%;">Drug Name</th>
                                        <th scope="col"  style="width: 5%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($drugs_list_deleted as $drug)
                                        <tr style="font-size: 13px;">
                                            <td>{{ $drug->drug_name }}</td>
                                            <td class="project-actions  d-flex flex-column flex-md-row gap-2 align-items-center justify-content-center">
                                                <center>
                                                    <a href="{{ route('drug.active', ['id' => $drug->id]) }}" title="Active" onclick="return confirm('Are you sure you want to active this drug?')">
                                                        <button class="btn btn-outline-dark"> <i class="fa fa-share"> Active</i></button>
                                                    </a>
                                                </center>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="card-body">

                    </div>

                </div>
            </div>
        </div>
    @endsection
    @include('footer')
</body>

</html>
