var ClientsQueryBuilderField =  {

    created: function () {
        this.setPlaceHolder();
      },

    data: function () {
        var selected;

        selected = this.column.operators[0];

        return {
            selected: selected,
            placeholder: '',
            value: {min:'00000', max:'99999', text:''},
        }
      },

    methods: {
        setPlaceHolder: function (val) {
            var placeholder;
            
            for(var i= 0; i < this.operators.length; i++)
            {
                if (this.operators[i].id === this.selected) {
                    placeholder = this.operators[i].placeholder
                }
            }
            
            this.placeholder = placeholder
        },
    },

    watch: {
        selected: function () {
            this.setPlaceHolder();
        },
        value: {
            handler: function () {
                this.setSearchQuery();
            },
            deep: true
        }
    },
    
    props: {
        column: Object,
        operators: Array
    },

    template: `
                    <div class="form-group form-row">
                        <div class="col-3">
                            <label for="clients-query-builder-field" class="col-form-label">{{ column.name }}</label>
                        </div>
                        <div class="col-4">
                            <select class="custom-select" v-bind:id="column.id" v-bind:name="column.id+'O'" v-model="selected">
                                <option
                                    v-for="operator in operators" 
                                    v-bind:value="operator.id"
                                    v-if="column.operators.indexOf(operator.id) !== -1"
                                    v-bind:selected="column.operators.indexOf(operator.id) === 0">
                                        {{ operator.text }}
                                </option>
                            </select>
                        </div>
                        <div class="col-5">
                            <div v-if="selected == 'between'">
                                <div class="input-group">
                                    <input type="number" class="form-control" v-model="value.min" v-bind:id="column.id" name="betweenMin" placeholder="00000" min="0">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><</span>
                                    </div>
                                    <input type="number" class="form-control" v-model="value.max" v-bind:id="column.id" name="betweenMax" placeholder="99999" max="99999">
                                </div>
                            </div>
                            <div v-else>
                                <input type="text" class="form-control" v-bind:id="column.id" v-bind:name="column.id+'V'" v-model="value.text" v-bind:placeholder="placeholder">
                            </div>
                        </div>
                    </div>`
}

var ClientsQueryBuilder = {

    components: {
      'clients-query-builder-field': ClientsQueryBuilderField
    },

    methods:{
      checkForm: function (e) {
          var x = e.target;
          var query = [];
          e.preventDefault();
          console.log(e);
          
          for (i = 0; i < x.length; i++) {
              var y = x.elements[i];
              console.log(y);
              if (y.tagName == "SELECT" || y.tagName == "INPUT") {
                if (y.tagName == "SELECT") {
                    query.push({name: y.id+'Operator', value: y.value})
                }
                if (y.tagName == "INPUT") {
                    query.push({name: y.id+'Value', value: y.value})
                }
              }
          }

          app.searchClients(query);
      }
    },

    props: {
        columns: Array,
        operators: Array
    },

    template: `
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <form v-on:submit="checkForm">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Query Builder</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <clients-query-builder-field
                    v-for="column in columns"
                    v-bind:column="column" 
                    v-bind:operators="operators">
                </clients-query-builder-field>
            </div>
            <div class="modal-footer">
              <button type="reset" class="btn btn-secondary">Reset</button>
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
          </div>
        </div>
      </div>`,
  }