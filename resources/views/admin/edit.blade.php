@extends("admin.dashbord")

    @section('content')
        <br>
        <br>

        <div class="col-xxl container-xxl">
            <div class="card md-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Yangilik Tahrirlash</h5>
                    <small class="text-muted float-end">Yangilik tahrirlash </small>
                </div>
                <div class="row">
                    <div class="card-body">
                        <form action="{{route('post.update',['post'=>$post->id])}}" method="post" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="row mb-3" >
                                <label class="col-sm-2 col-form-label text-center" style="display: flex; align-items: center; justify-content: center" for="basic-icon-default-fullname">Sarlavha</label>
                                <div class="col-sm-4">
                                    <div class="input-group input-group-merge">
                                  <span id="basic-icon-default-fullname2" class="input-group-text"
                                  ><i class="bx bx-text"></i
                                      ></span>
                                        <input
                                            type="text"
                                            name="title"
                                            value="{{$post->title}}"
                                            class="form-control"
                                            placeholder="John Doe"
                                            aria-label="John Doe"
                                            aria-describedby="basic-icon-default-fullname2">
                                        @error('title')
                                        <p class="help-block text-danger">{{@$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label text-center"  style="display: flex; align-items: center; justify-content: center"  for="basic-icon-default-company">malumot</label>
                                <div class="col-sm-4">
                                    <div class="input-group input-group-merge">
                                  <span id="basic-icon-default-company2" class="input-group-text"
                                  ><i class="bx bx-comment-detail"></i
                                      ></span>
                                        <input
                                            type="text"
                                            name="short_content"
                                            value="{{$post->short_content}}"
                                            id="basic-icon-default-company"
                                            class="form-control"
                                            placeholder="ACME Inc."
                                            aria-label="ACME Inc."
                                            aria-describedby="basic-icon-default-company2"

                                        />
                                        @error('short_content')
                                        <p class="help-block text-danger">{{@$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label text-center"    for="basic-icon-default-email">Rasm yuklang</label>
                                <div class="col-sm-4">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-photo-album"></i></span>
                                        <input
                                            type="file"
                                            id="basic-icon-default-email"
                                            class="form-control"
                                            name="photo"
                                            value="{{$post->photo}}"

                                        />
                                        @error('photo')
                                        <p class="help-block text-danger">{{@$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="form-text">You can use letters, numbers & periods</div>
                                </div>
                            </div>

                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Saqlash</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    @endsection
