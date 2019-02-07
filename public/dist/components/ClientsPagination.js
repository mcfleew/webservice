var ClientsPagination = {
    
    methods: {
        paginateClients: function(myApiURL) {
            app.showSomeClients(myApiURL);
        }
    },

    props: {
        links: Array
    },

    template: `
        <nav aria-label="...">
            <ul class="pagination justify-content-center" role="navigation">
                <li class="page-item"
                    v-for="link in links" v-bind:class="{ active: link.isActive, disabled: link.isDisabled }">
                <a class="page-link" href="#" 
                    v-if="link.showLink" v-on:click="paginateClients(link.url)" v-html="link.text"></a>
                <span class="page-link" 
                    v-if="link.showSpan" v-bind:rel="link.relation" v-html="link.text"></span>
                </li>
            </ul>
        </nav>`,
    }