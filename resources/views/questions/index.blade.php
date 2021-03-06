@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justfy-content-center">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h2>All Questions</h2>
                        <div class="ml-auto">
                            <a href="{{ route('questions.create') }}" class="btn btn-secondary"> Ask Question </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                        @include('layouts._message')

                        @forelse($questions as $question)
                            @include('questions._excerpt')    
                        @empty
                            <div class="alert alert-warning">
                                <strong>Sorry,</strong> There are no Questions here.
                            </div>
                        @endforelse

                       {{ $questions->links() }}

                </div>

            </div>
        </div>
    </div>
</div>

@endsection
