@extends("layouts.main")


@section("content")
    <section class="hero-wrap hero-wrap-2" style="background-image: url('assets/images/bg_1.jpg');" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <h1 class="mb-2 bread">Our Treatments &amp; Services</h1>
                    <p class="breadcrumbs"><span class="mr-2"><a href="{{route('main')}}">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Services <i class="ion-ios-arrow-forward"></i></span></p>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section ftco-services">
        <div class="container">
            <div class="row">
                @foreach($posts as $post)
                <div class="col-md-4 d-flex services align-self-stretch p-4 ftco-animate">
                    <div class="media block-6 d-block">
                        <div class="img w-100" style="background-image: url({{asset('storage/'.$post->photo)}}");></div>
                        <div class="media-body p-2 mt-3">
                            <h3 class="heading">{{$post->title}}</h3>
                            <p>{{$post->short_content}}</p>
                        </div>
                    </div>
                </div>
                @endforeach
{{--                <div class="col-md-4 d-flex services align-self-stretch p-4 ftco-animate">--}}
{{--                    <div class="media block-6 d-block">--}}
{{--                        <div class="img w-100" style="background-image: url(assets/images/rasm2);"></div>--}}
{{--                        <div class="media-body p-2 mt-3">--}}
{{--                            <h3 class="heading">Cosmetic Dentistry</h3>--}}
{{--                            <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic.</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-4 d-flex services align-self-stretch p-4 ftco-animate">--}}
{{--                    <div class="media block-6 d-block">--}}
{{--                        <div class="img w-100" style="background-image: url(assets/images/rasm3);"></div>--}}
{{--                        <div class="media-body p-2 mt-3">--}}
{{--                            <h3 class="heading">Dental Care</h3>--}}
{{--                            <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic.</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="col-md-4 d-flex services align-self-stretch p-4 ftco-animate">--}}
{{--                    <div class="media block-6 d-block">--}}
{{--                        <div class="img w-100" style="background-image: url(assets/images/rasm4);"></div>--}}
{{--                        <div class="media-body p-2 mt-3">--}}
{{--                            <h3 class="heading">Teeth Whitening</h3>--}}
{{--                            <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic.</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-4 d-flex services align-self-stretch p-4 ftco-animate">--}}
{{--                    <div class="media block-6 d-block">--}}
{{--                        <div class="img w-100" style="background-image: url(assets/images/rasm5);"></div>--}}
{{--                        <div class="media-body p-2 mt-3">--}}
{{--                            <h3 class="heading">Dental Calculus</h3>--}}
{{--                            <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic.</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-4 d-flex services align-self-stretch p-4 ftco-animate">--}}
{{--                    <div class="media block-6 d-block">--}}
{{--                        <div class="img w-100" style="background-image: url(assets/images/rasm6);"></div>--}}
{{--                        <div class="media-body p-2 mt-3">--}}
{{--                            <h3 class="heading">Periondontics</h3>--}}
{{--                            <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic.</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-4 d-flex services align-self-stretch p-4 ftco-animate">--}}
{{--                    <div class="media block-6 d-block">--}}
{{--                        <div class="img w-100" style="background-image: url(assets/images/rasm7);"></div>--}}
{{--                        <div class="media-body p-3 mt-4">--}}
{{--                            <h3 class="heading">Clip &amp; Braces</h3>--}}
{{--                            <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic.</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-4 d-flex services align-self-stretch p-4 ftco-animate">--}}
{{--                    <div class="media block-6 d-block">--}}
{{--                        <div class="img w-100" style="background-image: url(assets/images/dept-8.jpg);"></div>--}}
{{--                        <div class="media-body p-2 mt-3">--}}
{{--                            <h3 class="heading">Root Canel</h3>--}}
{{--                            <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic.</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
    </section>

@endsection
