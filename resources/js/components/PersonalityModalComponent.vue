<template>
    <div>
        <div class="pl-1 pt-1" v-if="hasPersonality === '0'">
            <a href="#">
                <button type="button" data-toggle="modal" data-target="#loadMessages" class="btn btn-primary">Check Personality</button>
            </a>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="loadMessages" tabindex="-1" role="dialog" aria-labelledby="loadMessages" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">New Posts</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="twitterAccount">Twitter URL</label>
                            <input type="text" class="form-control" id="twitterAccount" placeholder="Enter Twitter URL">
                        </div>
                        <div class="form-group">
                            <label for="wikiQuotesPage">WikiQuotes Name</label>
                            <input type="text" class="form-control" id="wikiQuotesPage" placeholder="Enter Name on WikiQuotes">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary">Next</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'personality-modal-component',
    props: ['hasPersonality', 'test'],
    mounted() {
        console.log(this.hasPersonality);
    },

    methods: {
    },
}
</script>
