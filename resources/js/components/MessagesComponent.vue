<template>
    <div>
        <nav aria-label="Pagination">
            <div class="offset-5 col-2 pagination justify-content-center btn-group btn-group-toggle my-3" data-toggle="buttons">
                <label class="btn btn-secondary" v-bind:class="{active: computedDisplayType === 0}">
                    <input type="radio" @click="catchChange(0)" checked> Posts
                </label>
                <label class="btn btn-secondary" v-bind:class="{active: computedDisplayType === 1}">
                    <input type="radio" @click="catchChange(1)"> Quotes
                </label>
                <label class="btn btn-secondary" v-bind:class="{active: computedDisplayType === 2}" v-if="hasPersonality === '1'">
                    <input type="radio" @click="catchChange(2)"> Personality
                </label>
            </div>
        </nav>
        <div v-if="displayedData.data != null && displayedData.data.length > 0 && computedDisplayType !== 2">
            <div v-for="(post, index) in displayedData.data" class="row justify-content-md-left mt-1 mb-2" id="posts">
                {{post.content}}
            </div>
        </div>
        <div v-else-if="computedDisplayType === 2">
            <chart-component
                :labels="chartLabels"
                :data-prop="chartData"></chart-component>
        </div>
        <div v-else-if="dataLoaded === true">
            <div class="row justify-content-md-center pt-3" id="noneFound">
                No {{ (computedDisplayType === 0) ? 'posts' : 'quotes' }} found, <a class="pl-1" href="#" id="addQuotes">add some now.</a>
            </div>
        </div>
        <div v-else>
            <div class="row justify-content-md-center pt-3" id="loadingData">
                <div class="spinner-grow" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
        <pagination :data="displayedData" @pagination-change-page="getResults" :limit="limit" v-if="showPagination === 1"></pagination>
    </div>
</template>

<script>
    import ChartComponent from "./ChartComponent";
    export default {
        name: 'message-component',
        components: {ChartComponent},
        props: ['quotes', 'posts', 'profileId', 'hasPersonality', 'dimensions'],
        mounted() {
            console.log('Component mounted.');
            console.log(this.hasPersonality);
            console.dir(JSON.parse(this.dimensions));
        },

        data() {
            return{
                /*
                computedDisplayType: integer
                0 = displaying posts, 1 = displaying quotes.

                displayedData: object
                Contains loaded data from the controller.

                page: number
                Current page for pagination.

                dataLoaded: boolean
                Whether or not valid data has been loaded from the back-end, or has finished loading.
                */

                computedDisplayType: 0,
                displayedData: {},
                page: 1,
                dataLoaded: false,
                limit: 1,
                chartLabels:JSON.stringify(['Openness', 'Conscientiousness', 'Extraversion', 'Agreeableness', 'Neuroticism']),
                chartData:JSON.stringify(Object.values(JSON.parse(this.dimensions)).map(x => (x * 100).toFixed(4))),
                showPagination: 1,
            };
        },

        created() {
            this.getResults();
        },

        methods: {
            catchChange(type){
                if(this.computedDisplayType !== type){
                    this.computedDisplayType = type;
                    if(this.computedDisplayType !== 2)
                        this.getResults(1);
                    else
                        this.showPagination = 0;
                }
            },

            /*
            Fetches the result from the MessagesController.php.
            GET URL: /{profile}/messages/{displayType: <0 or 1>}/show?page={pagenumber}
             */
            getResults(page){
                if(typeof page === 'undefined'){
                    page = 1;
                }
                this.page = page;
                this.dataLoaded = false;

                axios.get('/profile/' + this.profileId + '/messages/' + this.computedDisplayType + '/show?page=' + page)
                .then(response => {
                    this.displayedData = response.data;
                    this.dataLoaded = true;
                    this.showPagination = 1;
                });
            }
        },
    }
</script>
