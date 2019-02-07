<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>App</title>
    <link rel="stylesheet" 
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" 
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" 
          crossorigin="anonymous">
</head>
<body>
    <div id="app" class="container">
        <div class="jumbotron">
            <h1 class="text-secondary display-4">TP Webservice<small class="text-muted"> API REST</small></h1>
            <p class="lead">Application client-serveur de recherche client.</p>
            <hr class="my-4">
            <label for="itemsPerPage">Nombre de clients par page : @{{ itemsPerPage }}</label>
            <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#exampleModal">
                Filtrer la liste de clients
            </button>
            <clients-query-builder v-bind:columns="columns" v-bind:operators="operators"></clients-query-builder>
            <input type="range" class="custom-range" min="20" max="500" step="10" v-model="itemsPerPage" v-on:change="setPaginateRange">  
        </div>

        <clients-pagination v-bind:links="links"></clients-pagination>

        <table class="table table-hover table-striped table-sm">
            <thead>
                <tr class="bg-primary">
                </tr>
            </thead>
            <thead>
                <tr class="bg-info">
                    <th v-for="column in columns" class="p-3 bg-secondary text-white">@{{column.name}}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="client in clients">
                    <td class="text-secondary">@{{ client.guid }}</td>
                    <td class="text-secondary">@{{ client.first }}</td>
                    <td class="text-secondary">@{{ client.last }}</td>
                    <td class="text-secondary">@{{ client.street }}</td>
                    <td class="text-secondary">@{{ client.city }}</td>
                    <td class="text-secondary">@{{ client.zip }}</td>
            </tbody>
        </table>

        <clients-pagination v-bind:links="links"></clients-pagination>
    </div>
    <script src="https://unpkg.com/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/vue-router/dist/vue-router.js"></script>
    <script src="https://unpkg.com/vue2-storage/dist/vue2-storage.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="dist/components/ClientsPagination.js"></script>
    <script src="dist/components/ClientsQueryBuilder.js"></script>
    <script src="dist/app.js"></script>

    
</body>
</html>