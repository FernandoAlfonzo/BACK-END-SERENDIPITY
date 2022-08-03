@extends('layouts.main')
@section('viewContent')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title">Detalles</h2>
        </div>
    </div>
</div>
<div class="row">
    <div class="offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 pr-xl-0 pr-lg-0 pr-md-0  m-b-30">
                <div class="product-slider">
                    <div id="productslider-1" class="product-carousel carousel slide" data-ride="carousel">
                        {{-- <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        </ol> --}}
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block" src="../assets/images/eco-slider-img-1.png" alt="First slide">
                            </div>
                            {{-- <div class="carousel-item">
                                <img class="d-block" src="../assets/images/eco-slider-img-2.png" alt="Second slide">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block" src="../assets/images/eco-slider-img-3.png" alt="Third slide">
                            </div> --}}
                        </div>
                        {{-- <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a> --}}
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 pl-xl-0 pl-lg-0 pl-md-0 border-left m-b-30">
                <div class="product-details">
                    <div class="border-bottom pb-3 mb-3">
                        <h2 class="mb-3">{{ $service->name }}</h2>
                        <div class="product-rating d-inline-block float-right">
                            {{-- <i class="fa fa-fw fa-star"></i>
                            <i class="fa fa-fw fa-star"></i>
                            <i class="fa fa-fw fa-star"></i>
                            <i class="fa fa-fw fa-star"></i>
                            <i class="fa fa-fw fa-star"></i> --}}
                            <h3 class="mb-0 text-primary"><i class="far fa-arrow-alt-circle-up text-primary"></i> ${{ $service->max_cost }}.00</h3>
                        </div>
                        <h3 class="mb-0 text-primary"><i class="far fa-arrow-alt-circle-down text-primary"></i> ${{ $service->min_cost }}.00</h3>
                    </div>
                    <div class="product-colors border-bottom">
                        <h4>Tipo</h4>
                        <label class="product-price">{{ $service->type }}</label>
                    </div>
                    <div class="product-size border-bottom">
                        <h4>Categoría</h4>
                        <p>{{ $service->category }}</p>
                        <div class="product-qty">
                            <h4>Módulos</h4>
                            <div class="quantity">
                                <p>{{ $service->modules }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="product-description">
                        <h4 class="mb-1">Descripción</h4>
                        <p>{{ $service->description }}</p>
                        {{-- <a href="#" class="btn btn-primary btn-block btn-lg">Add to Cart</a> --}}
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-b-60">
                <div class="simple-card">
                    <ul class="nav nav-tabs" id="myTab5" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active border-left-0" id="product-tab-1" data-toggle="tab" href="#tab-1" role="tab" aria-controls="product-tab-1" aria-selected="true">Tópicos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="product-tab-2" data-toggle="tab" href="#tab-2" role="tab" aria-controls="product-tab-2" aria-selected="false">Reviews</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent5">
                        <div class="tab-pane fade show active" id="tab-1" role="tabpanel" aria-labelledby="product-tab-1">
                            <p>Praesent et cursus quam. Etiam vulputate est et metus pellentesque iaculis. Suspendisse nec urna augue. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubiliaurae.</p>
                            <p>Nam condimentum erat aliquet rutrum fringilla. Suspendisse potenti. Vestibulum placerat elementum sollicitudin. Aliquam consequat molestie tortor, et dignissim quam blandit nec. Donec tincidunt dui libero, ac convallis urna dapibus eu. Praesent volutpat mi eget diam efficitur, a mollis quam ultricies. Morbi eu turpis odio.</p>
                            <ul class="list-unstyled arrow">
                                <li>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                                <li>Donec ut elit sodales, dignissim elit et, sollicitudin nulla.</li>
                                <li>Donec at leo sed nisl vestibulum fermentum.
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="tab-2" role="tabpanel" aria-labelledby="product-tab-2">
                            <div class="review-block">
                                <p class="review-text font-italic m-0">“Vestibulum cursus felis vel arcu convallis, viverra commodo felis bibendum. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin non auctor est, sed lacinia velit. Orci varius natoque penatibus et magnis dis parturient montes nascetur ridiculus mus.”</p>
                                <div class="rating-star mb-4">
                                    <i class="fa fa-fw fa-star"></i>
                                    <i class="fa fa-fw fa-star"></i>
                                    <i class="fa fa-fw fa-star"></i>
                                    <i class="fa fa-fw fa-star"></i>
                                    <i class="fa fa-fw fa-star"></i>
                                </div>
                                <span class="text-dark font-weight-bold">Virgina G. Lightfoot</span><small class="text-mute"> (Company name)</small>
                            </div>
                            <div class="review-block border-top mt-3 pt-3">
                                <p class="review-text font-italic m-0">“Integer pretium laoreet mi ultrices tincidunt. Suspendisse eget risus nec sapien malesuada ullamcorper eu ac sapien. Maecenas nulla orci, varius ac tincidunt non, ornare a sem. Aliquam sed massa volutpat, aliquet nibh sit amet, tincidunt ex. Donec interdum pharetra dignissim.”</p>
                                <div class="rating-star mb-4">
                                    <i class="fa fa-fw fa-star"></i>
                                    <i class="fa fa-fw fa-star"></i>
                                    <i class="fa fa-fw fa-star"></i>
                                    <i class="fa fa-fw fa-star"></i>
                                    <i class="fa fa-fw fa-star"></i>
                                </div>
                                <span class="text-dark font-weight-bold">Ruby B. Matheny</span><small class="text-mute"> (Company name)</small>
                            </div>
                            <div class="review-block  border-top mt-3 pt-3">
                                <p class="review-text font-italic m-0">“ Cras non rutrum neque. Sed lacinia ex elit, vel viverra nisl faucibus eu. Aenean faucibus neque vestibulum condimentum maximus. In id porttitor nisi. Quisque sit amet commodo arcu, cursus pharetra elit. Nam tincidunt lobortis augueat euismod ante sodales non. ”</p>
                                <div class="rating-star mb-4">
                                    <i class="fa fa-fw fa-star"></i>
                                    <i class="fa fa-fw fa-star"></i>
                                    <i class="fa fa-fw fa-star"></i>
                                    <i class="fa fa-fw fa-star"></i>
                                    <i class="fa fa-fw fa-star"></i>
                                </div>
                                <span class="text-dark font-weight-bold">Gloria S. Castillo</span><small class="text-mute"> (Company name)</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection