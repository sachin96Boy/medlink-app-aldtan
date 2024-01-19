<!DOCTYPE html>
<html lang="en">

<head>
    <title>Diagnostics</title>
    @include('header')

</head>

<body class="g-sidenav-show  bg-gray-100">
    @extends('layouts.app')
    @section('content')
        <div class="container">
            <div class="row">
                
                
                        
                       
 <center>
                    <h4>DIAGNOSTIC MANAGE</h4>
                </center>

                <div class="col-12" >
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                                type="button" role="tab" aria-controls="home" aria-selected="true">Active
                                Categorie</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                                type="button" role="tab" aria-controls="profile" aria-selected="false">Deactive
                                Categorie</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <form action="{{ route('diagnosticCategorie.search') }}" method="post">
                                @csrf
                                @error('cat_name')
                                    <div role="alert" id="alert-dialog"
                                        class="alert m-2 rounded alert-danger alert-dismissible fade show flex-end">
                                        Diagnostic category required<button id='close-alert' type="button" class="close"
                                            data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button></div>
                                @enderror
                                <div class="d-flex flex-column flex-md-row py-2 align-items-center justify-content-start">
                                    <div class="col-3 d-flex">
                                        <input style=" font-size: 12px;" type="text" class="form-control" id="cat_name"
                                            name="cat_name" placeholder="Diagnostic Categorie Name" value="">
                                    </div>
                                    <div class="col-3 d-flex pt-3 gap-2">
                                        <button type="submit"
                                            style=" border-radius: 30px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);"
                                            class="btn  btn-info btn-sm"><b>Search</b></button>
                                        <a href="{{ route('diagnosticCategories_view') }}"><button type="button"
                                                name="clear"
                                                style=" border-radius: 30px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);"
                                                class="btn  btn-info btn-sm"><b>Clear</b></button></a>
                                    </div>
                                    <div class="col-6 d-flex pt-3 gap-2 justify-content-end" style="margin-top: 3px;">
                                        <a href="{{ route('diagnosticCategoriesAdd.view') }}"><button
                        style="border-radius: 30px; background-image: linear-gradient(to bottom, #7900ff, #2b8ffc);box-shadow: 1px 5px 1px rgba(0, 0, 0, 0.1);"
                        type="button" class="btn  btn-info btn-sm"><b> Add Diagnostic Categorie</b></button></a>
                                    </div>
                                </div>
                            </form>
                                                <div class="table-container" style="max-height: 50vh; overflow-y: auto;">

                            <table id="example1" class="table table-bordered" style="background-color: #e6eef4;">
                                <thead style="position: sticky; top: 0; z-index: 1;">
                                    <tr style="font-size: 14px; background-color: #B4CAEB;">
                                        <th scope="col" style="width: 95%;">Diagnostic Categorie Name</th>
                                        <th scope="col" style="width: 5%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($diagnosticcategories_list as $diagnosticcategories)
                                        <tr style="font-size: 13px;">
                                            <td>{{ $diagnosticcategories->category_name }}</td>
                                            <td class="project-actions d-flex flex-column flex-md-row gap-2 align-items-center justify-content-center">
                                                <center>
                                                    <a href="{{ route('diagnosticCategorieEdit', ['id' => $diagnosticcategories->id]) }}" title="Edit"
                                                        onclick="return confirm('Are you sure you want to Edit this diagnostic category?');">
                                                        <button class="btn btn-outline-dark"> <i class="fa fa-pencil-square"></i> Edit</button>
                                                    </a>
                                                    <a href="{{ route('diagnosticCategories.delete', ['id' => $diagnosticcategories->id]) }}"
                                                        title="Delete"
                                                        onclick="return confirm('Are you sure you want to delete this diagnostic category?');">
                                                        <button class="btn btn-outline-danger"> <i class="fa fa-trash"> </i>Delete</button>
                                                    </a>
                                                </center>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="d-flex flex-column flex-md-row py-2 align-items-center justify-content-start">
                            <div class="d-flex">
                                <input style="font-size: 12px;" type="text" class="form-control" id="dia_name_de"
                                    name="dia_name_de" placeholder="Search Diagnostic Name" value="" onkeyup="searchFunction()">
                            </div>
                             @error('drug_name_de')
                                <div role="alert" id="alert-dialog"
                                        class="alert m-2 rounded alert-danger alert-dismissible fade show flex-end">
                                        Drug name required<button id='close-alert' type="button" class="close"
                                            data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button></div>
                            @enderror
                            
                        </div>
                            <div class="table-container" style="max-height: 550px; overflow-y: auto;">
                            <table id="example2" class="table table-bordered" style="background-color: #e6eef4;">
                                <thead style="position: sticky; top: 0; z-index: 1;">
                                    <tr style="font-size: 14px; background-color: #B4CAEB;">
                                        <th scope="col" style="width: 95%;">Diagnostic Categorie Name</th>
                                        <th scope="col" style="width: 5%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($diagnosticcategories_deleted_list as $diagnosticcategories)
                                        <tr style="font-size: 13px;">
                                            <td>{{ $diagnosticcategories->category_name }}</td>
                                            <td class="project-actions d-flex flex-column flex-md-row gap-2 align-items-center justify-content-center">
                                                <center>
                                                    <a href="{{ route('diagnosticCategories.active', ['id' => $diagnosticcategories->id]) }}"
                                                        title="Active"
                                                        onclick="return confirm('Are you sure you want to active this diagnostic category?');">
                                                        <button class="btn btn-outline-dark"> <i class="fa fa-share"></i> Active</button>
                                                    </a>
                                                </center>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>


                    <div class="card-body">

                    </div>

                </div>
            </div>
        </div>
        <script>
function searchFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("dia_name_de");
  filter = input.value.toUpperCase();
  table = document.getElementById("example2");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>
    @endsection
    @include('footer')
</body>
</html>
