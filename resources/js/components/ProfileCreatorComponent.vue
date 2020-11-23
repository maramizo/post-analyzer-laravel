<template>
    <div class="container">
        <div class="row justify-content-md-center pt-5">
            <div class="form-group">
                <label>Wikipedia Name</label>
                <autocomplete
                    source="/wiki/"
                    results-property="search"
                    results-display="title"
                    results-value="title"
                    input-class="form-control"
                    placeholder="John Doe"
                    @selected="showDescription">
                </autocomplete>
            </div>
            <div class="form-group offset-3">
                <label>Twitter Handle/URL</label>
                <autocomplete
                    source="/x/"
                    results-property="search"
                    results-display="title"
                    results-value="title"
                    input-class="form-control"
                    placeholder="Handle/URL"
                    @selected="showDescription">
                </autocomplete>
            </div>
        </div>
        <form action="/profile/store" enctype="multipart/form-data" method="post">
            <input type="hidden" name="_token" v-bind:value="csrf">
            <input type="hidden" name="name" v-bind:value="name">
            <input type="hidden" name="id" v-bind:value="id">
            <input type="hidden" name="thumbnail" v-bind:value="thumbnail">
            <input type="hidden" name="description" v-bind:value="description">
            <div class="row pt-5 d-flex">
                <img v-if="thumbnail && thumbnail.length > 0" :src="thumbnail" alt="" class="rounded-circle w-15">
                <div class="d-flex flex-column col-5">
                    <h2 class="form-text">{{name}}</h2>
                    <h5 id="description" class="form-text text-muted ml-1" v-if="description && description.length > 0">{{ description }}</h5>
                    <button type="submit" class="btn btn-primary mt-auto mr-5" v-if="description && description.length > 0">Create</button>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
    export default {
        name:'profile-creator',
        props: ['csrf'],
        data(){
            return {
                description: '',
                group: '',
                thumbnail: '',
                name: '',
                id: 0,
            }
        },
        methods: {

            showDescription: function(item){
                axios.get('/wiki/detailed/' + item.display).then(response => {
                    this.description = response.data.description;
                    this.thumbnail = response.data.thumbnail;
                    this.name = item.display;
                    this.id = response.data.id;
                    console.dir(response.data);
                });
            },

            createNew: function(item){

            }
        }
    }
</script>
