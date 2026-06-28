@extends('admin.layouts.master', ['title' => 'New Organisation'])

@section('content')
<div class="vs active">
    <div class="ph">
        <div>
            <div class="pbc">
                <a href="{{ route('admin.organisations.index') }}">Organisations</a>
                <i class="fa-solid fa-chevron-right"></i> New
            </div>
            <div class="pt">New Organisation</div>
            <div class="pst">Onboard a new tenant organisation</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.organisations.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.modules.organisation._form')
    </form>
</div>
@endsection
