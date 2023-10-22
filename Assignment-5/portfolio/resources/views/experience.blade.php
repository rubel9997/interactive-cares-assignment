@extends('layouts.app')


@section('content')


<div id="colorlib-main">
    <section class="ftco-section pt-4 mb-5 ftco-intro">
        <div class="container-fluid px-3 px-md-0">
            <div class="row justify-content-center bold">
                <div class="mb-4">
                    <h2 class="text-uppercase">Experience</h2>
                </div>
            </div>
            <div class="row experience">
                @foreach ($file as $item)
                <div class="col-md-3">
                    <div class="card mb-3" style="width: 22rem;">
                        <div class="card-body">
                            <h5 class="card-title text-muted"><strong>Position:</strong>{{ $item['position'] }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted"><strong>Company:</strong>{{ $item['company'] }}</h6>
                            <p class="card-text">
                                <strong>Time:</strong> {{ $item['time'] }}<br>
                                <strong>Location:</strong> {{ $item['location'] }}
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </section>
</div>



@endsection
