@extends('layouts.app')


@section('content')


<div id="colorlib-main">
    <section class="ftco-section pt-4 mb-5 ftco-intro">
        <div class="container-fluid px-3 px-md-0">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-uppercase">Welcome to my portfolio</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="">
                        @foreach ($data as $item)
                            <div class="card p-5">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card p-3 bg-info" style="max-height: 500px; min-height: 500px">
                                            <div class="">
                                                <h3>Personal Information</h3>
                                            </div>
                                            <hr>
                                            <div class="">
                                                <img class="" width="20%" src="{{asset($item['image'])}}"  alt="profile">
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title">Name : {{$item['name']}}</h5>
                                                <h5 class="card-title">Phone : {{$item['phone']}}</h5>
                                                <h5 class="card-title">Email : {{$item['email']}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card p-3 bg-info" style="max-height: 500px; min-height: 500px">
                                            <div class="">
                                                <h3>Education Qualification</h3>
                                            </div>
                                            <hr>
                                            @foreach ($item['education'] as $value)
                                                <div class="card-body">
                                                    <h5 class="card-title">Degree : {{$value['degree']}}</h5>
                                                    <h5 class="card-title">Institution : {{$value['institution']}}</h5>
                                                    <h5 class="card-title">Passing year : {{$value['graduation_year']}}</h5>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>



@endsection
