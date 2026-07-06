@extends('admin.layouts.master', ['title' => 'Edit Fee Type Mapping'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.institution-fee-types.index') }}">Fee Type Mappings</a>
                <i class="fa-solid fa-chevron-right"></i> Edit
            </div>
            <div class="pt">Edit Fee Type Mapping</div>
            <div class="pst">{{ $item->institution->name }} → {{ $item->feeType->name }}</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.institution-fee-types.update', $item) }}">
        @csrf
        @method('PUT')
        @include('admin.masters.mappings.institution-fee-types._form')
    </form>
</div>
@endsection
