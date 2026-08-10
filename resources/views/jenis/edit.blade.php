@extends('layouts.app')

@section('title', 'Edit Jenis')

@section('content')
<h4>Edit Jenis</h4>

<form action="{{ route('jenis.update', $jenis) }}" method="POST">
    @csrf
    @method('PUT')
    @include('jenis._form')
</form>
@endsection