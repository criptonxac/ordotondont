@extends("admin.dashbord")

@section('content')

    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> Yagiliklar jadvali</h4>

            <!-- Basic Bootstrap Table -->
            <div class="card">
                <h5 class="card-header">Yangiliklar jadvali</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Yangilik nomi</th>
                            <th>Short_content</th>
                            <th>Rasmi</th>
                        </tr>
                        </thead>

                        <tbody class="table-border-bottom-0">
                        @foreach($posts as $post)
                        <tr>
                            <td ><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{$post->title}}</strong></td>
                            <td> <strong>{{$post->short_content}}</strong></td>
                            <td>
                                <img src="{{asset('storage/'.$post->photo)}}" alt="Avatar" width="65" />
                            </td>
                            <td>
                                <div class="dropdown">
                                    <div>
                                        <a  href="{{route('edit',$post->id)}}"
                                        ><i class="bx bx-edit-alt me-1" style="color: #002a80"></i> </a>
                                        <a href="{{route('delete',$post->id)}}"
                                        ><i class="bx bx-trash me-1" style="color: red"></i> </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!--/ Basic Bootstrap Table -->


              <!-- / Footer -->

        <div class="content-backdrop fade"></div>
    </div>


@endsection
