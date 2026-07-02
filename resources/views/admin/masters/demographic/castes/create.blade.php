@extends('admin.layouts.master', ['title' => 'New Caste'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.castes.index') }}">Castes</a>
                <i class="fa-solid fa-chevron-right"></i> New
            </div>
            <div class="pt">New Caste</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.castes.store') }}">
        @csrf
        @include('admin.masters.demographic.castes._form')
    </form>
</div>
@endsection
