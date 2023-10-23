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
                <div class="card p-5">
                    <img src="{{asset($project['image'])}}" width="50%" alt="">
                    <div class="mt-4">
                        <p><span  class="h5">Title :</span> {{$project['title']}}</p>
                        <p><span  class="h5">Slug :</span> {{$project['slug']}}</p>
                        <p><span  class="h5">Description :</span> {{$project['description']}}</p>
                    </div>

                </div>
             </div>
            </div>
        </div>
    </section>
</div>



@endsection
