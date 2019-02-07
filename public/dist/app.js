var apiURL = 'http://localhost:8000/api/v1/clients'
var searchURL = 'http://localhost:8000/api/v1/clients/search'

var ColumnG = { id: 'guid', name: 'Identifiant Universel', operators: ['contain', 'start']  }
var ColumnF = { id: 'first', name: 'Prénom', operators: ['start', 'contain'] }
var ColumnL = { id: 'last', name: 'Nom', operators: ['start', 'contain'] }
var ColumnS = { id: 'street', name: 'Rue', operators: ['contain'] }
var ColumnC = { id:'city', name: 'Ville', operators: ['list'] }
var ColumnZ = { id: 'zip', name: 'Code Postal', operators: ['between', 'start'] }

/**
 * Actual app
 */

var app = new Vue({

  el: '#app',

  components: {
    'clients-pagination': ClientsPagination,
    'clients-query-builder': ClientsQueryBuilder
  },

  data: {
    columns: [
      ColumnG,
      ColumnF,
      ColumnL,
      ColumnS,
      ColumnC,
      ColumnZ
    ],
    clients: null,
    links: null,
    itemsPerPage: 50,
    operators: [
      {id: 'start', text: 'Commence par', placeholder: '"P*" : Park, Pike'},
      {id: 'contain', text: 'Contient', placeholder: '"*way*" : Highway, Parkway'}, 
      {id: 'list', text: 'Liste', placeholder: '[Lyon, Paris] : Lyon, Paris'}, 
      {id: 'between', text: 'Valeur entre', placeholder: '00000 < zip < 99999'}
    ],
    searchData: [],
    searchQuery: '',
    searchText: ''
  },

  created: function () {
    for(var i= 0; i < this.columns.length; i++)
    {
        this.searchData[this.columns[i].id] = ''
    }
    this.showSomeClients()
  },

  methods: {
    showSomeClients: function (myApiURL) {
      var xhr = new XMLHttpRequest()
      var self = this

      if (typeof myApiURL == 'undefined')
        xhr.open('GET', apiURL)
      else
        xhr.open('GET', myApiURL)

      xhr.onload = function () {
        clients = JSON.parse(xhr.responseText)
        self.clients = clients.items
        self.errors = clients.errors
        self.links = clients.links
        
        if (xhr.status === 503) {
          self.clients = this.$storage.get('test', self.clients)
        } else {
          this.$storage.set('clients', self.clients, { ttl: 60 * 1000 })
        }
        
        
        localStorage.setItem('clients', JSON.stringify(self.clients))
      }
      xhr.send()
    },

    searchClients: function(dataQuery) {
      mySearchURL = searchURL + "?" + $.param(dataQuery)
      this.showSomeClients(mySearchURL)
    },

    setPaginateRange: function() {
      myPaginateURL = apiURL + "?itemsPerPage=" + this.itemsPerPage
      this.showSomeClients(myPaginateURL)
    },
  }
})