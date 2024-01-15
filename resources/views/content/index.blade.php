@extends("layouts.main")

@section("content")

    <div class="position-relative">
        <section class="home-slider owl-carousel">
            <div class="slider-item" style="background-image:url(assets/images/bg_1.jpg);"
                 data-stellar-background-ratio="0.5">
                <div class="overlay"></div>
                <div class="container">
                    <div class="row no-gutters slider-text align-items-center justify-content-end"
                         data-scrollax-parent="true">
                        <div class="col-md-6 text ftco-animate">
                            <h1 class="mb-4">Helping Your <span>Stay Happy One</span></h1>
                            <h3 class="subheading">Everyday We Bring Hope and Smile to the Patient We Serve</h3>
                            <p><a href="#" class="btn btn-secondary px-4 py-3 mt-3">View our works</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="slider-item" style="background-image:url(assets/images/bg_2.jpg);">
                <div class="overlay"></div>
                <div class="container">
                    <div class="row no-gutters slider-text align-items-center justify-content-end"
                         data-scrollax-parent="true">
                        <div class="col-md-6 text ftco-animate">
                            <h1 class="mb-4">Smile Makes <br>A Lasting Impression</h1>
                            <h3 class="subheading">Your Health is Our Top Priority with Comprehensive, Affordable
                                medical.</h3>
                            <p><a href="#" class="btn btn-secondary px-4 py-3 mt-3">View our works</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="position-absolute d-none d-lg-block border rounded p-3 text-center" style="top: 10%; right: 20px; background-color: #ffffff66; width: 90%; max-width: 350px">
            <form action="{{route('contact')}}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Your Name" name="name">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Your Phone" name="number">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Subject" name="mavzu">
                </div>
                <div class="form-group">
                            <textarea name="xabar" id="" rows="4" class="form-control"
                                      placeholder="Message"></textarea>
                </div>
                <div class="form-group">
                    <input type="submit" value="Send Message" class="btn btn-primary btn-block py-3 px-5">
                </div>
            </form>
        </div>
    </div>
    <section class="ftco-section ftco-no-pt ftco-no-pb">
        <div class="container">
            <div class="row no-gutters">
                <div class="col-md-5 p-md-5 img img-2 mt-5 mt-md-0"
                     style="background-image: url(assets/images/about.jpg);">
                </div>
                <div class="col-md-7 wrap-about py-4 py-md-5 ftco-animate">
                    <div class="heading-section mb-5">
                        <div class="pl-md-5 ml-md-5 pt-md-5">
                            <span class="subheading mb-2">Welcome to Dentista</span>
                            <h2 class="mb-2" style="font-size: 32px;">Medical specialty concerned with the care of
                                acutely ill hospitalized patients</h2>
                        </div>
                    </div>
                    <div class="pl-md-5 ml-md-5 mb-5">
                        <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.
                            It is a paradisematic country, in which roasted parts of sentences fly into your mouth. Even
                            the all-powerful Pointing has no control about the blind texts it is an almost
                            unorthographic life One day however a small line of blind text by the name of Lorem Ipsum
                            decided to leave for the far World of Grammar.</p>
                        <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.
                            It is a paradisematic country, in which roasted parts of sentences fly into your mouth.</p>
                        <div class="founder d-flex align-items-center mt-5">
                            <div class="img" style="background-image: url(assets/images/doc-1.jpg);"></div>
                            <div class="text pl-3">
                                <h3 class="mb-0">Dr. Paul Foster</h3>
                                <span class="position">CEO, Founder</span>
                            </div>
                        </div>
                    </div>
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
                            <div class="img w-100" style="background-image: url({{asset('storage/'.$post->photo)}}"
                                 );></div>
                            <div class="media-body p-2 mt-3">
                                <h3 class="heading">{{$post->title}}</h3>
                                <p>{{$post->short_content}}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>



    <section class="ftco-section ftco-services">
        <div class="container">
            <div class="row justify-content-center mb-5 pb-2">
                <div class="col-md-8 text-center heading-section ftco-animate">
                    <span class="subheading">Services</span>
                    <h2 class="mb-4">Our Clinic Services</h2>
                    <p>Separated they live in. A small river named Duden flows by their place and supplies it with the
                        necessary regelialia. It is a paradisematic country</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 d-flex services align-self-stretch p-4 ftco-animate">
                    <div class="media block-6 d-block text-center">
                        <div class="icon d-flex justify-content-center align-items-center">
                            <span class="flaticon-drilling"></span>
                        </div>
                        <div class="media-body p-2 mt-3">
                            <h3 class="heading">Dental Implants</h3>
                            <p>Even the all-powerful Pointing has no control about the blind texts it is an almost
                                unorthographic.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex services align-self-stretch p-4 ftco-animate">
                    <div class="media block-6 d-block text-center">
                        <div class="icon d-flex justify-content-center align-items-center">
                            <span class="flaticon-tooth"></span>
                        </div>
                        <div class="media-body p-2 mt-3">
                            <h3 class="heading">Cosmetic Dentistry</h3>
                            <p>Even the all-powerful Pointing has no control about the blind texts it is an almost
                                unorthographic.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex services align-self-stretch p-4 ftco-animate">
                    <div class="media block-6 d-block text-center">
                        <div class="icon d-flex justify-content-center align-items-center">
                            <span class="flaticon-dental-floss"></span>
                        </div>
                        <div class="media-body p-2 mt-3">
                            <h3 class="heading">Dental Care</h3>
                            <p>Even the all-powerful Pointing has no control about the blind texts it is an almost
                                unorthographic.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 d-flex services align-self-stretch p-4 ftco-animate">
                    <div class="media block-6 d-block text-center">
                        <div class="icon d-flex justify-content-center align-items-center">
                            <span class="flaticon-shiny-tooth"></span>
                        </div>
                        <div class="media-body p-2 mt-3">
                            <h3 class="heading">Teeth Whitening</h3>
                            <p>Even the all-powerful Pointing has no control about the blind texts it is an almost
                                unorthographic.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex services align-self-stretch p-4 ftco-animate">
                    <div class="media block-6 d-block text-center">
                        <div class="icon d-flex justify-content-center align-items-center">
                            <span class="flaticon-dentist-chair"></span>
                        </div>
                        <div class="media-body p-2 mt-3">
                            <h3 class="heading">Dental Calculus</h3>
                            <p>Even the all-powerful Pointing has no control about the blind texts it is an almost
                                unorthographic.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex services align-self-stretch p-4 ftco-animate">
                    <div class="media block-6 d-block text-center">
                        <div class="icon d-flex justify-content-center align-items-center">
                            <span class="flaticon-tooth-1"></span>
                        </div>
                        <div class="media-body p-2 mt-3">
                            <h3 class="heading">Periondontics</h3>
                            <p>Even the all-powerful Pointing has no control about the blind texts it is an almost
                                unorthographic.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex services align-self-stretch p-4 ftco-animate">
                    <div class="media block-6 d-block text-center">
                        <div class="icon d-flex justify-content-center align-items-center">
                            <span class="flaticon-tooth-with-braces"></span>
                        </div>
                        <div class="media-body p-2 mt-3">
                            <h3 class="heading">Clip &amp; Braces</h3>
                            <p>Even the all-powerful Pointing has no control about the blind texts it is an almost
                                unorthographic.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex services align-self-stretch p-4 ftco-animate">
                    <div class="media block-6 d-block text-center">
                        <div class="icon d-flex justify-content-center align-items-center">
                            <span class="flaticon-decayed-tooth"></span>
                        </div>
                        <div class="media-body p-2 mt-3">
                            <h3 class="heading">Root Canel</h3>
                            <p>Even the all-powerful Pointing has no control about the blind texts it is an almost
                                unorthographic.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section intro" style="background-image: url(assets/images/bg_3.jpg);"
             data-stellar-background-ratio="0.5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="mb-4">We promised to take care our patients and we delivered.</h3>
                    <p>A small river named Duden flows by their place and supplies it with the necessary regelialia. It
                        is a paradisematic country</p>
                </div>
            </div>
        </div>
    </section>



    <section class="ftco-section ftco-no-pt ftco-no-pb contact-section">
        <div class="container">

            <div class="row d-flex align-items-stretch no-gutters">

                <div class="col-md-6 p-4 p-md-5 order-md-last bg-light">
                    <form action="{{route('contact')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Your Name" name="name">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Your Phone" name="number">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Subject" name="mavzu">
                        </div>
                        <div class="form-group">
                            <textarea name="xabar" id="" cols="30" rows="7" class="form-control"
                                      placeholder="Message"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Send Message" class="btn btn-primary py-3 px-5">
                        </div>
                    </form>
                </div>

                <div class="col-md-6 d-flex align-items-stretch">
                    <div id="map">
                        <br>
                        <br>
                        <div>
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d445.2802671287937!2d69.23505694588235!3d41.34199249581635!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38ae8d557ee5f219%3A0x812188e67312b3c4!2sU-CLINIC!5e0!3m2!1suz!2s!4v1703486715121!5m2!1suz!2s"
                                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section contact-section">
        <div class="container">

            <div class="row d-flex mb-5 contact-info">

                <div class="col-md-12 mb-4">
                    <h2 class="h4">Contact Information</h2>
                </div>

                <div class="w-100"></div>
                <div class="col-md-3 d-flex">
                    <div class="bg-light d-flex align-self-stretch box p-4">
                        <p><span>Address:</span> U CLINIC, ул. Сариксув 4-тупик, дом 3, Tashkent</p>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="bg-light d-flex align-self-stretch box p-4">
                        <p><span>Phone:</span> <a href="tel://1234567920">+99891 333 47 74</a></p>
                    </div>
                </div>


            </div>
        </div>
    </section>

@endsection
