@extends('admin.layouts.master', ['title' => 'New Combination'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.combinations.index') }}">Combinations</a>
                <i class="fa-solid fa-chevron-right"></i> New
            </div>
            <div class="pt">New Combination</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.combinations.store') }}">
        @csrf
        @include('admin.masters.academic.combinations._form')
    </form>
</div>
@endsection
