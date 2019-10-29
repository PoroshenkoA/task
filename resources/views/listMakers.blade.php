@extends('layouts.app')

@section('content')

    <div class="container" id="elLOM">
        <div>
            <label>Get beer makers who produce beer type:
            <select style="display: inline;" v-model="filter" class="custom-select" id="inputGroupSelect01">
                <option selected value="">Все</option>
                <option v-for="(item,key) in avFilters" :value="item.name">@{{item.name}}</option>
            </select></label>
        </div>

        <ul v-if="filter.length==0" class="list-group">
            <li class="list-group-item" v-for="(item,key) in makers">@{{ item.name }}</li>
        </ul>

        <ul v-else class="list-group">
            <li class="list-group-item" v-for="(item,key) in beer" v-if="item.type===filter">@{{ item.maker }}</li>
        </ul>

    </div>

@endsection

@push('scripts')
    <script>
        var vLOM = new Vue({
            el: '#elLOM',
            data: {
                beer: [],
                filter: '',
                avFilters: [],
                makers: []
            },
            methods: {

            },
            created: function () {
                var _this = this;
                this.$http.get('/api/getAllForMakers')
                    .then(function (response) {
                        _this.beer = response.data.beer;
                    });
                this.$http.get('/api/getTypes')
                    .then(function (response) {
                        _this.avFilters = response.data.types;
                    });
                this.$http.get('/api/getMakers')
                    .then(function (response) {
                        _this.makers = response.data.makers;
                    });
            }
        });
    </script>
@endpush