@extends('layouts.app')


@section('content')


<div id="colorlib-main">
    <section class="ftco-section pt-4 mb-5 ftco-intro">
        <div class="container-fluid px-3 px-md-0">
            <div class="mb-4">
                <h2 class="text-uppercase">projects</h2>
            </div>
            <div class="row project-list">
                @foreach ($data as $key => $item)
                    <div class="col-md-3">
                        <div class="card" style="width: 18rem;">
                            <img class="card-img-top" src="{{ asset($item['image']) }}" alt="project image">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item['title'] }}</h5>
                                <p class="card-text">{{ Str::limit($item['description'], 100, '...') }}</p>
                                <a href="{{ route('project-view', $item['id']) }}" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
</div>



@endsection
