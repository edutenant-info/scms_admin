@extends('admin.layouts.master', ['title' => 'New Language'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.languages.index') }}">Languages</a>
                <i class="fa-solid fa-chevron-right"></i> New
            </div>
            <div class="pt">New Language</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.languages.store') }}">
        @csrf
        @include('admin.masters.demographic.languages._form')
    </form>
</div>
@endsection
