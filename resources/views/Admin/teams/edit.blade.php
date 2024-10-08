@extends('Admin.layouts.main')

@section("title", "Teams - Edit")
@section("loading_txt", "Update")

@section("content")
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Update Team</h1>
    <a href="{{ route("admin.teams.show") }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
</div>
<div class="card p-3 mb-3" id="teams_wrapper">
    <div class="d-flex justify-content-between" style="gap: 16px">
        <div class="w-50">
            <div class="form-group w-100">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name"  placeholder="Team Name" v-model="name">
            </div>
            <div class="form-group w-100">
                <label for="name" class="form-label">Name in Arabic</label>
                <input type="text" class="form-control" id="name"  placeholder="Team Name in Arabic" v-model="name_ar">
            </div>
        </div>
        <div class="form-group w-50">
            <label for="Position" class="form-label">Position</label>
            <textarea rows="7" class="form-control" id="Position"  placeholder="Position" style="resize: none" v-model="position">
            </textarea>
            <br>
            <label for="Position_ar" class="form-label">Position in arabic</label>
            <textarea rows="7" class="form-control" id="Position"  placeholder="Position in arabic" style="resize: none" v-model="position_ar">
            </textarea>
            <div class="form-group pt-4 pb-4" style="width: max-content; height: 300px;min-width: 100%">
                <label for="thumbnail" class="w-100 h-100">
                    <svg v-if="!thumbnail && !thumbnail_path" xmlns="http://www.w3.org/2000/svg" className="icon icon-tabler icon-tabler-photo-up" width="24" height="24" viewBox="0 0 24 24" strokeWidth="1.5" style="width: 100%; height: 100%; object-fit: cover; padding: 10px; border: 1px solid; border-radius: 1rem" stroke="#043343" fill="none" strokeLinecap="round" strokeLinejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M15 8h.01" />
                        <path d="M12.5 21h-6.5a3 3 0 0 1 -3 -3v-12a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v6.5" />
                        <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l3.5 3.5" />
                        <path d="M14 14l1 -1c.679 -.653 1.473 -.829 2.214 -.526" />
                        <path d="M19 22v-6" />
                        <path d="M22 19l-3 -3l-3 3" />
                    </svg>
                    <img v-if="thumbnail_path" :src="thumbnail_path" style="width: 100%; height: 100%; object-fit: contain; padding: 10px; border: 1px solid; border-radius: 1rem" />
                </label>
            <input type="file" class="form-control d-none" id="thumbnail"  placeholder="Category Thumbnail Picture" @change="handleChangeThumbnail">
            </div>
        </div>
    </div>
    <div class="form-group">
        <button class="btn btn-success w-25" @click="update" style="display: block;margin: auto">Update</button>
    </div>
</div>

@endSection

@section("scripts")
<script>
const { createApp, ref } = Vue

createApp({
    data() {
        return {
            id: '{{ $team->id }}',
            category_id: '{{ $team->category_id }}',
            name: '{{ $team->name }}',
            position: @json($team->position),
            name_ar: '{{ $team->name_ar }}',
            position_ar: @json($team->position_ar),
            price: '{{ $team->price }}',
            type: '{{ $team->type }}',
            thumbnail: null,
            thumbnail_path: '{{ $team->photo_path }}',
            deletedGallery: [],
            images_path: [],
            images: []
        }
    },
    methods: {
        handleAddOption() {
            this.options.push({
                size: "",
                flavour: "",
                nicotine: "",
                price: "",
            })
        },
        handleRemoveOption(index) {
            this.options.splice(index, 1)
        },
        handleChangeThumbnail(event) {
            this.thumbnail = event.target.files[0]
            this.thumbnail_path = URL.createObjectURL(event.target.files[0])
        },
        handleChangeThumbnail(event) {
            this.thumbnail = event.target.files[0]
            this.thumbnail_path = URL.createObjectURL(event.target.files[0])
        },
        handleChangeImages(event) {
            let files = Array.from(event.target.files)
            files.map(file => {
                this.images.push(file)
                this.images_path.push(URL.createObjectURL(file))
            })
        },
        handleDeleteImage(index) {
            let arr = this.images
            arr.splice(index, 1)
            this.images = arr
            let arr_paths  = this.images_path
            arr_paths.splice(index, 1)
            this.images_path = arr_paths
        },
        handleDeleteImageFromGallery(index) {
            let dArr = this.deletedGallery
            dArr.push(this.gallery[index])
            this.deletedGallery = dArr
            let arr = this.gallery
            arr.splice(index, 1)
            this.gallery = arr
        },
        async update() {
            $('.loader').fadeIn().css('display', 'flex')
            try {
                const response = await axios.post(`{{ route("admin.teams.update") }}`, {
                    id: this.id,
                    name: this.name,
                    position: this.position,
                    name_ar: this.name_ar,
                    position_ar: this.position_ar,
                    main_image: this.thumbnail,
                },
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
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
                        window.location.href = '{{ route("admin.teams.show") }}'
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
}).mount('#teams_wrapper')
</script>
@endSection
