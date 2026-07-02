@extends('admin.layouts.master', ['title' => 'New Standard'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.standards.index') }}">Standards</a>
                <i class="fa-solid fa-chevron-right"></i> New
            </div>
            <div class="pt">New Standard</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.standards.store') }}">
        @csrf
        @include('admin.masters.academic.standards._form')
    </form>
</div>
@endsection
