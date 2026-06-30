@extends('admin.layouts.master', ['title' => 'New Institution'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.institutions.index') }}">Institutions</a>
                <i class="fa-solid fa-chevron-right"></i> New
            </div>
            <div class="pt">New Institution</div>
            <div class="pst">Register an institution under an organisation</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.institutions.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.modules.institution._form')
    </form>
</div>
@endsection
