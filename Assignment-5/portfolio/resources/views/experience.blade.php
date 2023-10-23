@extends('layouts.app')


@section('content')


<div id="colorlib-main">
    <section class="ftco-section pt-4 mb-5 ftco-intro">
        <div class="container-fluid px-3 px-md-0">
            <div class="mb-4">
                <h2 class="text-uppercase">Experience</h2>
            </div>
            <div class="row experience">
                @foreach ($file as $item)
                <div class="col-md-3">
                    <div class="card bg-info mb-3" style="width: 22rem;">
                        <div class="card-body">
                            <h5 class="card-title"><strong>Position : </strong>{{ $item['position'] }}</h5>
                            <h5 class="card-title"><strong>Company : </strong>{{ $item['company'] }}</h5>
                            <h5 class="card-title"><strong>Time : </strong>{{ $item['time'] }}</h5>
                            <h5 class="card-title"><strong>Location : </strong>{{ $item['location'] }}</h5>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </section>
</div>



@endsection
