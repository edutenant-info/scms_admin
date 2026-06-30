@extends('admin.layouts.master', ['title' => 'New Institution Type'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.institution-types.index') }}">Institution Types</a>
                <i class="fa-solid fa-chevron-right"></i> New
            </div>
            <div class="pt">New Institution Type</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.institution-types.store') }}">
        @csrf
        @include('admin.settings.institution-types._form')
    </form>
</div>
@endsection
