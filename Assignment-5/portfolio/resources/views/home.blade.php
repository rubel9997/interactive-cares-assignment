@extends('layouts.app')


@section('content')


<div id="colorlib-main">
    <section class="ftco-section pt-4 mb-5 ftco-intro">
        <div class="container-fluid px-3 px-md-0">
            <div class="row justify-content-center bold">
                <div class="row">
                    <div class="col-12">
                        <h2 class="text-uppercase">Welcome to my portfolio</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Personal Information</h3>
                            @foreach ($data as $item)
                            <div class="card" style="width:40rem;">
                                <img class="card-img-top object-fit-cover " src="{{asset($item['image'])}}"  alt="profile">
                                <div class="card-body">
                                  <h5 class="card-title">Name : {{$item['name']}}</h5>
                                  <h5 class="card-title">Phone : {{$item['phone']}}</h5>
                                  <h5 class="card-title">Email : {{$item['email']}}</h5>
                                    <h3>Education Qualification :</h3>
                                    @foreach ($item['education'] as $value)
                                    <div class="card">
                                        <div class="card-body">
                                            <p>{{$value['degree']}}</p>
                                            <p>{{$value['institution']}}</p>
                                            <p>{{$value['graduation_year']}}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                              </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>



@endsection
