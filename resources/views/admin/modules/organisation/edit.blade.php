@extends('admin.layouts.master', ['title' => 'Edit Organisation'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.organisations.index') }}">Organisations</a>
                <i class="fa-solid fa-chevron-right"></i>
                <a href="{{ route('admin.organisations.show', $organisation) }}">{{ $organisation->name }}</a>
                <i class="fa-solid fa-chevron-right"></i> Edit
            </div>
            <div class="pt">Edit Organisation</div>
            <div class="pst">{{ $organisation->name }}</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.organisations.update', $organisation) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.modules.organisation._form')
    </form>
</div>
@endsection
