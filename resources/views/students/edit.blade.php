<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>

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
        <form id="validationform" action="{{ url('students/update') }}" method="POST" enctype="multipart/form-data" data-parsley-validate="" novalidate="">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $person->id }}">
            <input type="hidden" name="id_person" value="{{ $person->id_person }}">
            <input type="hidden" name="id_address" value="{{ $address->id }}" id="{{ $person->id_person }}">
                    
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Nombre (s)</label>
                        <div class="col-12 col-sm-8 col-lg-6">
                            <input type="text" name="name" placeholder="Nombre del estudiante" value="{{ $person->name }}" class="form-control @error('discount') is-invalid @enderror">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-form-label text-sm-right">Apellidos</label>
                        <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                            <input name="last_father_name" type="text" placeholder="Apellido Paterno" value="{{ $person->last_father_name }}" class="form-control datetimepicker-input @error('last_father_name') is-invalid @enderror" 
                                data-toggle="tooltip" data-placement="top" title="Primer apellido (obligatorio)">
                            @error('last_father_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    @enderror
                                </span>
                        </div>
                        <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                            <input name="last_mother_name" type="text" value="{{ $person->last_mother_name }}" placeholder="Apellido Materno" class="form-control datetimepicker-input @error('last_mother_name') is-invalid @enderror" 
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
                            <input type="date" name="birth_date" value="{{ $person->birth_date }}" class="form-control @error('birth_date') is-invalid @enderror">
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
                            <input type="text" name="email" placeholder="Correo Electronico" value="{{ $person->email }}" class="form-control @error('discount') is-invalid @enderror">
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
                                <input type="text" name="full_address" value="{{ $person->full_address}}" placeholder="Dirección completa (Calle, número, colonia)" class="form-control @error('full_address') is-invalid @enderror">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Ciudad</label>
                            <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                                <input name="city" type="text" placeholder="Ciudad"  value="{{ $person->city }}" class="form-control datetimepicker-input @error('city') is-invalid @enderror">
                                @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <label class="col-sm-4 col-lg-1 mb-3 mb-sm-0 col-form-label text-sm-right">Código postal</label>
                            <div class="col-sm-4 col-lg-2 mb-3 mb-sm-0">
                                <input name="postal_code" type="text" placeholder="Código postal" value="{{ $person->postal_code}}" class="form-control datetimepicker-input @error('postal_code') is-invalid @enderror">
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
                                <input name="state" type="text" placeholder="Estado" value="{{ $person->state}}" class="form-control datetimepicker-input @error('state') is-invalid @enderror" 
                                    data-toggle="tooltip" data-placement="top" title="Estado">
                                @error('state')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                                <input name="country" type="text" placeholder="País " value="{{ $person->country}}" class="form-control datetimepicker-input @error('country') is-invalid @enderror" 
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
                                        <input type="text" id="Text_Curp" name="Curp"  class="form-control" placeholder="Ingresa tu CURP" required>                                                                
                                        </div>

                                    </div>
                                    

                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <h6 style="font-size:15px" class="mb-0">INE: <a href="#"><i class="lni lni-question-circle" data-toggle="tooltip" data-placement="left" title="Solo para residentes Mexicanos"></i></a></h6>
                                        </div>
                                        
                                        <div class="col-sm-10 text-secondary">
                                            <input type="text" id="Text_Ine" name="Ine"  class="form-control no-validate-form" placeholder="Ingresa tu INE" required>
                                            
                                        </div>
                                    </div>


                                    <div class="col-12 mb-3">
                                        <div class="col-sm-4">
                                            <h6 style="font-size:15px">Documento curp / ID <br> Extranjeros: </h6>
                                        </div>
                                        <div class="col-sm-8 text-secondary">
                                          <input id="DataCurp" name="CURP"  type="file" class="form-control" aria-label="file example" required>
                                        </div>
                                        <div class="float-sm-right text-secondary">
                                        <a style="color: black" onclick="modalcurp({{ $person->id_person }})"><i style="padding-left: 216px" class="fa-solid fa-eye"></i></a>
                                        </div>
                                    </div>
                                    
                                    



                                <div class="col-12 mb-3">
                                    <div class="col-sm-4">
                                        <h6 style="font-size:15px">Documento INE: &nbsp; </h6>
                                    </div>
                                    <div class="col-sm-8 text-secondary">
                                    <input id="DataIne" name="INE" type="file"class="form-control no-validate-form" aria-label="file example" required>
                                    </div>
                                    <div class="float-sm-right text-secondary">
                                    <a style="color: black" onclick="modalIne({{ $person->id_person }})"><i style="padding-left: 178px"class="fa-solid fa-eye"></i></a>
                                    </div>
                                </div>
                                    
                                    
                            




                                    {{-- confirmacion de los documentos --}}

                                    <div class="col-12 mb-3">
                                        <div class="col-sm-4">
                                            <h6 style="font-size:15px">Identificacion oficial: &nbsp; </h6>
                                        </div>
                                        <div class="col-sm-8 text-secondary">
                                        <input id="DataIdentificacion" name="Data_Identificacion" type="file" class="form-control no-validate-form" aria-label="file example" required>
                                        </div>
                                        <div class="float-sm-right text-secondary">
                                        <a style="color: black" onclick="modalIdentificacion({{ $person->id_person }})"><i style="padding-left: 141px" class="fa-solid fa-eye"></i></a>
                                    </div>
                                        
                                    </div>
                                    
                                    
                                    
                                    


                                    <div class="col-12 mb-3">
                                        <div class="col-sm-4">
                                            <h6 style="font-size:15px">Certificado de estudios: &nbsp; </h6>
                                        </div>
                                        <div class="col-sm-8 text-secondary">
                                        <input id="DataCertificado" name="Data_Certificado" type="file" class="form-control no-validate-form" aria-label="file example" required>
                                        </div>                                
                                        <div class="float-sm-right text-secondary">
                                        <a style="color: black" onclick="modalCertificado({{ $person->id_person }})"><i style="padding-left: 121px" class="fa-solid fa-eye"></i></a>
                                    </div>
                                    </div>
                                    
                                    

                                    <div class="col-12 mb-3">
                                        <div class="col-sm-4">
                                            <h6 style="font-size:15px">Cedula profesional: &nbsp; </h6>
                                        </div>
                                        <div class="col-sm-8 text-secondary">
                                        <input id="DataCedula" name="Data_Cedula" type="file" class="form-control no-validate-form" aria-label="file example" required>
                                        </div>
                                        <div class="float-sm-right text-secondary">
                                        <a style="color: black" onclick="modalCedula({{ $person->id_person }})"><i style="padding-left: 154px" class="fa-solid fa-eye"></i></a>
                                    </div>
                                    </div>
                                    
                                    
                                    

                                    
                                    <div class="col-12 mb-3">
                                        <div class="col-sm-4">
                                            <h6 style="font-size:15px">Titulo: &nbsp; </h6>
                                        </div>
                                        <div class="col-sm-8 text-secondary">
                                        <input id="DataTitulo" name="Data_Titulo" type="file" class="form-control no-validate-form" aria-label="file example" required>
                                        </div>                                
                                        <div class="float-sm-right text-secondary">
                                        <a style="color: black" onclick="modalTitulo({{ $person->id_person }})"><i style="padding-left: 247px" class="fa-solid fa-eye"></i></a>
                                    </div>
                                    </div>
                                    
                                    
                                    
                                    
                                    <div class="col-12 mb-3">
                                        <div class="col-sm-4">
                                            <h6 style="font-size:15px">Comprobante de estudios: &nbsp; </h6>
                                        </div>
                                        <div class="col-sm-8 text-secondary">
                                        <input id="DataEstudiante" name="Data_Estudiante" type="file" class="form-control no-validate-form" aria-label="file example" required>
                                        </div>                            
                                        <div class="float-sm-right text-secondary">
                                        <a style="color: black" onclick="modalEstudiante({{ $person->id_person }})"><i style="padding-left: 104px" class="fa-solid fa-eye"></i></a>
                                    </div>
                                </div>
                            </div>
                    <div class="form-group row text-right">
                        <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                            <a class="btn btn-space btn-primary text-white btnNext">Siguiente<i class="fas fa-arrow-right"></i></a>
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

                            <div class="col-md-4">
                                <label for="validationCustom07" class="form-label">Regimen fiscal(Emisor):</label>
                                <input placeholder="Regimen fiscal(Emisor)" class="form-control" name="text" id="" />
                            </div>

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
                                        <option value="" selected>Selecciona una opción</option>
                                        <option value="1">P01 POR DEFINIR</option>
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
                                    <option value="" selected>Selecciona una opción</option>
                                    <option value="1">PUE PAGO EN UNA SOLA EXHIBICIÓN</option>
                                  </select>
                            </div>

                            <div class="col-md-4">
                                <label for="validationCustom07" class="form-label">Forma de Pago</label>
                                <select class="selectpicker show-tick show-menu-arrow form-control" aria-label="Default select example">
                                    <option value="" selected>Selecciona una opción</option>
                                    <option value="1">01 EFECTIVO</option>
                                  </select>
                                </div>

                            <div class="col-md-4">
                                <label for="validationCustom07" class="form-label">Tipo de moneda</label>
                                <input placeholder="Tipo de moneda" class="form-control" name="text" id="" />
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
                            </div>
                        </div>
                    </div>
                </div>


                 <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Documento de Identificacion</h5>   
                            </div>
                            <div class="modal-body">
                                <img id="modalGeneri" src="" height="200" width="200" alt="" class="img-fluid mr-3 mx-auto d-block">
                                <br/>
                                <input type="hidden" name="url_img" id="url_img">
                                <input type="hidden" name="code" id="code">
                                <input type="hidden" name="id_D" id="id_D">
                                {{-- <input type="hidden" name="id_person" value="{{ $person->id_person }}" id="{{ $person->id_person }}">
                                <input type="hidden" name="id_student" value="{{ $student->id }}">
                                <button id="veri" type="submit" class="btn btn-space btn-primary" onclick="return validate({{ $person->id_person }},event)">Verificar</button> --}}
                                
                            </div>
                            
                            <div class="modal-footer">
                            <button type="reset" class="btn btn-space btn-secondary" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>

  
<!-- jquery 3.3.1 -->
<script src="{{ asset('assets/vendor/jquery/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('assets/vendor/toast/toastr.js') }}"></script>
<script>


        $('.btnNext').click(function(){
        $('.nav-item > .active').parent().next('li').find('a').trigger('click');
        });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

<script>

function validate(id,event) {

   var url_img= $('#url_img').val(); 
   var code= $('#code').val(); 
   var id_D= $('#id_D').val(); 
   
   var formData = new FormData();            
    formData.append('code', code);
    formData.append('id_person', id);
    formData.append('id_D', id_D);
    
    fetch('http://192.168.1.68:8001/api/validate_D', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(dat=>{

        var datos = dat.data;
        //var id = datos[0].id;
        if(datos){
            
            toastr.success('Se ah verificado correctamente');
            $('#editModal').modal('hide');
            
       
        }
            
    })


}

function preVmodal(id,name,event){
    
    var formData = new FormData();            
    formData.append('name', name);
    formData.append('id', id);
    
                
    fetch('http://192.168.1.68:8001/api/documents', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(dat=>{

        var url_img;
        var code;
        var id_D;
        var datos = dat.data;
        if(datos){
            //    $('#modalGeneric').attr('src', '../../'+datos[0].url_img); 
            
            
            if(datos[0].is_validate==0){

            url_img = datos[0].url_img;
            code = datos[0].code;
            id_D= datos[0].id

            $('#modalGeneri').attr('src', '../../'+datos[0].url_img); 
            $('#editModal').modal('show');
            $('#url_img').val(url_img);
            $('#code').val(code);
            $('#id_D').val(id_D);
            }else{
             $('#modalGeneric').attr('src', '../../'+datos[0].url_img); 
             $('#exampleModal').modal('show');
             toastr.success('Las imagenes verificadas no se pueden actualizar');
            }
        }
    })
}


       function modalcurp(id){
            const file = $('#DataCurp').prop('files');
            const reader = new FileReader();
            const name = $('#DataCurp').attr('name')

            reader.addEventListener("load", function (){
                $('#modalGeneric').attr('src', reader.result); 
            });
            
            if(file[0]){
                reader.readAsDataURL(file[0]);
                $('#exampleModal').modal('show');
            }
            else{
                
                preVmodal(id,name ,event);
            }
	}

        function modalIne(id){
            const file = $('#DataIne').prop('files');
            const reader = new FileReader();
            const name = $('#DataIne').attr('name')


            reader.addEventListener("load", function (){
                $('#modalGeneric').attr('src', reader.result); 
            });
            
            if(file[0]){
                
                reader.readAsDataURL(file[0]);
                $('#exampleModal').modal('show');
            }
            else{
                
                preVmodal(id,name ,event);
            }
	}

        function modalIdentificacion(id){
            const file = $('#DataIdentificacion').prop('files');
            const reader = new FileReader();
            const name = $('#DataIdentificacion').attr('name')

            reader.addEventListener("load", function (){
                $('#modalGeneric').attr('src', reader.result); 
            });
            
            if(file[0]){
                reader.readAsDataURL(file[0]);
                $('#exampleModal').modal('show');
            }
            else{
                
                preVmodal(id,name ,event);
            }
	}
        function modalCertificado(id){
            const file = $('#DataCertificado').prop('files');            
            const reader = new FileReader();
            const name = $('#DataCertificado').attr('name')

            reader.addEventListener("load", function (){
                $('#modalGeneric').attr('src', reader.result); 
            });
            
            if(file[0]){
                reader.readAsDataURL(file[0]);
                $('#exampleModal').modal('show');
            }
            else{
                
                preVmodal(id,name ,event);
            }
	}
    
        function modalExtranjeros(id){
            const file = $('#DataExtranjeros').prop('files');
            const reader = new FileReader();
            const name = $('#DataExtranjeros').attr('name')

            reader.addEventListener("load", function (){
                $('#modalGeneric').attr('src', reader.result); 
            });
            
            if(file[0]){
                reader.readAsDataURL(file[0]);
                $('#exampleModal').modal('show');
            }
            else{
                
                preVmodal(id,name ,event);
            }
	}
        function modalCedula(id){
            const file = $('#DataCedula').prop('files');
            const reader = new FileReader();
            const name = $('#DataCedula').attr('name')

            reader.addEventListener("load", function (){
                $('#modalGeneric').attr('src', reader.result); 
            });
            
            if(file[0]){
                reader.readAsDataURL(file[0]);
                $('#exampleModal').modal('show');
            }
            else{
                
                preVmodal(id,name ,event);
            }
	}

    function modalTitulo(id){
            const file = $('#DataTitulo').prop('files');
            const reader = new FileReader();
            const name = $('#DataTitulo').attr('name')

            reader.addEventListener("load", function (){
                $('#modalGeneric').attr('src', reader.result); 
            });
            
            if(file[0]){
                reader.readAsDataURL(file[0]);
                $('#exampleModal').modal('show');
            }
            else{
                
                preVmodal(id,name ,event);
            }
	}

    function modalEstudiante(id){
            const file = $('#DataEstudiante').prop('files');
            const reader = new FileReader();
            const name = $('#DataEstudiante').attr('name')

            reader.addEventListener("load", function (){
                $('#modalGeneric').attr('src', reader.result); 
            });
            
            if(file[0]){
                reader.readAsDataURL(file[0]);
                $('#exampleModal').modal('show');
            }
            else{
                
                preVmodal(id,name ,event);
            }
	}

</script>

@endsection