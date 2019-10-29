@extends('layouts.app')

@section('content')

    <div class="container" id="elLOT">
        <div class="input-group mb-3">
            <input type="text" v-model="filterType" class="form-control" placeholder="Filter by type"
                   aria-label="Username" aria-describedby="basic-addon1" @>
        </div>

        <div class="input-group mb-3">
            <input type="text" v-model="filterMaker" class="form-control" placeholder="Filter by Maker"
                   aria-label="Username" aria-describedby="basic-addon1">
        </div>

        <ul v-if="filterMaker.length === 0 && filterType.length === 0" class="list-group">
            <li v-for="(item,key) in beer" class="list-group-item" > @{{ item.type }}</li>
        </ul>

        <ul v-else class="list-group">
            <li v-for="(item,key) in filtered" class="list-group-item" > @{{ item.type }}</li>
        </ul>
    </div>

@endsection

@push('scripts')
    <script>
        var vLOT = new Vue({
            el: '#elLOT',
            data: {
                beer: [],
                filterType: '',
                filterMaker: '',
            },
            computed: {
                filtered() {
                    return this.beer.filter((item) => {
                        if(this.filterType == null){
                            if(item.maker.includes(this.filterMaker)){
                                return true;
                            }
                            return false
                        }
                        if(this.filterMaker == null){
                            if (item.type.includes(this.filterType)) {
                                return true;
                            }
                        }
                        if (item.type.includes(this.filterType) && item.maker.includes(this.filterMaker)){
                            return true;
                        };
                        return false;
                    });
                }
            },
            methods: {
            },
            created: function () {
                var _this = this;
                this.$http.get('/api/getAllForTypes')
                    .then(function (response) {
                        _this.beer = response.data.beer;
                    });
            }
        });
    </script>
@endpush