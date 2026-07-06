@extends('admin.layouts.master', ['title' => 'New Fee Type Mapping'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.institution-fee-types.index') }}">Fee Type Mappings</a>
                <i class="fa-solid fa-chevron-right"></i> New
            </div>
            <div class="pt">New Fee Type Mapping</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.institution-fee-types.store') }}">
        @csrf
        @include('admin.masters.mappings.institution-fee-types._form')
    </form>
</div>
@endsection
