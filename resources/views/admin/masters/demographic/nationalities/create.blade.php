@extends('admin.layouts.master', ['title' => 'New Nationality'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.nationalities.index') }}">Nationalities</a>
                <i class="fa-solid fa-chevron-right"></i> New
            </div>
            <div class="pt">New Nationality</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.nationalities.store') }}">
        @csrf
        @include('admin.masters.demographic.nationalities._form')
    </form>
</div>
@endsection
