<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>

@extends('layouts.main')
@section('viewContent')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title"> Registrar Alumno </h2>
            <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <div class="col-sm-6 pb-2 pb-sm-4 pb-lg-0 pr-0">
                            <h5>
                                <a href="javascript:history.back()"><i class="fas fa-arrow-left"></i> Regresar</a>
                            </h5>
                        </div>
                    </ol>   
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="tab-regular">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="personal-tab" data-toggle="tab" href="#personal" role="tab" aria-controls="personal" aria-selected="true">Datos personales</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="address-tab" data-toggle="tab" href="#address" role="tab" aria-controls="address" aria-selected="false">Dirección</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="docs-tab" data-toggle="tab" href="#docs" role="tab" aria-controls="docs" aria-selected="false">Documentos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="factur-tab" data-toggle="tab" href="#factur" role="tab" aria-controls="docs" aria-selected="false">Datos de Facturacion</a>
            </li>
        </ul>
        <form id="validationform" action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data" data-parsley-validate="" novalidate="">
            @csrf
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Nombre (s)</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <input type="text" name="name" placeholder="Nombre del estudiante" class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    @enderror
                                </span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Apellidos</label>
                        <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                            <input name="last_father_name" type="text" placeholder="Apellido Paterno" class="form-control datetimepicker-input @error('last_father_name') is-invalid @enderror" 
                                data-toggle="tooltip" data-placement="top" title="Primer apellido (obligatorio)">
                            @error('last_father_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    @enderror
                                </span>
                        </div>
                        <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                            <input name="last_mother_name" type="text" placeholder="Apellido Materno" class="form-control datetimepicker-input @error('last_mother_name') is-invalid @enderror" 
                                data-toggle="tooltip" data-placement="top" title="Segundo apellido (opcional)">
                            @error('last_mother_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Fecha de nacimiento</label>
                        <div class="col-sm-4 col-lg-2 mb-3 mb-sm-0">
                            <input type="date" name="birth_date" class="form-control @error('birth_date') is-invalid @enderror">
                        </div>

                        <label class="ol-sm-4 col-lg-2 mb-3 mb-sm-0 col-form-label text-sm-right">Género</label>
                        <div class="col-sm-4 col-lg-2 mb-3 mb-sm-0">
                            <select name="gender" class="selectpicker show-tick show-menu-arrow form-control @error('gender') is-invalid @enderror" 
                                is-invalid data-toggle="tooltip" data-placement="top" title="Género" data-header="Selecciona una opción">
                                @foreach ($gender_list as $gender)
                                    <option value="{{ $gender->code }}">{{ $gender->label }}</option>            
                                @endforeach                                        
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Correo Electronico</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <input type="text" name="email" placeholder="Correo Electronico" class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    @enderror
                                </span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Estatus</label>
                        <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                            <div class="col-12 col-sm-8 col-lg-6 pt-1">
                                <div class="switch-button switch-button-success">
                                    <input type="checkbox" name="status" id="status" class="form-control @error('status') is-invalid @enderror"><span>
                                <label for="status"></label></span>
                                </div>
                            </div>
                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row text-right">
                        <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                            <a class="btn btn-space btn-primary text-white btnNext">Siguiente <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                    <div class="form-group">
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Dirección</label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                <input type="text" name="full_address" placeholder="Dirección completa (Calle, número, colonia)" class="form-control @error('full_address') is-invalid @enderror">
                                @error('full_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Ciudad</label>
                            <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                                <input name="city" type="text" placeholder="Ciudad" class="form-control datetimepicker-input @error('city') is-invalid @enderror">
                                @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <label class="col-sm-4 col-lg-1 mb-3 mb-sm-0 col-form-label text-sm-right mr-3">Código postal</label>
                            <div class="col-sm-4 col-lg-2 mb-3 mb-sm-0">
                                <input name="postal_code" type="text" placeholder="Código postal" class="form-control datetimepicker-input @error('postal_code') is-invalid @enderror">
                                @error('postal_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Entidad</label>
                            <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                                <input name="state" type="text" placeholder="Estado" class="form-control datetimepicker-input @error('state') is-invalid @enderror" 
                                    data-toggle="tooltip" data-placement="top" title="Estado">
                                @error('state')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                                <input name="country" type="text" placeholder="País" class="form-control datetimepicker-input @error('country') is-invalid @enderror" 
                                    data-toggle="tooltip" data-placement="top" title="País">
                                @error('country')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group row text-right">
                        <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                            <a class="btn btn-space btn-primary text-white btnNext">Siguiente <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="docs" role="tabpanel" aria-labelledby="docs-tab">
                    <div class="form-group row justify-content-center">
                        
                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                        <h6 style="font-size:15px" class="mb-0">Curp / ID Extranjeros:</h6>
                                        </div>
                                                            
                                        <div class="col-sm-10 text-secondary">
                                        <input type="text" id="Text_Curp" name="Curp" class="form-control" placeholder="Ingresa tu CURP" required>                                                                
                                        </div>

                                    </div>
                                    

                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <h6 style="font-size:15px" class="mb-0">INE: <a href="#"><i class="lni lni-question-circle" data-toggle="tooltip" data-placement="left" title="Solo para residentes Mexicanos"></i></a></h6>
                                        </div>
                                        
                                        <div class="col-sm-10 text-secondary">
                                            <input type="text" id="Text_Ine" name="Ine" class="form-control no-validate-form" placeholder="Ingresa tu INE" required>
                                            
                                        </div>
                                    </div>


                                    <div class="col-12 mb-3">
                                        <div class="col-sm-4">
                                            <h6 style="font-size:15px">Documento curp / ID <br> Extranjeros: </h6>
                                        </div>
                                        <div class="col-sm-8 text-secondary">
                                          <input id="DataCurp" name="Img_Curp" type="file" class="form-control" aria-label="file example" required>
                                        </div>
                                    </div>
                                    <a style="color: black" onclick="modalcurp()"><i style="padding-left: 216px" class="fa-solid fa-eye"></i></a>



                                <div class="col-12 mb-3">
                                    <div class="col-sm-4">
                                        <h6 style="font-size:15px">Documento INE: &nbsp; </h6>
                                    </div>
                                    <div class="col-sm-8 text-secondary">
                                    <input id="DataIne" name="Img_Ine" type="file"class="form-control no-validate-form" aria-label="file example" required>
                                    </div>
                                </div>
                                <a style="color: black" onclick="modalIne()"><i style="padding-left: 178px"class="fa-solid fa-eye"></i></a>

                                    {{-- confirmacion de los documentos --}}

                                    <div class="col-12 mb-3">
                                        <div class="col-sm-4">
                                            <h6 style="font-size:15px">Identificacion oficial: &nbsp; </h6>
                                        </div>
                                        <div class="col-sm-8 text-secondary">
                                        <input id="DataIdentificacion" name="Data_Identificacion" type="file" class="form-control no-validate-form" aria-label="file example" required>
                                        </div>
                                    </div>
                                    <a style="color: black" onclick="modalIdentificacion()"><i style="padding-left: 141px" class="fa-solid fa-eye"></i></a>

                                    <div class="col-12 mb-3">
                                        <div class="col-sm-4">
                                            <h6 style="font-size:15px">Certificado de estudios: &nbsp; </h6>
                                        </div>
                                        <div class="col-sm-8 text-secondary">
                                        <input id="DataCertificado" name="Data_Certificado" type="file" class="form-control no-validate-form" aria-label="file example" required>
                                        </div>
                                    </div>
                                    <a style="color: black" onclick="modalCertificado()"><i style="padding-left: 121px" class="fa-solid fa-eye"></i></a>
                                    
                                    <div class="col-12 mb-3">
                                        <div class="col-sm-4">
                                            <h6 style="font-size:15px">Cedula profesional: &nbsp; </h6>
                                        </div>
                                        <div class="col-sm-8 text-secondary">
                                <input id="DataCedula" name="Data_Cedula" type="file" class="form-control no-validate-form" aria-label="file example" required>
                                        </div>
                                    </div>
                                    <a style="color: black" onclick="modalCedula()"><i style="padding-left: 154px" class="fa-solid fa-eye"></i></a>

                                    
                                    <div class="col-12 mb-3">
                                        <div class="col-sm-4">
                                            <h6 style="font-size:15px">Titulo: &nbsp; </h6>
                                        </div>
                                        <div class="col-sm-8 text-secondary">
                                        <input id="DataTitulo" name="Data_Titulo" type="file" class="form-control no-validate-form" aria-label="file example" required>
                                        </div>
                                    </div>
                                    <a style="color: black" onclick="modalTitulo()"><i style="padding-left: 247px" class="fa-solid fa-eye"></i></a>
                                    
                                    <div class="col-12 mb-3">
                                        <div class="col-sm-4">
                                            <h6 style="font-size:15px">Comprobante de estudios: &nbsp; </h6>
                                        </div>
                                        <div class="col-sm-8 text-secondary">
                                        <input id="DataEstudiante" name="Data_Estudiante" type="file" class="form-control no-validate-form" aria-label="file example" required>
                                        </div>
                                    </div>
                                    <a style="color: black" onclick="modalEstudiante()"><i style="padding-left: 104px" class="fa-solid fa-eye"></i></a>



                    </div>
                    <div class="form-group row text-right">
                        <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                            <button type="submit" class="btn btn-space btn-primary">Guardar</button>
                            <button type="reset" class="btn btn-space btn-secondary">Cancelar</button>
                        </div>
                    </div>
                </div>
                
                <div class="tab-pane fade" id="factur" role="tabpanel" aria-labelledby="factur-tab">
                    <div class="form-group row justify-content-center">
                        
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="validationCustom07" class="form-label">Nombre (Emisor):</label>
                                <input placeholder="Nombre (Emisor)" class="form-control" name="text" id="" />
                            </div>

                            {{-- <div class="col-md-4">
                                <label for="validationCustom07" class="form-label">Regimen fiscal(Emisor):</label>
                                <input placeholder="Regimen fiscal(Emisor)" class="form-control" name="text" id="" />
                            </div> --}}

                            <div class="col-md-4">
                                <label for="validationCustom07" class="form-label">PERSONA FISICA O MORAL</label>
                                <select class="selectpicker show-tick show-menu-arrow form-control" aria-label="Default select example">
                                    @foreach ($Physical_or_moral_person as $person)
                                    <option value="{{ $person->code }}">{{ $person->label }}</option>
                                    @endforeach
                                  </select>
                                  
                            </div>

                            <div class="col-md-4">
                                <label for="validationCustom07" class="form-label">RFC (Receptor)</label>
                                <input placeholder="RFC VECJ880326 XXX" class="form-control" name="text" id="" />
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Uso de (CFDI)</label>
                                {{-- <div class="col-3 col-lg-4"> --}}
                                    <select id="frequency" name="frequency" class="selectpicker show-tick show-menu-arrow form-control">
                                        @foreach ($Use_of_cfdi as $factur)
                                        <option value="{{ $factur->code }}">{{ $factur->label }}</option>
                                        @endforeach
                                    </select>
                                {{-- </div> --}}
                            </div>

                            <div class="col-md-4">
                                <label for="validationCustom07" class="form-label">Domicilio fiscal</label>
                                <input placeholder="RFC VECJ880326 XXX" class="form-control" name="text" id="" />
                            </div>

                            <div class="col-md-4">
                                <label for="validationCustom07" class="form-label">Metodo de pago</label>
                                <select class="selectpicker show-tick show-menu-arrow form-control" aria-label="Default select example">
                                    @foreach ($Payment_method as $method)
                                    <option value="{{ $method->code }}">{{ $method->label }}</option>
                                    @endforeach
                                  </select>
                            </div>

                            <div class="col-md-4">
                                <label for="validationCustom07" class="form-label">Forma de Pago</label>
                                <select class="selectpicker show-tick show-menu-arrow form-control" aria-label="Default select example">
                                    @foreach ($Way_to_pay as $way)
                                    <option value="{{ $way->code }}">{{ $way->label }}</option>
                                    @endforeach
                                  </select>
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="validationCustom07" class="form-label">Tipo de Moneda</label>
                                    <select class="selectpicker show-tick show-menu-arrow form-control" aria-label="Default select example">
                                        @foreach ($currency_list as $list)
                                        <option value="{{ $list->code }}">{{ $list->label }}</option>
                                        @endforeach
                                      </select>
                                    </div>
                            
                            
                        </div>
                        
                </div>
                <div class="form-group row text-right">
                    <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                        <button type="submit" class="btn btn-space btn-primary">Guardar</button>
                        <button type="reset" class="btn btn-space btn-secondary">Cancelar</button>
                    </div>
                </div>
            </div>

            </div>
        </form>
    </div>
</div>








<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Documento de Identificacion</h5>
                                
                            </div>
                            <div class="modal-body">
                                <img id="modalGeneric" src="" height="200" width="200" alt="" class="img-fluid mr-3 mx-auto d-block">
                            </div>
                            <div class="modal-footer">
                            <form id="validationformActive" action="{{ url('student/delete_doc') }}" method="POST" data-parsley-validate="">
                                @csrf
                                <input type="hidden" name="delete" id="delete">
                                <button type="submit" class="btn btn-space btn-primary">Verificar</button>
                                <button type="reset" class="btn btn-space btn-secondary" data-dismiss="modal">Cancelar</button>
                            </form>

                
                            </div>
                        </div>
                    </div>
                </div>














<!-- jquery 3.3.1 -->
<script src="{{ asset('assets/vendor/jquery/jquery-3.3.1.min.js') }}"></script>
<script>
        $('.btnNext').click(function(){
        $('.nav-item > .active').parent().next('li').find('a').trigger('click');
        });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script>
       function modalcurp(){
            const file = $('#DataCurp').prop('files');
            const reader = new FileReader();

            reader.addEventListener("load", function (){
                $('#modalGeneric').attr('src', reader.result); 
            });
            
            if(file[0]){
                reader.readAsDataURL(file[0]);
                $('#exampleModal').modal('show');
            }
	}

        function modalIne(){
            const file = $('#DataIne').prop('files');
            const reader = new FileReader();

            reader.addEventListener("load", function (){
                $('#modalGeneric').attr('src', reader.result); 
            });
            
            if(file[0]){
                reader.readAsDataURL(file[0]);
                $('#exampleModal').modal('show  ');
            }
	}

        function modalIdentificacion(){
            const file = $('#DataIdentificacion').prop('files');
            const reader = new FileReader();

            reader.addEventListener("load", function (){
                $('#modalGeneric').attr('src', reader.result); 
            });
            
            if(file[0]){
                reader.readAsDataURL(file[0]);
                $('#exampleModal').modal('show');
            }
	}
        function modalCertificado(){
            const file = $('#DataCertificado').prop('files');
            
            const reader = new FileReader();
            reader.addEventListener("load", function (){
                $('#modalGeneric').attr('src', reader.result); 
            });
            
            if(file[0]){
                reader.readAsDataURL(file[0]);
                $('#exampleModal').modal('show');
            }
	}
    
        function modalExtranjeros(){
            const file = $('#DataExtranjeros').prop('files');
            const reader = new FileReader();

            reader.addEventListener("load", function (){
                $('#modalGeneric').attr('src', reader.result); 
            });
            
            if(file[0]){
                reader.readAsDataURL(file[0]);
                $('#exampleModal').modal('show');
            }
	}
        function modalCedula(){
            const file = $('#DataCedula').prop('files');
            const reader = new FileReader();

            reader.addEventListener("load", function (){
                $('#modalGeneric').attr('src', reader.result); 
            });
            
            if(file[0]){
                reader.readAsDataURL(file[0]);
                $('#exampleModal').modal('show');
            }
	}

    function modalTitulo(){
            const file = $('#DataTitulo').prop('files');
            const reader = new FileReader();

            reader.addEventListener("load", function (){
                $('#modalGeneric').attr('src', reader.result); 
            });
            
            if(file[0]){
                reader.readAsDataURL(file[0]);
                $('#exampleModal').modal('show');
            }
	}

    function modalEstudiante(){
            const file = $('#DataEstudiante').prop('files');
            const reader = new FileReader();

            reader.addEventListener("load", function (){
                $('#modalGeneric').attr('src', reader.result); 
            });
            
            if(file[0]){
                reader.readAsDataURL(file[0]);
                $('#exampleModal').modal('show');
            }
	}

</script>



@endsection