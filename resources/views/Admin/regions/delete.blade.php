@extends('Admin.layouts.main')

@section("title", "regions - Delete")
@section("loading_txt", "Delete")

@section("content")
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Delete Region</h1>
    <a href="{{ route("admin.regions.show") }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
</div>

<div class="card p-3 mb-3" id="regions_wrapper">
    <div class="card-header mb-3">
        <h3 class="text-danger text-center mb-0">Are you sure you want to delete this Region?</h3>
    </div>
    <div class="d-flex justify-content-between" style="gap: 16px">
        <div class="w-100">
            <div class="form-group w-100">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" disabled  placeholder="Region Name" v-model="name">
            </div>
        </div>
    </div>
    <div class="form-group w-100 d-flex justify-content-center" style="gap: 16px">
        <a href="{{ route("admin.regions.show") }}" class="btn btn-secondary w-25">Cancel</a>
        <button class="btn btn-danger w-25" @click="deleteCat">Delete</button>
    </div>
</div>

@endSection

@section("scripts")
<script>
const { createApp, ref } = Vue

createApp({
    data() {
        return {
            id: '{{ $Region->id }}',
            name: '{{ $Region->name }}',
            description: '{{ $Region->description }}',
            thumbnail: null,
            thumbnail_path: '{{ $Region->thumbnail_path }}',
        }
    },
    methods: {
        handleChangeThumbnail(event) {
            this.thumbnail = event.target.files[0]
            this.thumbnail_path = URL.createObjectURL(event.target.files[0])
        },
        async deleteCat() {
            $('.loader').fadeIn().css('display', 'flex')
            try {
                const response = await axios.post(`{{ route("admin.regions.delete") }}`, {
                    id: this.id
                },
                );
                if (response.data.status === true) {
                    document.getElementById('errors').innerHTML = ''
                    let error = document.createElement('div')
                    error.classList = 'success'
                    error.innerHTML = response.data.message
                    document.getElementById('errors').append(error)
                    $('#errors').fadeIn('slow')
                    setTimeout(() => {
                        $('.loader').fadeOut()
                        $('#errors').fadeOut('slow')
                        window.location.href = '{{ route("admin.regions.show") }}'
                    }, 1300);
                } else {
                    $('.loader').fadeOut()
                    document.getElementById('errors').innerHTML = ''
                    $.each(response.data.errors, function (key, value) {
                        let error = document.createElement('div')
                        error.classList = 'error'
                        error.innerHTML = value
                        document.getElementById('errors').append(error)
                    });
                    $('#errors').fadeIn('slow')
                    setTimeout(() => {
                        $('#errors').fadeOut('slow')
                    }, 5000);
                }

            } catch (error) {
                document.getElementById('errors').innerHTML = ''
                let err = document.createElement('div')
                err.classList = 'error'
                err.innerHTML = 'server error try again later'
                document.getElementById('errors').append(err)
                $('#errors').fadeIn('slow')
                $('.loader').fadeOut()

                setTimeout(() => {
                    $('#errors').fadeOut('slow')
                }, 3500);

                console.error(error);
            }
        }
    },
}).mount('#regions_wrapper')
</script>
@endSection
