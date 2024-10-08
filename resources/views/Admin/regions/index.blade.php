@extends('Admin.layouts.main')

@section("title", "Regions")

@php
    $regions = App\Models\Region::all();
@endphp

@section("content")
<style>
    #dataTable_wrapper{
        width: 100%
    }
</style>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Regions</h1>
    <a href="{{ route("admin.regions.add") }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-plus fa-sm text-white-50"></i> Create region</a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive" style="width: 100%;">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($regions as $cat)
                        <tr>
                            <td>{{ $cat->name }}</td>
                            <td>
                                <a href="{{ route("admin.regions.edit", ["id" => $cat->id]) }}" class="btn btn-success">Edit</a>
                                <a href="{{ route("admin.regions.delete.confirm", ["id" => $cat->id]) }}" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endSection


@section("scripts")
<script src="{{ asset('/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('/admin/js/demo/datatables-demo.js') }}"></script>
@endSection
