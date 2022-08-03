@extends('layouts.main')
@section('viewContent')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title">Dashboard</h2>
        </div>
    </div>
</div>


    <div class="row">
        <!-- ============================================================== -->
        <!-- sales  -->
        <!-- ============================================================== -->
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
            <div class="card border-3 border-top border-top-primary">
                <div class="card-body">
                    <h5 class="text-muted">Alumnos</h5>
                    <div class="metric-value d-inline-block">
                        <h1 class="mb-1">{{$students}}</h1>
                    </div>
                    <div class="metric-label d-inline-block float-right text-success font-weight-bold">
                        <span class="icon-circle-small icon-box-xs text-success bg-success-light"><i class="fa fa-fw fa-arrow-up"></i></span><span class="ml-1">5.86%</span>
                    </div>
                </div>
                <div id="sparkline-revenue"></div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end sales  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- new customer  -->
        <!-- ============================================================== -->
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
            <div class="card border-3 border-top border-top-primary">
                <div class="card-body">
                    <h5 class="text-muted">Colaboradores</h5>
                    <div class="metric-value d-inline-block">
                        <h1 class="mb-1">{{$collaborators}}</h1>
                    </div>
                    <div class="metric-label d-inline-block float-right text-success font-weight-bold">
                        <span class="icon-circle-small icon-box-xs text-success bg-success-light"><i class="fa fa-fw fa-arrow-up"></i></span><span class="ml-1">10%</span>
                    </div>
                </div>
                <div id="sparkline-revenue2"></div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end new customer  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- visitor  -->
        <!-- ============================================================== -->
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
            <div class="card border-3 border-top border-top-primary">
                <div class="card-body">
                    <h5 class="text-muted">Prospectos</h5>
                    <div class="metric-value d-inline-block">
                        <h1 class="mb-1">{{$students_prospect}}</h1>
                    </div>
                    <div class="metric-label d-inline-block float-right text-success font-weight-bold">
                        <span class="icon-circle-small icon-box-xs text-success bg-success-light"><i class="fa fa-fw fa-arrow-up"></i></span><span class="ml-1">5%</span>
                    </div>
                </div>
                <div id="sparkline-revenue3"></div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end visitor  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- total orders  -->
        <!-- ============================================================== -->
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
            <div class="card border-3 border-top border-top-primary">
                <div class="card-body">
                    <h5 class="text-muted">Generaciones</h5>
                    <div class="metric-value d-inline-block">
                        <h1 class="mb-1">{{$generations}}</h1>
                    </div>
                    <div class="metric-label d-inline-block float-right text-danger font-weight-bold">
                        <span class="icon-circle-small icon-box-xs text-danger bg-danger-light bg-danger-light "><i class="fa fa-fw fa-arrow-down"></i></span><span class="ml-1">4%</span>
                    </div>
                </div>
                <div id="sparkline-revenue4"></div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end total orders  -->
        <!-- ============================================================== -->
    </div>

</div> 
<script src="{{ asset('assets/vendor/jquery/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('assets/vendor/toast/toastr.js') }}"></script>

<script>
    window.onload = main;
function main(){

    
   const http = new XMLHttpRequest();
   http.open('get', 'http://192.168.1.68:8001/api/alum_grafic', true);
   http.send();
   http.onreadystatechange = dat

 function dat(){
     if(this.readyState==4 && this.status==200)
     {
       var dats = JSON.parse(this.responseText);
       let vari = dats.data;
       
       //console.log(vari);

       $("#sparkline-revenue").sparkline([vari[0],vari[1],vari[2]], {
        type: 'line',
        width: '99.5%',
        height: '100',
        lineColor: '#5969ff',
        fillColor: '#dbdeff',
        lineWidth: 2,
        spotColor: undefined,
        minSpotColor: undefined,
        maxSpotColor: undefined,
        highlightSpotColor: undefined,
        highlightLineColor: undefined,
        resize: true
    });
}
}

const ht = new XMLHttpRequest();
   ht.open('get', 'http://192.168.1.68:8001/api/grafic_collaborator', true);
   ht.send();
   ht.onreadystatechange = grafic_C
function grafic_C () {

    if(this.readyState==4 && this.status==200)
     {
       var dats = JSON.parse(this.responseText);
       let vari = dats.data;
       
       console.log(vari);

       $("#sparkline-revenue2").sparkline([], {
        type: 'line',
        width: '99.5%',
        height: '100',
        lineColor: '#5969ff',
        fillColor: '#dbdeff',
        lineWidth: 2,
        spotColor: undefined,
        minSpotColor: undefined,
        maxSpotColor: undefined,
        highlightSpotColor: undefined,
        highlightLineColor: undefined,
        resize: true
    });
}


}







const pros = new XMLHttpRequest();
pros.open('get', 'http://192.168.1.68:8001/api/alum_grafic_pros', true);
pros.send();
pros.onreadystatechange = datos

function datos (){
    if(this.readyState==4 && this.status==200)
     {
       var dats = JSON.parse(this.responseText);
       let vari = dats.data;
       
 
$("#sparkline-revenue3").sparkline([vari[0],vari[1],vari[2]], {
        type: 'line',
        width: '99.5%',
        height: '100',
        lineColor: '#ff407b',
        fillColor: '#ffdbe6',
        lineWidth: 2,
        spotColor: undefined,
        minSpotColor: undefined,
        maxSpotColor: undefined,
        highlightSpotColor: undefined,
        highlightLineColor: undefined,
        resize: true
    });
}

}

const generations = new XMLHttpRequest();
    generations.open('get','http://192.168.1.68:8001/api/generationsGrafic',true);
    generations.send();
    generations.onreadystatechange  = grafic_g
     
function grafic_g()
{
    if(this.readyState == 4 && this.status == 200){
        var datos = JSON.parse(this.responseText);
        let vari = datos.data;
        
        
        $("#sparkline-revenue4").sparkline([vari[0],vari[1],vari[2],vari[3],vari[4]], {
        type: 'line',
        width: '99.5%',
        height: '100',
        lineColor: '#fec957',
        fillColor: '#fff2d5',
        lineWidth: 2,
        spotColor: undefined,
        minSpotColor: undefined,
        maxSpotColor: undefined,
        highlightSpotColor: undefined,
        highlightLineColor: undefined,
        resize: true,
    });




    }

}





}//main

</script>
@endsection