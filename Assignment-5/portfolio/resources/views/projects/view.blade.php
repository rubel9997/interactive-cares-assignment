@extends('layouts.app')


@section('content')


<div id="colorlib-main">
    <section class="ftco-section pt-4 mb-5 ftco-intro">
        <div class="container-fluid px-3 px-md-0">
            <div class="row justify-content-center">
                <div class="mb-4">
                    <h2 class="text-uppercase">Project Details</h2>
                </div>
            </div>
            <div class="row">
             <div class="col-md-12">
                <div class="">
                    <img src="{{asset($project['image'])}}" width="50%" alt="">
                    <p class="mt-3"><strong>Title : </strong>{{$project['title']}}</p>
                    <p class="mt-3"><strong>Slug : </strong>{{$project['slug']}}</p>
                    <p class="mt-3"><strong>Description : </strong>{{$project['description']}}</p>
                </div>
             </div>
            </div>
        </div>
    </section>
</div>



@endsection
